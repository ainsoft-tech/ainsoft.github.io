<?php
function redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}

function is_admin_logged_in(): bool
{
    return isset($_SESSION['admin_id']);
}
