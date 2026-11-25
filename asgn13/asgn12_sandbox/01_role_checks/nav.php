<?php $currentMember = demo_current_member(); ?>
<nav aria-label="Practice navigation">
    <a href="index.php">Practice home</a>
    <?php if (demo_is_admin()): ?>
        | <a href="admin_only.php">Admin practice</a>
    <?php endif; ?>

    <?php if ($currentMember !== null): ?>
        | Logout, <?= demo_h($currentMember['first_name']) ?>
    <?php else: ?>
        | Login | Register
    <?php endif; ?>
</nav>
<p><strong>Simulation only:</strong> Login, Register, and Logout above are display labels.
    To change the visitor, edit <code>$scenario</code> in <code>config.php</code>.</p>
