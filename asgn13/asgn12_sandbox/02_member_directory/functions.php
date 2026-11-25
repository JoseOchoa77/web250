<?php
function sandbox_h(mixed $value): string
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function sandbox_current_member(): ?Member
{
    // Login in the main asgn12 application stores this ID in the shared session.
    $id = filter_var($_SESSION['member_id'] ?? null, FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1]]);
    if ($id === false || $id === null) {
        return null;
    }
    return Member::find_by_id((int) $id);
}

function sandbox_require_admin(): Member
{
    try {
        $member = sandbox_current_member();
    } catch (Throwable $exception) {
        error_log('Sandbox member lookup: ' . $exception->getMessage());
        http_response_code(500);
        exit('Could not read the members table. Check the asgn12 database setup.');
    }

    // Read the real role from MySQL; the browser never chooses this role.
    if ($member === null || $member->role !== 'admin') {
        http_response_code(403);
        exit('<h1>403 - Administrator access required</h1>'
            . '<p>Sign in with your asgn12 administrator account, then return to this sandbox.</p>'
            . '<p><a href="../../asgn12/public/login.php">Open asgn12 Login</a></p>');
    }
    return $member;
}
