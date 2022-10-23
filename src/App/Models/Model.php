<?php

namespace AkemiAdam\Basilisk\App\Models;

use AkemiAdam\Basilisk\App\Kernel\Base;

abstract class Model
{
    use Base;

    protected $connection;

    protected string $table;

    protected array $columns;

    protected string $query;

    protected string $fields;

    protected array $options;

    /**
     * Get the connection with the database and define the table name, after, define the columns
     * 
     * @param string $table
     * 
     *@return void
     */
    public function __construct(string $table = '')
    {
        try {
            $this->connection = require __DIR__ . '/../../../config/connection.php';
        } catch (\PDOException $e) {
            print('Houve um erro ao criar a conexão: ' . $e->getMessage());
        }

        $this->table = empty($table) ? $this->getTableName() : $table;

        $this->columns = $this->getColumns();

        $this->reset();
    }

    protected function reset() : void
    {
        $this->fields = '*';

        $this->query = 'SELECT ' . $this->fields . ' FROM ' . $this->table . ' ';

        $this->options = array(
            'where' => [],
            'order' => [
                'position' => 'asc',
                'column' => ''
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
        $sttm = $this->connection->query('DESCRIBE ' . $this->table);

        return $sttm->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * Returns the table name
     * 
     * @return string
     */
    protected function getTableName() : string
    {
        $namespace = strtolower(Model::class);

        $arr = explode('\\', $namespace);

        $table = end($arr) . 's';

        return $table;
    }

    /**
     * Verify if value is a string
     * 
     * @param mixed $value
     * 
     * @return mixed
     */
    protected function isString(mixed $value) : mixed
    {
        return \gettype($value) == 'string' ? "'$value'" : $value;
    }

    /**
     * Insert a new row into the table
     * 
     * @param array $data
     * 
     * @return void
     */
    public function insert(array $data) : void
    {
        $keys = array();

        $values = array();

        $statement = 'INSERT INTO ' . $this->table . ' (';

        foreach ($data as $key => $value) {
            
            $keys[] = $key;

            $values[] = $this->isString($value);

        }

        $statement .= implode(', ', $keys) . ') VALUES (' . implode(', ',  $values) . ')';

        try {
            $this->connection->query($statement);
        } catch (\PDOException $e) {
            print($e->getMessage());
        }
    }

    /**
     * Returns an array with all results of a table
     * 
     * @return array
     */
    public function all() : array
    {
        $statement = $this->connection->prepare('SELECT * FROM ' . $this->table);
        
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * Returns all rows based on a given query
     * 
     * @return array
     */
    public function get() : array
    {
        $this->query .= implode(', ', $this->options['where']) . ' ORDER BY ' . $this->options['order']['column'] . ' ' . $this->options['order']['position'];

        var_dump($this->query);

        $result = $this->connection->prepare($this->query);

        $result->execute();

        $this->reset();

        return $result->fetchAll();
    }

    /**
     * Add a option where for query
     * 
     * @param string $column
     * @param mixed $value
     * @param string $operator
     * 
     * @return Model
     */
    public function where(string $column, mixed $value, string $operator = '=') : Model
    {
        $value = $this->isString($value);

        $this->options['where'][] .= 'WHERE ' . $column . " $operator $value ";

        return $this;
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
}