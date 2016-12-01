<?php

class View
{

	public static $vars = [];

	public static function render($view)
	{
		extract(self::$vars);
		$__filename = "Views/{$view}.php";
		include $__filename;
	}

	public static function give($name, $value)
	{
		self::$vars[$name] = $value;
	}

}