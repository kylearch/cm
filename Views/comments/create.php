<?php View::render('partials/header'); ?>
	<form action="/comments" method="post">
		<div class="form-group">
			<label for="comment">Comment:</label>
			<textarea name="comment" id="comment" class="form-control"></textarea>
		</div>
		<div class="form-group">
			<input type="submit" value="Save Comment" class="btn btn-default">
		</div>
	</form>
<?php View::render('partials/footer'); ?>