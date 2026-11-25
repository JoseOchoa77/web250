<?php
function demo_h(mixed $value): string
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function demo_current_member(): ?array
{
    global $scenario, $demoScenarios;
    // null represents a visitor who has not signed in.
    return $demoScenarios[$scenario];
}

function demo_is_member(): bool
{
    $member = demo_current_member();
    // Administrators also have permission to manage birds.
    return $member !== null && in_array($member['role'], ['member', 'admin'], true);
}

function demo_is_admin(): bool
{
    $member = demo_current_member();
    return $member !== null && $member['role'] === 'admin';
}

function demo_require_admin(): void
{
    // The page checks permission even if someone types its address directly.
    if (!demo_is_admin()) {
        http_response_code(403);
        exit('<h1>403 - Administrator access required</h1>'
            . '<p>This local simulation denied access.</p>'
            . '<p><a href="index.php">Return to the practice home page</a></p>');
    }
}
