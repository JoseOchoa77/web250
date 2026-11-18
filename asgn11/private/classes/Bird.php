<?php

class Bird
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
        self::$database = $pdo;
    }

    private static function db(): PDO
    {
        if (self::$database === null) {
            throw new RuntimeException('Bird database connection has not been set.');
        }

        return self::$database;
    }

    public static function find_all(): array
    {
        $sql = 'SELECT id, common_name, scientific_name, family_name, primary_habitat, seasonal_status, description
                FROM birds
                ORDER BY common_name';

        $statement = self::db()->query($sql);
        $rows = $statement->fetchAll();

        $birds = [];
        foreach ($rows as $row) {
            $birds[] = self::from_row($row);
        }

        return $birds;
    }

    public static function find_by_id(int $id): ?Bird
    {
        $sql = 'SELECT id, common_name, scientific_name, family_name, primary_habitat, seasonal_status, description
                FROM birds
                WHERE id = :id
                LIMIT 1';

        $statement = self::db()->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $row = $statement->fetch();

        return $row ? self::from_row($row) : null;
    }

    public static function count_all(): int
    {
        $statement = self::db()->query('SELECT COUNT(*) FROM birds');
        return (int) $statement->fetchColumn();
    }

    public function create(): bool
    {
        $sql = 'INSERT INTO birds
                    (common_name, scientific_name, family_name, primary_habitat, seasonal_status, description)
                VALUES
                    (:common_name, :scientific_name, :family_name, :primary_habitat, :seasonal_status, :description)';

        $statement = self::db()->prepare($sql);
        $result = $statement->execute([
            ':common_name' => $this->common_name,
            ':scientific_name' => $this->scientific_name,
            ':family_name' => $this->family_name,
            ':primary_habitat' => $this->primary_habitat,
            ':seasonal_status' => $this->seasonal_status,
            ':description' => $this->description,
        ]);

        if ($result) {
            $this->id = (int) self::db()->lastInsertId();
        }

        return $result;
    }

    public function update(): bool
    {
        $sql = 'UPDATE birds SET
                    common_name = :common_name,
                    scientific_name = :scientific_name,
                    family_name = :family_name,
                    primary_habitat = :primary_habitat,
                    seasonal_status = :seasonal_status,
                    description = :description
                WHERE id = :id';

        $statement = self::db()->prepare($sql);
        return $statement->execute([
            ':common_name' => $this->common_name,
            ':scientific_name' => $this->scientific_name,
            ':family_name' => $this->family_name,
            ':primary_habitat' => $this->primary_habitat,
            ':seasonal_status' => $this->seasonal_status,
            ':description' => $this->description,
            ':id' => $this->id,
        ]);
    }

    public function delete(): bool
    {
        $sql = 'DELETE FROM birds WHERE id = :id';
        $statement = self::db()->prepare($sql);
        $statement->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $statement->execute();
    }

    private static function from_row(array $row): Bird
    {
        $bird = new self();
        $bird->id = (int) $row['id'];
        $bird->common_name = (string) ($row['common_name'] ?? '');
        $bird->scientific_name = (string) ($row['scientific_name'] ?? '');
        $bird->family_name = (string) ($row['family_name'] ?? '');
        $bird->primary_habitat = (string) ($row['primary_habitat'] ?? '');
        $bird->seasonal_status = (string) ($row['seasonal_status'] ?? '');
        $bird->description = (string) ($row['description'] ?? '');
        return $bird;
    }
}
