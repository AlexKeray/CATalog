{extends file="common/layout.tpl"}

{block name="content"}
<h2>Добави Филм/Сериал</h2>

<form action="{$base_url}/upload.php" method="post" enctype="multipart/form-data">
    <label>Тип:</label>
    <select name="type-id" id="type-select" required>
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

    <div id="episodes-container"></div>

    <label>Продължителност (в минути):</label>
    <input type="number" name="duration" min="1" required><br><br>

    <button type="submit">Качи</button>
</form>

{/block}

{block name="scripts"}
<script>
$(function () {
    $('#type-select').on('change', function () {
        const selected = $(this).val();

        if ($(this).find("option:selected").text() === 'Сериал') {
            $('#episodes-container').html(`
                <label for="episodes_count">Брой епизоди:</label>
                <input type="number" name="episodes_count" id="episodes_count" class="form-control" min="1">
            `);
        } else {
            $('#episodes-container').empty();
        }
    });
});
</script>

{/block}