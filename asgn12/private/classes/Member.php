<?php

class Member
{
    private static ?PDO $database = null;

    public int $id = 0;
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $username = '';
    public string $password_hash = '';
    public string $role = 'member';

    public static function set_database(PDO $pdo): void
    {
        self::$database = $pdo;
    }

    private static function db(): PDO
    {
        if (self::$database === null) {
            throw new RuntimeException('Member database connection has not been set.');
        }

        return self::$database;
    }

    public static function find_by_username(string $username): ?Member
    {
        $sql = 'SELECT id, first_name, last_name, email, username, password_hash, role
                FROM members
                WHERE username = :username
                LIMIT 1';

        $statement = self::db()->prepare($sql);
        $statement->execute([':username' => $username]);
        $row = $statement->fetch();

        return $row ? self::from_row($row) : null;
    }

    public static function username_exists(string $username): bool
    {
        $statement = self::db()->prepare('SELECT COUNT(*) FROM members WHERE username = :username');
        $statement->execute([':username' => $username]);
        return (int) $statement->fetchColumn() > 0;
    }

    public static function email_exists(string $email): bool
    {
        $statement = self::db()->prepare('SELECT COUNT(*) FROM members WHERE email = :email');
        $statement->execute([':email' => $email]);
        return (int) $statement->fetchColumn() > 0;
    }

    public function create(): bool
    {
        $sql = 'INSERT INTO members
                    (first_name, last_name, email, username, password_hash, role)
                VALUES
                    (:first_name, :last_name, :email, :username, :password_hash, :role)';

        $statement = self::db()->prepare($sql);
        $result = $statement->execute([
            ':first_name' => $this->first_name,
            ':last_name' => $this->last_name,
            ':email' => $this->email,
            ':username' => $this->username,
            ':password_hash' => $this->password_hash,
            ':role' => 'member',
        ]);

        if ($result) {
            $this->id = (int) self::db()->lastInsertId();
            $this->role = 'member';
        }

        return $result;
    }

    private static function from_row(array $row): Member
    {
        $member = new self();
        $member->id = (int) $row['id'];
        $member->first_name = (string) ($row['first_name'] ?? '');
        $member->last_name = (string) ($row['last_name'] ?? '');
        $member->email = (string) ($row['email'] ?? '');
        $member->username = (string) ($row['username'] ?? '');
        $member->password_hash = (string) ($row['password_hash'] ?? '');
        $member->role = (string) ($row['role'] ?? 'member');
        return $member;
    }
}
