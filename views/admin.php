<h3>Админка</h3>

<h4>Пользователи</h4>

<?php foreach ($users as $u): ?>

    <p>
        <?= htmlspecialchars($u['username']) ?>
        (<?= $u['role'] ?>)

        <a href="index.php?route=delete_user&id=<?= $u['id'] ?>">
            Удалить
        </a>

        <?php if ($u['role'] === 'user'): ?>

            <a href="index.php?route=make_admin&id=<?= $u['id'] ?>">
                Сделать админом
            </a>

        <?php else: ?>

            <a href="index.php?route=make_user&id=<?= $u['id'] ?>">
                Сделать пользователем
            </a>

        <?php endif; ?>

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