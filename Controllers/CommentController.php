<?php

namespace Controllers;

use View;
use DB;

use Models\Comment;

class CommentController extends Controller
{

	public function __construct()
	{
		parent::__construct();
		if ( ! isset($_SESSION['userId'])) header('Location: /users/login');
	}

	public function index()
	{
		$comments = DB::getObject('Models\Comment',
			'SELECT `comments`.`*`, `users`.`username` FROM `comments` JOIN `users` ON `comments`.`userId` = `users`.`id` ORDER BY `created_at` DESC'
		);
		View::give('comments', $comments);
		View::give('pageTitle', 'All Comments');
		View::render('comments/index');
	}

	public function create()
	{
		View::give('pageTitle', 'New Comment');
		View::render('comments/create');
	}

	public function store()
	{
		$comment = new Comment(['comment' => $_POST['comment']]);
		if ($comment->isValid())
		{
			$comment->store();
			header('Location: /comments');
		}
		else
		{
			$_SESSION['error'] = 'Missing Required Fields';
			header('Location: /comments/create');
		}
	}

	public function delete($id)
	{
		$comment = DB::find('Models\Comment', $id);
		if ($comment) $comment->delete();
		else $_SESSION['error'] = 'Comment not found';
		$redirect = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '/comments' ;
		header("Location: {$redirect}");
	}

	public function similar($id)
	{
		$comment = DB::find('Models\Comment', $id);
		if ($comment)
		{
			$comments = $comment->similar();
			View::give('comments', $comments);
			View::give('pageTitle', 'Similar Comments');
			View::render('comments/index');
		}
		else
		{
			$_SESSION['error'] = 'Comment not found';
			header('Location: /comments');
		}
	}

}