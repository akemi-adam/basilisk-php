<?php

try {
    $connection = new \PDO(
        'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASSWORD']
    );

} catch (\PDOException $e) {
    print('Houve um erro ao criar a conexão: ' . $e->getMessage());
}

return $connection;