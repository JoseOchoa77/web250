<?php

declare(strict_types=1);

final class Bird
{
    private static ?PDO $database = null;

    public int $id = 0;
    public string $common_name = '';
    public string $scientific_name = '';
    public string $family_name = '';
    public string $primary_habitat = '';
    public string $seasonal_status = '';
    public string $description = '';

    public static function set_database(PDO $pdo): void
    {
        // Same as SandboxBird: store the connection on the class.
        self::$database = $pdo;
    }

    /** @return Bird[] */
    public static function find_all(): array
    {
        // 1. Write the SQL: SELECT all 7 columns FROM birds ORDER BY common_name
        $sql = 'SELECT id, common_name, scientific_name, family_name,
                       primary_habitat, seasonal_status, description
                FROM birds
                ORDER BY common_name';

        // 2. Run it and get all rows as associative arrays (see SandboxBird)
        $statement = self::$database->query($sql);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        // 3. Turn each row into a Bird using from_row()
        $birds = [];
        foreach ($rows as $row) {
            $birds[] = self::from_row($row);
        }
        return $birds;
    }

    public static function find_by_id(int $id): ?self
    {
        // Same 7 columns as find_all(), but only one bird: WHERE id = :id
        $sql = 'SELECT id, common_name, scientific_name, family_name,
                       primary_habitat, seasonal_status, description
                FROM birds
                WHERE id = :id';

        $statement = self::$database->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        // fetch() (not fetchAll) gets ONE row, or false if none was found
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        // If $row is false, return null. Otherwise return self::from_row($row).
        if (! $row) {
           return null;
        } else {
          return self::from_row($row);
        }
    }

    private static function from_row(array $row): self
    {
        $bird = new self();
        $bird->id = (int) $row['id'];
        $bird->common_name = (string) $row['common_name'];
        // Do the same for the other 5 properties:
        // scientific_name, family_name, primary_habitat, seasonal_status, description
        $bird->scientific_name = (string) $row['scientific_name'];
        $bird->family_name = (string) $row['family_name'];
        $bird->primary_habitat = (string) $row['primary_habitat'];
        $bird->seasonal_status = (string) $row['seasonal_status'];
        $bird->description = (string) $row['description'];

        return $bird;
    }

    public static function count_all(): int
    {
        // SELECT COUNT(*) FROM birds returns one row with one number.
        $statement = self::$database->query('SELECT COUNT(*) FROM birds');
        // fetchColumn() gets that single number; cast it to int.
        return (int) $statement->fetchColumn();
    }
}
