<?php View::render('partials/header'); ?>
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3">
			<form action="/users/login" method="post">
				<div class="form-group">
					<label for="username">Username:</label>
					<input type="text" name="username" id="username" class="form-control">
				</div>
				<div class="form-group">
					<label for="password">Password:</label>
					<input type="password" name="password" id="password" class="form-control">
				</div>
				<div class="form-group">
					<input type="submit" value="Login" class="btn btn-default">
				</div>
			</form>
		</div>
	</div>
<?php View::render('partials/footer'); ?>