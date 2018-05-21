<?php
use app\models\Page;
/** @var Page $content */
?>
<div class="contact-text">
	<h3><?= $content->title ?></h3>
	<address>
		<?= nl2br($content->content) ?>
	</address>
</div>

