<?php
// This read-only practice class is separate from the assignment's Member class.
// It deliberately selects no passwords or password hashes.
class Member
{
    private static PDO $database;

    public ?int $id = null;
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $username = '';
    public string $role = 'member';

    public static function set_database(PDO $pdo): void
    {
        self::$database = $pdo;
    }

    private static function from_row(array $row): Member
    {
        // One associative array from PDO becomes one Member object.
        $member = new Member();
        $member->id = (int) $row['id'];
        $member->first_name = (string) $row['first_name'];
        $member->last_name = (string) $row['last_name'];
        $member->email = (string) $row['email'];
        $member->username = (string) $row['username'];
        $member->role = (string) $row['role'];
        return $member;
    }

    public static function find_all(): array
    {
        $sql = 'SELECT id, first_name, last_name, email, username, role
                FROM members ORDER BY last_name, first_name, id';
        $statement = self::$database->query($sql);
        $members = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $members[] = self::from_row($row);
        }
        return $members;
    }

    public static function find_by_id(int $id): ?Member
    {
        $sql = 'SELECT id, first_name, last_name, email, username, role
                FROM members WHERE id = :id LIMIT 1';
        $statement = self::$database->prepare($sql);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        // fetch() returns false when no row matched. In that case, return no object.
        if ($row === false) {
            return null;
        }
        return self::from_row($row);
    }
}
