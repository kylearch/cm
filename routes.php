<?php

Router::register('/', ['controller' => 'Controller', 'function' => 'index', 'method' => 'get']);

Router::register('user/login', ['controller' => 'UserController', 'function' => 'loginGet', 'method' => 'get']);
Router::register('user/login', ['controller' => 'UserController', 'function' => 'loginPost', 'method' => 'post']);
Router::register('user/logout', ['controller' => 'UserController', 'function' => 'logout', 'method' => 'get']);
Router::register('user/create', ['controller' => 'UserController', 'function' => 'create', 'method' => 'get']);
Router::register('user/store', ['controller' => 'UserController', 'function' => 'store', 'method' => 'post']);
Router::register('user', ['controller' => 'UserController', 'function' => 'profile', 'method' => 'get']);

Router::register('comments', ['controller' => 'CommentController', 'function' => 'index', 'method' => 'get']);
Router::register('comments/create', ['controller' => 'CommentController', 'function' => 'create', 'method' => 'get']);
Router::register('comments/store', ['controller' => 'CommentController', 'function' => 'store', 'method' => 'post']);
Router::register('comments/delete', ['controller' => 'CommentController', 'function' => 'delete', 'method' => 'get']);
Router::register('comments/{comment}/similar', ['controller' => 'CommentController', 'function' => 'similar', 'method' => 'get']);