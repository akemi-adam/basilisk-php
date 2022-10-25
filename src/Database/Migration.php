<?php

namespace AkemiAdam\Basilisk\Database;

class Migration
{
    protected string $statement;

    protected string $table;

    protected array $scope;

    protected string $uniques;

    protected $connection;

    public function __construct(string $table) {
        
        $this->scope = array();

        $this->uniques = '';

        $this->table = $table;

        $this->connection = require __DIR__ . '/../../config/connection.php';

    }

    protected function setAttribute(string $attribute, string $type, mixed $size)
    {
        $row = $attribute . " $type";

        is_null($size) ?
            $this->scope[$attribute] = $row :
            $this->scope[$attribute] = $row . "($size)";
    }

    protected function getAttribute(string $attribute)
    {
        return $this->scope[$attribute];
    }

    public function id(string $attribute = 'id', bool $autoIncrement = true, string $type = 'int', mixed $size = null)
    {
        $this->setAttribute($attribute, $type, $size);

        $this->scope[$attribute] = $autoIncrement ?
                $this->getAttribute($attribute) . ' AUTO_INCREMENT PRIMARY KEY' :
                $this->getAttribute($attribute) . ' PRIMARY KEY';
    }

    public function string(string $attribute, mixed $size = 255)
    {
        $this->setAttribute($attribute, 'VARCHAR', $size);
    }

    public function int(string $attribute, mixed $size = null)
    {
        $this->setAttribute($attribute, 'INT', $size);
    }

    public function boolean(string $attribute)
    {
        $this->setAttribute($attribute, 'BOOLEAN', null);
    }

    public function date(string $attribute, )
    {
        $this->setAttribute($attribute, 'DATE', null);
    }

    public function decimal(string $attribute, mixed $size = null)
    {
        $this->setAttribute($attribute, 'DECIMAL', $size);
    }

    protected function setComplements(array $attributes, string $complement)
    {
        foreach ($attributes as $value) {
            $this->scope[$value] = $this->getAttribute($value) . ' ' . $complement;
        }
    }

    public function notNull(array $attributes)
    {
        
        $this->setComplements($attributes, 'NOT NULL');
    }

    public function default(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->scope[$key] = $this->getAttribute($key) . ' DEFAULT ' . $value;
        }
    }

    public function unique(array $attributes)
    {
        $row = implode(', ', $attributes);

        $this->uniques = ', UNIQUE (' . $row . ')';
    }

    public function run()
    {
        $this->statement = 'CREATE TABLE IF NOT EXISTS ' . $this->table . ' (' . implode(', ', $this->scope) . $this->uniques . ')';

        $this->connection->exec($this->statement);
    }

}