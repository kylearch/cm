<?php

require "../autoload.php";
require "../routes.php";

session_start();

$router = new Router();
$router->go();