<?php

class View
{

	public static $vars = [];

	public static function render($view, $vars = [])
	{
		foreach ($vars as $name => $value) self::give($name, $value);
		extract(self::$vars);
		$__filename = "Views/{$view}.php";
		include $__filename;
	}

	public static function give($name, $value)
	{
		self::$vars[$name] = $value;
	}

}