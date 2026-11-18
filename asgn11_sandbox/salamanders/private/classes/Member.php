<?php

final class Member
{
  private static ?PDO $database = null;

  public int $id = 0;
  public string $first_name = '';
  public string $last_name = '';
  public string $email = '';
  public string $username = '';
  public string $password_hash = '';
  public string $role = '';
  public string $created_at = '';

  public static function set_database(PDO $pdo): void
  {
    self::$database = $pdo;
  }


  // public static function find_all(): array
  // {
  //   if (self::$database === null) {
  //     throw new RuntimeException('Call set_database() before find_all().');
  //   }

  //   $sql = 'SELECT id, first_name, last_name, email, username, password_hash, role, created_at
  //               FROM members
  //               ORDER BY first_name';

  //   $rows = self::$database->query($sql)->fetchAll(PDO::FETCH_ASSOC);
  //   $members = [];

  //   foreach ($rows as $row) {
  //     $members[] = self::from_row($row);
  //   }

  //   return $members;
  // }

  public function create(): bool
  {
    if (self::$database === null) {
      throw new RuntimeException('Call set_database() before create().');
    }

    $sql = 'INSERT INTO members
                    (first_name, last_name, email, username, password_hash)
                VALUES
                    (:first_name, :last_name, :email, :username, :password_hash)';

    $statement = self::$database->prepare($sql);
    $statement->bindValue(':first_name', $this->first_name, PDO::PARAM_STR);
    $statement->bindValue(':last_name', $this->last_name, PDO::PARAM_STR);
    $statement->bindValue(':email', $this->email, PDO::PARAM_STR);
    $statement->bindValue(':username', $this->username, PDO::PARAM_STR);
    $statement->bindValue(':password_hash', $this->password_hash, PDO::PARAM_STR);

    $result = $statement->execute();

    if ($result) {
      $this->id = (int) self::$database->lastInsertId();
    }

    return $result;
  }

  public static function username_exists(string $username): bool
  {
    $sql = 'SELECT COUNT(*) FROM members WHERE username = :username';
    $statement = self::$database->prepare($sql);
    $statement->bindValue(':username', $username, PDO::PARAM_STR);
    $statement->execute();
    return (int) $statement->fetchColumn() > 0;
  }

  public static function email_exists(string $email): bool
  {
    $sql = 'SELECT COUNT(*) FROM members WHERE email = :email';
    $statement = self::$database->prepare($sql);
    $statement->bindValue(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    return (int) $statement->fetchColumn() > 0;
  }

  public static function find_by_username(string $username): ?self
  {
    $sql = 'SELECT id, first_name, last_name, email, username, password_hash, role, created_at
          FROM members
          WHERE username = :username
          LIMIT 1';
    $statement = self::$database->prepare($sql);
    $statement->bindValue(':username', $username, PDO::PARAM_STR);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    return $row === false ? null : self::from_row($row);
  }

  private static function from_row(array $row): self
  {
    $member = new self();
    $member->id            = (int) $row['id'];
    $member->first_name    = (string) $row['first_name'];
    $member->last_name     = (string) $row['last_name'];
    $member->email         = (string) $row['email'];
    $member->username      = (string) $row['username'];
    $member->password_hash = (string) $row['password_hash'];
    $member->role          = (string) $row['role'];
    $member->created_at    = (string) $row['created_at'];
    return $member;
  }
}
