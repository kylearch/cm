<?php

class DB
{
	
	private static $instance;
	private static $pdo;

	private function __construct()
	{
		// These values would ideally not be committed to a repository.
		$dsn       = "mysql:host=127.0.0.1;dbname=cm;charset=utf8";
		$username  = 'cm_user';
		$password  = 'password';
		self::$pdo = new PDO($dsn, $username, $password);
	}

	public function __destruct()
	{
		self::$pdo = NULL;
	}

	public static function init()
	{
		static $instance = NULL;
		if ($instance === NULL) $instance = new self();
		return $instance;
	}

	public static function query($sql, $bindings = [])
	{
		self::init();
		$statement = self::$pdo->prepare($sql);
		$statement->execute($bindings);
		return $statement;
	}

	public static function get($sql, $bindings = [])
	{
		$statement = self::query($sql, $bindings);
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	public static function getObject($class, $sql, $bindings = [])
	{
		$statement = self::query($sql, $bindings);
		return $statement->fetchAll(PDO::FETCH_CLASS, $class);
	}

}