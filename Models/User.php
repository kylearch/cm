<?php

namespace Models;

use DB;

class User extends Model
{

	public static $table = 'users';

	public $id;
	public $username;
	public $email;
	public $numComments;

	protected $password;

	public function store()
	{
		$values = [
			'username'   => $this->username,
			'email'      => $this->email,
			'password'   => password_hash($this->password, PASSWORD_DEFAULT),
		];
		DB::query('INSERT INTO `' . self::$table . '` 
			(`username`, `email`, `password`)
			VALUES
			(:username, :email, :password)',
			$values
		);
	}

	public static function login($username, $password)
	{
		$user = DB::getOne('Models\User',
			'SELECT `id`, `username`, `password` FROM `users` WHERE `username` = :username',
			['username' => $username]
		);
		return (password_verify($password, $user->password)) ? $user : FALSE ;
	}

}