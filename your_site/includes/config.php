<?php

function start_custom_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    $serverName = $_SERVER['SERVER_NAME'] ?? '';
    $isLocal = in_array($serverName, ['localhost', '127.0.0.1']);

    if ($isLocal) {
        $sessionDir = __DIR__ . '/../sessions';

        if (is_dir($sessionDir) && is_writable($sessionDir)) {
            ini_set('session.save_path', $sessionDir);
        }
    }

    session_start();
}