
<form id="genre-form">
    <label for="genre-select-main">Жанр:</label>
    <select id="genre-select-main" name="genre">
        <option value="">Избери жанр</option>
        <option value="new">Създай нов жанр</option>
        {foreach from=$genres item=genre}
            <option value="{$genre.id}" data-name="{$genre.name|escape}" data-description="{$genre.description|default:''|escape}">{$genre.name}</option>
        {/foreach}
    </select>

    <div id="new-genre-fields" style="display: none; margin-top: 10px;">
        <label for="genre_name">Име:</label>
        <input type="text" name="genre_name" placeholder="Име на жанра">
        <label for="genre_description">Описание:</label>
        <textarea name="genre_description" placeholder="Описание"></textarea>
    </div>

    <div id="genre-buttons" style="margin-top: 10px;">
        <button type="button" id="create-genre-btn" style="display: none;">Създай</button>
        <button type="button" id="edit-genre-btn" style="display: none;">Редактирай</button>
        <button type="button" id="delete-genre-btn" style="display: none;">Изтрий</button>
    </div>
</form>
