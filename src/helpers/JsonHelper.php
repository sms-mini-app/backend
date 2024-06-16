<?php

namespace app\helpers;

class JsonHelper
{
    public static function toYml($json)
    {
        $yamlContent = yaml_emit($json);
        return preg_replace('/(^---[\t\n]*)|(...[\t\n])$/', "", $yamlContent);
    }
}