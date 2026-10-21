<?php
class Database{
    // Store a PDO object, or null before the first connection.    
    private static ?PDO $connection = null;
    public static function connect(): PDO    {
        // Reuse this request's connection instead of opening another one.        
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }
        // The DSN tells PDO which driver, server, and database to use.        
        $dsn = 'mysql:host=' . DB_HOST
            . ';port=' . DB_PORT
            . ';dbname=' . DB_NAME
            . ';charset=utf8mb4';
            
        self::$connection = new PDO(
            $dsn,
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
        return self::$connection;
    }
}
