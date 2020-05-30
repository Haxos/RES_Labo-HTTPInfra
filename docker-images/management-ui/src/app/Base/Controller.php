<?php

namespace MgmtUi\Base;

abstract class Controller
{
    public static function call($name, ...$arguments)
    {
        return (new static)->$name(...$arguments);
    }

    protected function renderView($viewName)
    {
        require __DIR__ . '/../Views/' . $viewName . '.php';
    }
}
