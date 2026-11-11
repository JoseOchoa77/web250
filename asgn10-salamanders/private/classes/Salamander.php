<?php

declare(strict_types=1);

final class Salamander
{
  private static ?PDO $database = null;

  public int $id = 0;
  public string $common_name = '';
  public string $scientific_name = '';
  public string $family_name = '';
  public string $primary_habitat = '';
  public string $field_note = '';

  public static function set_database(PDO $pdo): void
  {
    self::$database = $pdo;
  }

  public static function find_all(): array
  {
    if (self::$database === null) {
      throw new RuntimeException('Call set_database() before find_all().');
    }

    $sql = 'SELECT id, common_name, scientific_name, family_name, primary_habitat, field_note
                FROM crud_salamanders
                ORDER BY common_name';

    $rows = self::$database->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $salamanders = [];

    foreach ($rows as $row) {
      $salamanders[] = self::from_row($row);
    }

    return $salamanders;
  }

  public static function find_by_id(int $id): ?self
  {
    if (self::$database === null) {
      throw new RuntimeException('Call set_database() before find_by_id().');
    }

    $sql = 'SELECT id, common_name, scientific_name, family_name, primary_habitat, field_note
                FROM crud_salamanders
                WHERE id = :id';

    $statement = self::$database->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    return $row === false ? null : self::from_row($row);
  }

  public function create(): bool
  {
    if (self::$database === null) {
      throw new RuntimeException('Call set_database() before create().');
    }

    $sql = 'INSERT INTO crud_salamanders
                    (common_name, scientific_name, family_name, primary_habitat, field_note)
                VALUES
                    (:common_name, :scientific_name, :family_name, :primary_habitat, :field_note)';

    $statement = self::$database->prepare($sql);
    $statement->bindValue(':common_name', $this->common_name, PDO::PARAM_STR);
    $statement->bindValue(':scientific_name', $this->scientific_name, PDO::PARAM_STR);
    $statement->bindValue(':family_name', $this->family_name, PDO::PARAM_STR);
    $statement->bindValue(':primary_habitat', $this->primary_habitat, PDO::PARAM_STR);
    $statement->bindValue(':field_note', $this->field_note, PDO::PARAM_STR);

    $result = $statement->execute();

    if ($result) {
      $this->id = (int) self::$database->lastInsertId();
    }

    return $result;
  }

  // SANDBOX EXERCISE 1: Add public function update(): bool here.

  public function update(): bool
  {
    if (self::$database === null) {
      throw new RuntimeException('Call set_database() before update().');
    }

    if ($this->id <= 0) {
      return false;
    }

    $sql = 'UPDATE crud_salamanders
            SET common_name     = :common_name,
                scientific_name = :scientific_name,
                family_name     = :family_name,
                primary_habitat = :primary_habitat,
                field_note      = :field_note
            WHERE id = :id';

    $statement = self::$database->prepare($sql);

    $statement->bindValue(':common_name',     $this->common_name,     PDO::PARAM_STR);
    $statement->bindValue(':scientific_name', $this->scientific_name, PDO::PARAM_STR);
    $statement->bindValue(':family_name',     $this->family_name,     PDO::PARAM_STR);
    $statement->bindValue(':primary_habitat', $this->primary_habitat, PDO::PARAM_STR);
    $statement->bindValue(':field_note',      $this->field_note,      PDO::PARAM_STR);
    $statement->bindValue(':id',              $this->id,              PDO::PARAM_INT);

    return $statement->execute();
  }

  // SANDBOX EXERCISE 2: Add public function delete(): bool here.

  private static function from_row(array $row): self
  {
    $salamander = new self();
    $salamander->id = (int) $row['id'];
    $salamander->common_name = (string) $row['common_name'];
    $salamander->scientific_name = (string) $row['scientific_name'];
    $salamander->family_name = (string) $row['family_name'];
    $salamander->primary_habitat = (string) $row['primary_habitat'];
    $salamander->field_note = (string) $row['field_note'];
    return $salamander;
  }

  public function delete(): bool
  {
    if (self::$database === null) {
      throw new RuntimeException('Call set_database() before delete().');
    }
    if ($this->id <= 0) {
      return false;
    }
    $sql = 'DELETE FROM crud_salamanders WHERE id = :id';
    $statement = self::$database->prepare($sql);
    $statement->bindValue(':id', $this->id, PDO::PARAM_INT);
    $statement->execute();
    if ($statement->rowCount() === 1) {
      $this->id = 0;
      return true;
    }
    return false;
  }
}
