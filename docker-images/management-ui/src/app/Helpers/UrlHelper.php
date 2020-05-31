<?php

namespace MgmtUi\Helpers;

class UrlHelper
{
    public static function url(string $url) : string
    {
        return ConfigHelper::instance()->get('baseUrl', '/') . urlencode(ltrim($url, '/'));
    }
}
