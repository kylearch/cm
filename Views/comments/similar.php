<?php View::render('partials/header'); ?>
<?php foreach ($comment->similar() as $comment): ?>
	<article class="panel panel-default row">
		<div class="panel-body">
			<div class="col-xs-12 col-md-8">
				<?= $comment->comment; ?>
			</div>
			<div class="col-xs-12 col-md-4">
				<dl class="dl-horizontal">
					<dt>Author:</dt>
					<dd><a href="/users/<?= $comment->userId; ?>"><?= $comment->username; ?></a></dd>

					<dt>Unicode Characters:</dt>
					<dd><?= $comment->length; ?></dd>

					<dt>Two Letter Words:</dt>
					<dd><?= $comment->twoLetterWords; ?></dd>

					<dt>Capital Letters:</dt>
					<dd><?= $comment->capitalLetters; ?></dd>

					<dt>Similar Comments:</dt>
					<dd><a href="/comments/<?= $comment->id; ?>/similar">Go To Similar</a></dd>
				</dl>
			</div>
		</div>
	</article>
<?php endforeach; ?>
<?php View::render('partials/footer'); ?>