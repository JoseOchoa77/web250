<?php
// Member Active Record: all SQL for the members table stays in this class.
class Member
{
  private static PDO $database;

  public ?int $id = null;
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

  // HYDRATION: turn one associative array returned by PDO into one Member.
  private static function from_row(array $row): Member
  {
    $member = new Member();
    $member->id = (int) $row['id'];
    $member->first_name = (string) $row['first_name'];
    $member->last_name = (string) $row['last_name'];
    $member->email = (string) $row['email'];
    $member->username = (string) $row['username'];
    $member->password_hash = (string) $row['password_hash'];
    $member->role = (string) $row['role'];
    return $member;
  }

  // BEGIN T03
  public static function find_all(): array
  {
    $sql = 'SELECT id, first_name, last_name, email, username,
password_hash, role
 FROM members ORDER BY last_name, first_name, id';
    $statement = self::$database->query($sql);
    $members = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
      $members[] = self::from_row($row);
    }
    return $members;
  }
  // END T03

  public static function find_by_id(int $id): ?Member
  {
    $sql = 'SELECT id, first_name, last_name, email, username, password_hash, role
                FROM members WHERE id = :id LIMIT 1';
    $statement = self::$database->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    return $row ? self::from_row($row) : null;
  }

  public static function find_by_username(string $username): ?Member
  {
    $sql = 'SELECT id, first_name, last_name, email, username, password_hash, role
                FROM members WHERE username = :username LIMIT 1';
    $statement = self::$database->prepare($sql);
    $statement->execute([':username' => $username]);
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    return $row ? self::from_row($row) : null;
  }

  // An optional ID excludes the record currently being edited.
  public static function username_exists(string $username, ?int $exclude_id = null): bool
  {
    $sql = 'SELECT id FROM members WHERE username = :username';
    if ($exclude_id !== null) {
      $sql .= ' AND id <> :excluded';
    }
    $sql .= ' LIMIT 1';
    $statement = self::$database->prepare($sql);
    $statement->bindValue(':username', $username);
    if ($exclude_id !== null) {
      $statement->bindValue(':excluded', $exclude_id, PDO::PARAM_INT);
    }
    $statement->execute();
    return $statement->fetch() !== false;
  }

  public static function email_exists(string $email, ?int $exclude_id = null): bool
  {
    $sql = 'SELECT id FROM members WHERE email = :email';
    if ($exclude_id !== null) {
      $sql .= ' AND id <> :excluded';
    }
    $sql .= ' LIMIT 1';
    $statement = self::$database->prepare($sql);
    $statement->bindValue(':email', $email);
    if ($exclude_id !== null) {
      $statement->bindValue(':excluded', $exclude_id, PDO::PARAM_INT);
    }
    $statement->execute();
    return $statement->fetch() !== false;
  }

  public function validation_errors(?int $exclude_id = null): array
  {
    $errors = [];
    if ($this->first_name === '' || strlen($this->first_name) > 80) {
      $errors[] = 'First name is required (80 characters maximum).';
    }
    if ($this->last_name === '' || strlen($this->last_name) > 80) {
      $errors[] = 'Last name is required (80 characters maximum).';
    }
    if (!filter_var($this->email, FILTER_VALIDATE_EMAIL) || strlen($this->email) > 190) {
      $errors[] = 'Enter a valid email (190 characters maximum).';
    } elseif (self::email_exists($this->email, $exclude_id)) {
      $errors[] = 'This email is already used by another member.';
    }
    if (!preg_match('/^[A-Za-z0-9._-]{3,50}$/D', $this->username)) {
      $errors[] = 'Username must contain 3–50 letters, numbers, dots, underscores, or hyphens.';
    } elseif (self::username_exists($this->username, $exclude_id)) {
      $errors[] = 'This username is already used by another member.';
    }
    if (!in_array($this->role, ['member', 'admin'], true)) {
      $errors[] = 'Role must be member or admin.';
    }
    return $errors;
  }

  public function set_password(string $plain_password): void
  {
    // Hash ONCE, when creating an account. Editing never calls this method.
    $this->password_hash = password_hash($plain_password, PASSWORD_DEFAULT);
  }

  private function insert_with_role(string $role): bool
  {
    if (!in_array($role, ['member', 'admin'], true)) {
      throw new InvalidArgumentException('Invalid role.');
    }
    if (!password_get_info($this->password_hash)['algo']) {
      throw new LogicException('set_password() must be called before inserting an account.');
    }
    $sql = 'INSERT INTO members
                (first_name, last_name, email, username, password_hash, role)
                VALUES (:first_name, :last_name, :email, :username, :password_hash, :role)';
    $statement = self::$database->prepare($sql);
    $ok = $statement->execute([
      ':first_name' => $this->first_name,
      ':last_name' => $this->last_name,
      ':email' => $this->email,
      ':username' => $this->username,
      ':password_hash' => $this->password_hash,
      ':role' => $role,
    ]);
    if ($ok) {
      $this->id = (int) self::$database->lastInsertId();
      $this->role = $role;
    }
    return $ok;
  }

  // PUBLIC registration. Even a malicious POST role=admin cannot change this.
  public function create(): bool
  {
    $this->role = 'member';
    return $this->insert_with_role('member');
  }

  // ADMIN-ONLY creation path; the calling page must first require_admin().
  // BEGIN T05
  public function create_by_admin(): bool
  {
    return $this->insert_with_role($this->role);
  }

  // END T05

  // BEGIN T06
  public function update_by_admin(int $acting_admin_id): bool
  {
    if ($this->id === null) {
      throw new LogicException('Cannot update a Member without an
ID.');
    }
    if (!in_array($this->role, ['member', 'admin'], true)) {
      throw new InvalidArgumentException('Invalid role.');
    }
    if ($this->id === $acting_admin_id && $this->role !== 'admin') {
      throw new DomainException('Administrators cannot remove their
own admin role.');
    }
    // Note: no password_hash in UPDATE. Password reset is outside asgn 12.
    $sql = 'UPDATE members
 SET first_name=:first_name, last_name=:last_name,
email=:email,
 username=:username, role=:role WHERE id=:id';
    $statement = self::$database->prepare($sql);
    return $statement->execute([
      ':first_name' => $this->first_name,
      ':last_name' => $this->last_name,
      ':email' => $this->email,
      ':username' => $this->username,
      ':role' => $this->role,
      ':id' => $this->id,
    ]);
  }
  // END T06

  // BEGIN T07
  public function delete_by_admin(int $acting_admin_id): bool
  {
    if ($this->id === null) {
      throw new LogicException('Cannot delete a Member without an ID.');
    }

    if ($this->id === $acting_admin_id) {
      throw new DomainException('An administrator cannot delete their own account.');
    }

    $statement = self::$database->prepare('DELETE FROM members WHERE id = :id');
    $statement->bindValue(':id', $this->id, PDO::PARAM_INT);
    $statement->execute();

    return $statement->rowCount() === 1;
  } // END T07
}
