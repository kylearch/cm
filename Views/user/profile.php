<?php View::render('partials/header'); ?>
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-body">
				<dl class="dl-horizontal">
					<dt>Username:</dt>
					<dd><?= $user->username; ?></dd>

					<dt>Email:</dt>
					<dd><?= $user->email; ?></dd>

					<dt>Number of Comments:</dt>
					<dd><?= $user->numComments; ?></dd>
				</dl>
			</div>
		</div>
	</div>

	<?php foreach ($comments as $comment): ?>
		<?php View::render('partials/comment', ['comment' => $comment]); ?>
	<?php endforeach; ?>
<?php View::render('partials/footer'); ?>