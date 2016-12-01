<?php

namespace Controllers;

use View;
use DB;

class CommentController
{

	public function index()
	{
		$comments = DB::getObject('Models\Comment', 'SELECT * FROM `comments` ORDER BY `created_at` DESC');
		View::give('comments', $comments);
		View::give('page_title', 'Page Title');
		View::render('comments/index');
	}

	public function create()
	{

	}

	public function store()
	{

	}

	public function delete()
	{

	}

	public function similar()
	{

	}

}