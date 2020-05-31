<?php

namespace MgmtUi\Helpers;

class ConfigHelper
{
    private $content;

    public function __construct()
    {
        $this->content = json_decode(file_get_contents(PathHelper::path('configuration.json')));
    }

    public static function instance()
    {
        return new static();
    }

    public function get(string $keyName, $default = null)
    {
        $path = explode('.', $keyName);
        $targetItem = $this->content;

        foreach ($path as $index)
        {
            $type = gettype($targetItem);

            if ($type === "array" && isset($targetItem[$index]))
            {
                $targetItem = $targetItem[$index];
            }
            else if ($type === "object" && isset($targetItem->$index))
            {
                $targetItem = $targetItem->$index;
            }
            else
            {
                return $default;
            }
        }

        return $targetItem;
    }
}
