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

    protected function setAttribute(string $attribute, string $type, int|null $size = null) : void
    {
        $row = $attribute . " $type";

        is_null($size) ?
            $this->scope[$attribute] = $row :
            $this->scope[$attribute] = "$row($size)";
    }

    protected function getAttribute(string $attribute)
    {
        return $this->scope[$attribute];
    }

    protected function setComplements(array $attributes, string $complement) : void
    {
        foreach ($attributes as $value)
            $this->scope[$value] = $this->getAttribute($value) . ' ' . $complement;
    }

    public function id(string $attribute = 'id', bool $autoIncrement = true, string $type = 'int', mixed $size = null) : void
    {
        $this->setAttribute($attribute, $type, $size);

        $this->scope[$attribute] = $this->getAttribute($attribute) . ($autoIncrement ? " AUTO_INCREMENT PRIMARY KEY" : " PRIMARY KEY");
    }

    public function string(string $attribute, mixed $size = 255) : Migration
    {
        $this->setAttribute($attribute, 'VARCHAR', $size);

        return $this;
    }

    public function int(string $attribute, mixed $size = null) : Migration
    {
        $this->setAttribute($attribute, 'INT', $size);

        return $this;
    }

    public function boolean(string $attribute) : Migration
    {
        $this->setAttribute($attribute, 'BOOLEAN');

        return $this;
    }

    public function date(string $attribute) : Migration
    {
        $this->setAttribute($attribute, 'DATE');

        return $this;
    }

    public function decimal(string $attribute, mixed $size = null) : Migration
    {
        $this->setAttribute($attribute, 'DECIMAL', $size);

        return $this;
    }

    public function notNull(array $attributes)
    {
        $this->setComplements($attributes, 'NOT NULL');
    }

    public function default(array $attributes)
    {
        foreach ($attributes as $key => $value)
            $this->scope[$key] = $this->getAttribute($key) . ' DEFAULT ' . $value;
    }

    public function unique(array $attributes)
    {
        $row = implode(', ', $attributes);

        $this->uniques = ', UNIQUE (' . $row . ')';
    }

    public function run()
    {
        $this->statement = sprintf(
            "CREATE TABLE IF NOT EXISTS %s (%s%s)",
            $this->table,
            implode(', ', $this->scope),
            $this->uniques
        );

        $this->connection->exec($this->statement);
    }

}