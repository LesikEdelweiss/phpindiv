<h2><?= htmlspecialchars($post['title']) ?></h2>

<p><?= nl2br(htmlspecialchars($post['content_markdown'])) ?></p>

<p>Автор: <?= $post['username'] ?></p>

<hr>

<h3>Комментарии</h3>

<?php foreach ($comments as $comment): ?>
    <p>
        <b><?= $comment['username'] ?>:</b>
        <?= htmlspecialchars($comment['content']) ?>
    </p>
    <hr>
<?php endforeach; ?>

<?php if (isset($_SESSION['user'])): ?>
    <form method="POST" action="index.php?route=add_comment">
        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
        <textarea name="content" placeholder="Комментарий"></textarea>
        <br>
        <button>Отправить</button>
    </form>
<?php else: ?>
    <p>Войдите, чтобы оставить комментарий</p>
<?php endif; ?>