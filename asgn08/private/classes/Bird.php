<?php

declare(strict_types=1);

/**
 * Read-only Active Record model for one row of the birds table.
 * Static methods work on the table; properties hold one bird's values.
 */
final class Bird
{
    // One shared connection for the class, supplied by initialize.php.
    private static ?PDO $database = null;

    // Fixed column list shared by both finders.
    private const COLUMNS = 'id, common_name, scientific_name, family_name, '
        . 'primary_habitat, seasonal_status, description';

    public int $id = 0;
    public string $common_name = '';
    public string $scientific_name = '';
    public string $family_name = '';
    public string $primary_habitat = '';
    public string $seasonal_status = '';
    public string $description = '';

    public static function set_database(PDO $pdo): void
    {
        self::$database = $pdo;
    }

    /** @return Bird[] */
    public static function find_all(): array
    {
        // Fixed SQL with no user input, so query() is fine here.
        $sql = 'SELECT ' . self::COLUMNS . ' FROM birds ORDER BY common_name';
        $statement = self::db()->query($sql);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        $birds = [];
        foreach ($rows as $row) {
            $birds[] = self::from_row($row);
        }

        return $birds;
    }

    public static function find_by_id(int $id): ?self
    {
        // The id comes from a URL, so bind it instead of concatenating it.
        $sql = 'SELECT ' . self::COLUMNS . ' FROM birds WHERE id = :id LIMIT 1';
        $statement = self::db()->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        // fetch() returns false when no row matches.
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        return $row === false ? null : self::from_row($row);
    }

    // Hydration: the single place that maps a database row to a Bird object.
    private static function from_row(array $row): self
    {
        $bird = new self();
        $bird->id = (int) $row['id'];
        $bird->common_name = (string) $row['common_name'];
        $bird->scientific_name = (string) $row['scientific_name'];
        $bird->family_name = (string) $row['family_name'];
        $bird->primary_habitat = (string) $row['primary_habitat'];
        $bird->seasonal_status = (string) $row['seasonal_status'];
        $bird->description = (string) $row['description'];

        return $bird;
    }

    public static function count_all(): int
    {
        return (int) self::db()->query('SELECT COUNT(*) FROM birds')->fetchColumn();
    }

    private static function db(): PDO
    {
        if (self::$database === null) {
            throw new RuntimeException('Call Bird::set_database() before using Bird.');
        }

        return self::$database;
    }
}
