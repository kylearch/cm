<?php

function _load($class)
{
    $directory = __DIR__;
    $ds = DIRECTORY_SEPARATOR;
    $class_name = str_replace('\\', $ds, $class);
    $filename = "{$directory}{$ds}{$class_name}.php";

	if (is_file($filename)) require $filename;
}

spl_autoload_register('_load');