<?php View::render('partials/header'); ?>
<?php foreach ($comments as $comment): ?>
	<?php View::render('partials/comment', ['comment' => $comment]); ?>
<?php endforeach; ?>
<?php View::render('partials/footer'); ?>