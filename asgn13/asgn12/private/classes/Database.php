<?php
// One PDO connection shared by Bird and Member Active Record classes.
class Database
{
    public static function connect(): PDO
    {
        $host = (string) ($_ENV['DB_HOST'] ?? '127.0.0.1');
        $port = (string) ($_ENV['DB_PORT'] ?? '3306');
        $name = (string) ($_ENV['DB_NAME'] ?? 'wnc_birds');
        $user = (string) ($_ENV['DB_USER'] ?? '');
        $pass = (string) ($_ENV['DB_PASS'] ?? '');

        if (!ctype_digit($port)) {
            throw new RuntimeException('Invalid DB_PORT value in .env.');
        }
        $dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";
        return new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
}
