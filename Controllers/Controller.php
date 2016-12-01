<?php

namespace Controllers;

use View;

class Controller
{

	public function __construct()
	{
		if (isset($_SESSION['error']))
		{
			View::give('error', $_SESSION['error']);
			unset($_SESSION['error']);
		}
	}

}