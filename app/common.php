<?php
// 应用公共文件
function array_get($array, $key, $default = null)
{
    if (is_null($key)) {
        return $array;
    }

    if (isset($array[$key])) {
        return $array[$key];
    }

    foreach (explode('.', $key) as $segment) {
        if (! is_array($array) || ! array_key_exists($segment, $array)) {
            return value($default);
        }

        $array = $array[$segment];
    }
    return $array;
}