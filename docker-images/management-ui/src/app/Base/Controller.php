<?php

namespace MgmtUi\Base;

abstract class Controller
{
    public static function __callStatic($name, $arguments)
    {
        $instance = new static();

        return $instance->$name(...$arguments);
    }

    protected function renderView($viewName)
    {
        require __DIR__ . '../Views/' . $viewName . '.php';
    }
}
