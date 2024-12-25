<?php

namespace App;

use App\Enum\UserRole;

class Session
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $row, string|null $col = null)
    {
        if ($col)
            return $_SESSION[$row][$col] ?? null;

        return $_SESSION[$row] ?? null;
    }

    public function delete(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function destroy(): void
    {
        session_destroy();
    }

    public function replace(string $row, string $col, string $value): void
    {
        $_SESSION[$row][$col] = $value;
    }

    public function isLoggedIn(): bool
    {
        return (bool)$this->get('user');
    }

    public function isAdmin(): bool
    {
        return in_array(UserRole::ADMIN->name, $this->get('user', 'roles'));
    }
}
