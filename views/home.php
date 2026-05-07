<h3>Посты</h3>

<form method="GET" action="index.php">
    <input type="hidden" name="route" value="search">
    <input type="text" name="q" placeholder="Поиск...">
    <button>Найти</button>
</form>

<hr>

<?php foreach ($posts as $post): ?>
    <div>
        <h4>
            <a href="index.php?route=post&id=<?= $post['id'] ?>">
                <?= htmlspecialchars($post['title']) ?>
            </a>
        </h4>
        <p>Автор: <?= $post['username'] ?></p>
    </div>
    <hr>
<?php endforeach; ?>