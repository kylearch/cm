<?php

namespace Controllers;

use View;
use DB;

use Models\User;

class UserController extends Controller
{

	public function loginGet()
	{
		if (isset($_SESSION['userId']))
		{
			header('Location: /comments');
		}
		else
		{
			View::give('pageTitle', 'Login');
			View::render('user/login');
		}
	}

	public function loginPost()
	{
		$user = User::login($_POST['username'], $_POST['password']);
		if ($user)
		{
			$_SESSION['userId'] = $user->id;
			$_SESSION['username'] = $user->username;
			header('Location: /comments');
		}
		else
		{
			$_SESSION['error'] = 'Invalid Login Credentials';
			header('Location: /users/login');
		}
	}

	public function logout()
	{
		if (isset($_SESSION['userId'])) unset($_SESSION['userId']);
		if (isset($_SESSION['username'])) unset($_SESSION['username']);
		header('Location: /users/login');
	}

	public function create()
	{
		View::give('pageTitle', 'New User');
		View::render('user/create');	
	}

	public function store()
	{
		$user = new User($_POST);
		if ($user->isValid())
		{
			$user->store();
			header('Location: /users/login');
		}
		else
		{
			$_SESSION['error'] = 'Missing Required Fields';
			header('Location: /users/create');
		}
	}

	public function profile($id)
	{
		if ( ! isset($_SESSION['userId'])) header('Location: /users/login');

		$user = DB::find('Models\User', $id);
		if ($user)
		{
			$comments = DB::getObject('Models\Comment',
				'SELECT `comments`.`*`, `users`.`username` FROM `comments` JOIN `users` ON `comments`.`userId` = `users`.`id` WHERE `userId` = :userId',
				['userId' => $id]
			);
			View::give('user', $user);
			View::give('comments', $comments);
			View::give('pageTitle', $user->username . "'s Profile");
			View::render('user/profile');
		}
		else
		{
			$_SESSION['error'] = 'User not found';
			header('Location: /comments');
		}
	}

}