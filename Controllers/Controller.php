<?php

namespace Controllers;

use View;

class Controller
{
	public function index()
	{
		View::give('title', 'Page Title');
		View::render('index');
	}
}