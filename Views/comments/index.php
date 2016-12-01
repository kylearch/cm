<?php View::render('partials/header'); ?>
<?php foreach ($comments as $comment): ?>
	<article class="comment">
		<?= $comment->comment; ?>
	</article>
<?php endforeach; ?>
<?php View::render('partials/footer'); ?>