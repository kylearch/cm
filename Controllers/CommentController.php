<?php

namespace Controllers;

use View;
use DB;

use Models\Comment;

class CommentController
{

	public function __construct()
	{
		if ( ! isset($_SESSION['userId']))
		{
			header('Location: /users/login');
		}
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
		View::give('page_title', 'Page Title');
		View::render('comments/create');
	}

	public function store()
	{
		$comment = new Comment(['comment' => $_POST['comment']]);
		$comment->store();
		header('Location: /comments');
	}

	public function delete($id)
	{
		$comment = DB::find('Models\Comment', $id);
		if ($comment) $comment->delete();
		$redirect = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '/comments' ;
		header("Location: {$redirect}");
	}

	public function similar($id)
	{
		$comment = DB::find('Models\Comment', $id);
		$comments = $comment->similar();
		View::give('comments', $comments);
		View::give('pageTitle', 'Similar Comments');
		View::render('comments/index');
	}

}