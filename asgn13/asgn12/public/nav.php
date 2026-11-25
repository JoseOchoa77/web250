<?php
// BEGIN T02
// TODO T02: replace this shared navigation with the tutorial's personalized version.
$prefix = !empty($admin_nav) ? '../' : '';
$nav_member = current_member();
$nav_can_edit_birds = $nav_member !== null &&
    in_array($nav_member->role, ['member', 'admin'], true);
?>
<nav>
    <a href="<?php print $prefix; ?>index.php">Home</a> |
    <a href="<?php print $prefix; ?>birds.php">Birds</a>
    <?php if ($nav_can_edit_birds) { ?>
        | <a href="<?php print $prefix; ?>bird_new.php">Create Bird</a>
    <?php } ?>
    <?php if ($nav_member !== null) { ?>
        | <a href="<?php print $prefix; ?>logout.php">Logout</a>
    <?php } else { ?>
        | <a href="<?php print $prefix; ?>login.php">Login</a>
        | <a href="<?php print $prefix; ?>signup.php">Register</a>
    <?php } ?>
</nav>
<hr>
<?php
// END T02
?>
