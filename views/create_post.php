<h3>Создать пост</h3>

<form method="POST" action="index.php?route=create_post">

    <!-- 1. TEXT -->
    <input 
        type="text" 
        name="title" 
        placeholder="Заголовок"
        required
        minlength="3"
    >
    <br><br>

    <!-- 2. TEXTAREA -->
    <textarea 
        name="content" 
        placeholder="Markdown текст"
        required
        minlength="10"
    ></textarea>
    <br><br>

    <!-- 3. SELECT -->
    <select name="category" required>
        <option value="">Выберите категорию</option>
        <option value="tech">Tech</option>
        <option value="news">News</option>
        <option value="life">Life</option>
    </select>
    <br><br>

    <!-- 4. CHECKBOX -->
    <label>
        <input type="checkbox" name="is_public">
        Публичный пост
    </label>
    <br><br>

    <!-- 5. RADIO -->
    <p>Уровень доступа:</p>

    <label>
        <input type="radio" name="access_level" value="all" required>
        Для всех
    </label>

    <label>
        <input type="radio" name="access_level" value="registered">
        Только для зарегистрированных
    </label>

    <br><br>

    <button type="submit">Создать пост</button>

</form>