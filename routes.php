<?php

Router::register('/', ['controller' => 'UserController', 'function' => 'loginGet', 'method' => 'get']);

Router::register('users/login', ['controller' => 'UserController', 'function' => 'loginGet', 'method' => 'get']);
Router::register('users/login', ['controller' => 'UserController', 'function' => 'loginPost', 'method' => 'post']);
Router::register('users/logout', ['controller' => 'UserController', 'function' => 'logout', 'method' => 'get']);
Router::register('users/create', ['controller' => 'UserController', 'function' => 'create', 'method' => 'get']);
Router::register('users/store', ['controller' => 'UserController', 'function' => 'store', 'method' => 'post']);
Router::register('users/{id}', ['controller' => 'UserController', 'function' => 'profile', 'method' => 'get']);

Router::register('comments', ['controller' => 'CommentController', 'function' => 'index', 'method' => 'get']);
Router::register('comments/create', ['controller' => 'CommentController', 'function' => 'create', 'method' => 'get']);
Router::register('comments', ['controller' => 'CommentController', 'function' => 'store', 'method' => 'post']);
Router::register('comments/{comment}/delete', ['controller' => 'CommentController', 'function' => 'delete', 'method' => 'get']);
Router::register('comments/{comment}/similar', ['controller' => 'CommentController', 'function' => 'similar', 'method' => 'get']);