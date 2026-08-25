<?php

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);

        $path = __DIR__ . '/../views/' . $view . '.php';

        // If view path with subfolder doesn't exist, try fallback to single file with underscore (e.g. auth_login)
        if (!file_exists($path)) {
            $fallback = __DIR__ . '/../views/' . str_replace('/', '_', $view) . '.php';
            if (file_exists($fallback)) {
                require_once $fallback;
                return;
            }
        }

        require_once $path;
    }
}