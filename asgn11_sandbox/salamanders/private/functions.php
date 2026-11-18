<?php

declare(strict_types=1);

function h(string $value): string
{
  return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function is_logged_in(): bool
{
  return isset($_SESSION['member_id']);
}

function require_login(): void
{
  if (!is_logged_in()) {
    header('Location: login.php');
    exit;
  }
}
