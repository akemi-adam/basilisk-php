<?php

namespace AkemiAdam\Basilisk\App\Komodo;

use AkemiAdam\Basilisk\Exceptions\Database\CollumnNotFoundInTheTableException;


#[\AllowDynamicProperties]
abstract class Model
{
    protected static string|null $table;

    private array $columns;

    private string $query;

    private string $statement;

    private string $fields;

    private array $options;

    protected string $primaryKey = 'id';

    public function __construct(string|null $table = null)
    {
        static::$table = $table ?? static::getTableName();

        $this->columns = $this->getColumns();

        $this->reset();
    }

    /**
     * Resets the default values of query mounting
     * 
     * @return void
     */
    protected function reset() : void
    {
        $this->fields = '*';

        $this->query = sprintf("SELECT %s FROM %s ", $this->fields, static::getTableName());

        $this->options = array(
            'where' => '',
            'order' => [
                'position' => 'asc',
                'column' => 'id'
            ],
            'join' => [],
        );
    }

    /**
     * Returns the columns names
     * 
     * @return array
     */
    protected function getColumns() : array
    {
        $sttm = \get_connection()->query('DESCRIBE ' . static::getTableName());

        return $sttm->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * Returns the table name
     * 
     * @return string
     */
    public static function getTableName() : string
    {
        if (isset(static::$table)) return static::$table;

        $namespace = strtolower(get_called_class()); //$this
        
        $entityName = explode('\\', $namespace);

        return end($entityName) . 's';
    }

    /**
     * Insert a new row into the table
     * 
     * @param array $data
     * 
     * @return object
     */
    public static function create(array $data) : object
    {
        $statement = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)", static::getTableName(),
            implode(', ', array_keys($data)),
            implode(', ', array_map(fn ($value) => \isString($value), $data)),
        );

        $model = null;

        try {
            \get_connection()->query($statement);
            
            $query = "SELECT * FROM " . static::getTableName() . " WHERE ";

            $query .= implode(' ', array_map(
                fn ($value, $column) => sprintf("%s %s",
                    (array_key_first($data) === $column) ? '' : ' AND ',
                    "$column = " . (\isString($value))
                ),
                $data,
                array_keys($data)
            ));

            $model = \get_connection()->query($query);

        } catch (\PDOException $e) {
            print($e->getMessage());
        }

        return $model->fetchAll(\PDO::FETCH_CLASS, get_called_class())[0];
    }

    /**
     * Returns an array with all results of a table
     * 
     * @return array
     */
    public static function all() : array
    {
        $statement = \get_connection()->prepare("SELECT * FROM " . static::getTableName());
        
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_CLASS, get_called_class());
    }

    /**
     * Returns all rows based on a given query
     * 
     * @return array
     */
    public function get() : array
    {
        $this->query .= sprintf(
            "%s ORDER BY %s %s", $this->options['where'], $this->options['order']['column'], $this->options['order']['position']
        );

        $result = \get_connection()->prepare($this->query);

        $result->execute();

        $this->reset();

        return $result->fetchAll(\PDO::FETCH_CLASS, get_called_class());
    }

    /**
     * Add a option where for query
     * 
     * @param string $column
     * @param mixed $value
     * @param string $operator = '='
     * @param string $relationalOperator = 'AND'
     * @param bool $whereNotOption = false
     * 
     * @return Model
     */
    public function where(string $column, mixed $value, string $operator = '=', string $relationalOperator = 'AND', bool $whereNotOption = false) : Model
    {
        $value = \isString($value);

        $expression = "$column $operator $value";

        $whereNotOption = $whereNotOption ? 'NOT' : ''; 

        $this->options['where'] .= !$this->options['where'] ?
            "WHERE $whereNotOption $expression" : "$relationalOperator $whereNotOption $expression";

        return $this;
    }

    public static function init() : static
    {
        return new static();
    }

    /**
     * Defines the order in which the rows will be retrieved from the database
     * 
     * @param string $column
     * @param string $order
     * 
     * @return Model
     */
    public function orderBy(string $column, string $order = 'asc') : Model
    {
        $this->options['order']['column'] = $column;

        $this->options['order']['position'] = $order;

        return $this;
    }

    /*
     * Saves a new model in database based in dynamics properties that match with collumns of table
     *
     * @return object|false
     */
    public function save() : object|false
    {
        $dynamicsProperties = \get_dynamics_properties($this);

        $columns = '';

        $values = '';

        $count = 0;

        foreach ($dynamicsProperties as $property => $value)
        {
            $count++;
            
            try {
                if (!in_array($property, $this->columns))
                    throw new CollumnNotFoundInTheTableException(static::getTableName());
        
                $nextElementExists = $count === sizeof($dynamicsProperties) ? '' : ', ';
                
                $columns .= sprintf("%s%s", $property, $nextElementExists);

                $values .= sprintf("%s%s", \isString($value), $nextElementExists);
                
            } catch (CollumnNotFoundInTheTableException $e) {
                print $e->getMessage(); 
                return false;
            }
        }

        try {
            \get_connection()->query("INSERT INTO " . static::getTableName() . " ($columns) VALUES ($values)");
        } catch (\PDOException $e) {
            print($e->getMessage());
        }

        return $this;
    }

    /*
     * Returns a existing entity as model by id
     *
     * @param int|string $id
     * @param string $primaryKey = 'id'
     *
     * @return object
     */
    public static function find(int|string $id, string $primaryKey = 'id') : object
    {
        $statement = \get_connection()->prepare(
            sprintf("SELECT * FROM %s WHERE $primaryKey = :primaryKey", static::getTableName())
        );

        $statement->bindValue('primaryKey', $id, (is_string($id) ? \PDO::PARAM_STR : \PDO::PARAM_INT));

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_CLASS, get_called_class())[0];
    }

    /*
     * Deletes the model
     *
     * @return bool
     */
    public function delete() : bool
    {
        $statement = \get_connection()->prepare(
            sprintf("DELETE FROM %s WHERE %s = %s", static::getTableName(), $this->primaryKey, $this->{$this->primaryKey})
        );

        return $statement->execute();
    }

    /**
     * Update a specif model
     * 
     * @param array $data
     * 
     * @return object
     */
    public function update(array $data) : object
    {
        $updateds = array_map(fn ($value, $collumn) : string => "$collumn = " . \isString($value), $data, array_keys($data));

        $statement = \get_connection()->prepare(
            sprintf(
                "UPDATE %s SET %s WHERE %s = %s", static::getTableName(), implode(', ', $updateds), $this->primaryKey, $this->{$this->primaryKey}
            )
        );

        $statement->execute();

        foreach($data as $collumn => $value) $this->{$collumn} = $value;

        return $this;
    }
}
