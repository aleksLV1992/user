<?php

try {
    spl_autoload_register(function ($class_name) {
        $directories = [
            __DIR__,
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'controllers',
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'models',
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'assets',
            __DIR__ . DIRECTORY_SEPARATOR . 'Site'
        ];

        $c = explode('\\', $class_name);
        $class_name = $c[count($c) - 1];
        foreach ($directories as $d) {
            $path = $d . "/{$class_name}.php";
            if (file_exists($path)) {
                /** @noinspection PhpIncludeInspection */
                require_once $path;
                return true;
            }
        }

        return false;
    });
} catch (Exception $e) {
    error_log($e->getMessage());
}

