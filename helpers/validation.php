<?php
function sanitizeInput(string $input): string {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function isValidUsername(string $username): bool {
    return preg_match('/^[a-zA-Z0-9_]{4,20}$/', $username);
}

function isStrongPassword(string $password): bool {
    return strlen($password) >= 6;
}
