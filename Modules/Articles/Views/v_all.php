<h1>Home</h1>
<?php foreach($articles as $article): ?>
<div class="article-item">
	<h2><?=$article['title']?></h2>
	<div class="dt"><?=$article['dt']?></div>
	<div class="link">
		<a href="<?=BASE_URL?>article/<?=$article['id_article']?>">Read more...</a>
	</div>
</div>
<?php endforeach; ?>