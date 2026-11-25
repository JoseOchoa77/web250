<?php
// The familiar Bird Active Record stays separate from the new Member class.
// Expected WNC Birds columns: id, common_name, scientific_name, family_name,
// primary_habitat, seasonal_status, description.
class Bird
{
    private static PDO $database;

    public ?int $id = null;
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
        return self::$database;
    }

    private static function from_row(array $row): Bird
    {
        $bird = new Bird();
        $bird->id = (int) $row['id'];
        $bird->common_name = (string) ($row['common_name'] ?? '');
        $bird->scientific_name = (string) ($row['scientific_name'] ?? '');
        $bird->family_name = (string) ($row['family_name'] ?? '');
        $bird->primary_habitat = (string) ($row['primary_habitat'] ?? '');
        $bird->seasonal_status = (string) ($row['seasonal_status'] ?? '');
        $bird->description = (string) ($row['description'] ?? '');
        return $bird;
    }

    public static function find_all(): array
    {
        $statement = self::db()->query('SELECT * FROM birds ORDER BY common_name');
        $birds = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $birds[] = self::from_row($row);
        }
        return $birds;
    }

    public static function find_by_id(int $id): ?Bird
    {
        $statement = self::db()->prepare('SELECT * FROM birds WHERE id = :id LIMIT 1');
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        return $row ? self::from_row($row) : null;
    }

    public static function count_all(): int
    {
        return (int) self::db()->query('SELECT COUNT(*) FROM birds')->fetchColumn();
    }

    public function create(): bool
    {
        $sql = 'INSERT INTO birds
                (common_name, scientific_name, family_name, primary_habitat,
                 seasonal_status, description)
                VALUES (:common_name, :scientific_name, :family_name, :primary_habitat,
                        :seasonal_status, :description)';
        $statement = self::db()->prepare($sql);
        $ok = $statement->execute($this->form_parameters());
        if ($ok) {
            $this->id = (int) self::db()->lastInsertId();
        }
        return $ok;
    }

    public function update(): bool
    {
        if ($this->id === null) {
            throw new LogicException('Cannot update a Bird without an ID.');
        }
        $sql = 'UPDATE birds SET common_name = :common_name,
                scientific_name = :scientific_name, family_name = :family_name,
                primary_habitat = :primary_habitat, seasonal_status = :seasonal_status,
                description = :description WHERE id = :id';
        $statement = self::db()->prepare($sql);
        return $statement->execute($this->form_parameters() + [':id' => $this->id]);
    }

    public function delete(): bool
    {
        if ($this->id === null) {
            throw new LogicException('Cannot delete a Bird without an ID.');
        }
        $statement = self::db()->prepare('DELETE FROM birds WHERE id = :id');
        $statement->bindValue(':id', $this->id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->rowCount() === 1;
    }

    private function form_parameters(): array
    {
        return [
            ':common_name' => $this->common_name,
            ':scientific_name' => $this->scientific_name,
            ':family_name' => $this->family_name,
            ':primary_habitat' => $this->primary_habitat,
            ':seasonal_status' => $this->seasonal_status,
            ':description' => $this->description,
        ];
    }
}
