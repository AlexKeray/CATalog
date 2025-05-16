
<form action="{$base_url}/upload.php" method="post" enctype="multipart/form-data">
    <label>Тип:</label>
    <select name="type-id" id="type-select" required>
        <option value="">Избери тип</option>
        {foreach from=$types item=type}
            <option value="{$type.id}">{$type.name}</option>
        {/foreach}
    </select><br><br>
    <label>Жанр:</label>
    <select name="genre" id="genre-select" required>
        <option value="">Избери жанр</option>
        {foreach from=$genres item=genre}
            <option value="{$genre.id}">{$genre.name}</option>
        {/foreach}
        <option value="other">Друго</option>
    </select><br><br>

    <div id="custom-genre-wrapper" style="display: none;">
        <label for="custom_genre_name">Нов жанр:</label>
        <input type="text" name="custom_genre_name" id="custom_genre_name"><br><br>
    </div>

    <label>Име:</label>
    <input type="text" name="name" id="name" required><br><br>

    <label>Снимка:</label>
    <input type="file" name="image" id="image" accept="image/*"><br><br> {* accept="image/*" позволява качване само на файлове като .jpg, .png, .gif, .webp и други изображения. *}

    <input type="hidden" name="poster_url" id="poster_url">

    <label>Година:</label>
    <input type="number" name="year" id="year" min="1800" max="2100"><br><br>

    <div id="episodes-wrapper" style="display: none;">
        <label for="episodes_count">Брой епизоди:</label>
        <input type="number" name="episodes_count" id="episodes_count" min="1"><br><br>
    </div>


    <label>Продължителност (в минути):</label>
    <input type="number" name="duration" id="duration" min="1"><br><br>

    <button type="submit">Качи</button>
</form>

