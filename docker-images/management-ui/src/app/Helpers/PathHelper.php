<?php

namespace MgmtUi\Helpers;

class PathHelper
{
    public static function path(string $path) : string
    {
        return __DIR__ . '/../../' . $path;
    }

    public static function appPath(string $path) : string
    {
        return self::path('app/' . $path);
    }

    public static function viewPath(string $path) : string
    {
        return self::appPath('Views/' . $path);
    }
}
