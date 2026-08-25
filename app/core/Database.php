<?php

class Database
{
    private string $host;
    private string $database;
    private string $username;
    private string $password;

    public function __construct()
    {
        $this->host = getenv('DB_HOST') ?: 'db';
        $this->database = getenv('DB_NAME') ?: 'avaliacao_titan';
        $this->username = getenv('DB_USERNAME') ?: 'titan';
        $this->password = getenv('DB_PASSWORD') ?: 'titan123';
    }

    public function connect(): PDO
    {
        $candidates = [$this->host, '127.0.0.1', 'localhost'];
        $lastException = null;

        foreach (array_unique($candidates) as $host) {
            try {
                $dsn = "mysql:host={$host};dbname={$this->database};charset=utf8mb4";

                return new PDO(
                    $dsn,
                    $this->username,
                    $this->password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false
                    ]
                );
            } catch (PDOException $e) {
                $lastException = $e;
            }
        }

        throw $lastException ?: new PDOException('Unable to connect to database.');
    }
}