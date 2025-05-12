{extends file="layout.tpl"}

{block name="content"}
<h2>Добави Филм/Сериал</h2>

<form action="/CATalog/upload.php" method="post" enctype="multipart/form-data">
    <label>Тип:</label>
    <select name="type" required>
        <option value="">Избери тип</option>
        {foreach from=$types item=type}
            <option value="{$type.id}">{$type.name}</option>
        {/foreach}
    </select><br><br>
    <label>Жанр:</label>
    <select name="genre" required>
        <option value="">Избери жанр</option>
        {foreach from=$genres item=genre}
            <option value="{$genre.id}">{$genre.name}</option>
        {/foreach}
    </select><br><br>

    <label>Име:</label>
    <input type="text" name="name" ><br><br>

    <label>Снимка:</label>
    <input type="file" name="image" accept="image/*"><br><br> {* accept="image/*" позволява качване само на файлове като .jpg, .png, .gif, .webp и други изображения. *}

    <label>Година:</label>
    <input type="number" name="year" min="1800" max="2100" required><br><br>

    <label>Продължителност (в минути):</label>
    <input type="number" name="duration" min="1" required><br><br>

    <button type="submit">Качи</button>
</form>

{/block}
