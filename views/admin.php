<h3>Админка</h3>

<h4>Пользователи</h4>

<?php foreach ($users as $u): ?>
    <p>
        <?= $u['username'] ?> (<?= $u['role'] ?>)
        <a href="index.php?route=delete_user&id=<?= $u['id'] ?>">Удалить</a>
    </p>
<?php endforeach; ?>

<hr>

<h4>Посты</h4>

<?php foreach ($posts as $p): ?>
    <p>
        <?= htmlspecialchars($p['title']) ?>
        <a href="index.php?route=delete_post&id=<?= $p['id'] ?>">Удалить</a>
    </p>
<?php endforeach; ?>