<?php
$nav_member    = current_member();
$nav_is_member = $nav_member !== null
    && in_array($nav_member->role, ['member', 'admin'], true);
$nav_is_admin  = $nav_member !== null
    && $nav_member->role === 'admin';
?>
<nav>
  <a href="index.php">Home</a> |
  <a href="birds.php">Birds</a>

  <?php if ($nav_is_member): ?>
    | <a href="bird_create.php">Create Bird</a>
  <?php endif; ?>

  <?php if ($nav_is_admin): ?>
    | <a href="members.php">Manage Members</a>
  <?php endif; ?>

  <?php if ($nav_member !== null): ?>
    | <a href="logout.php">
        Logout, <?php echo htmlspecialchars($nav_member->first_name); ?>
      </a>
  <?php else: ?>
    | <a href="login.php">Login</a>
    | <a href="signup.php">Register</a>
  <?php endif; ?>
</nav>
