<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?= $pageTitle; ?></title>

  <!-- CSS -->
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-xs-12" style="padding: 10px 0;">
					<?php if (isset($_SESSION['userId'])): ?>
						<a href="/users/logout">Logout</a>
						<a href="/comments" class="pull-right" style="margin: 0 10px;">All Comments</a>
						<a href="/comments/create" class="pull-right" style="margin: 0 10px;">New Comment</a>
					<?php elseif (Router::currentRoute() !== "users/login"): ?>
						<a href="/users/login">Login</a>
					<?php elseif (Router::currentRoute() === "users/login"): ?>
						<a href="/users/create">Create User</a>
					<?php endif; ?>
				</div>
			</div>
			<div class="row">
				<?php if (isset($error)): ?>
				<div class="alert alert-danger">
					<p><?= $error; ?></p>
				</div>
				<?php endif; ?>
			</div>
			<div class="row">
				<div class="col-xs-12">