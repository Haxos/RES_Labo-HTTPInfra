<?php

namespace MgmtUi\Base;

use Closure;
use MgmtUi\Helpers\UrlHelper;

abstract class Controller
{
    public static function route(string $name) : Closure
    {
        return Closure::fromCallable([new static, $name]);
    }

    protected function renderView(string $viewName, array $parameters = []) : void
    {
        extract($parameters);

        require __DIR__ . '/../Views/' . $viewName . '.php';
    }

    protected function redirect(string $url, int $status = 302) : void
    {
        $url = UrlHelper::url($url);

        header("Location: {$url}");
        http_response_code($status);
        exit();
    }
}
