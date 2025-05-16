{extends file="common/layout.tpl"}

{block name="content"}

<form action="{$base_url}/edit.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="media_id" value="{$media.id}">

    {if $media.image_path}
        <img src="{$base_url}/{$media.image_path}"  id="preview-image" alt="Постер" style="width: 200px; height: auto; margin-bottom: 10px;"><br>
    {else}
        <img src="{$base_url}/misc/question.jpg"  id="preview-image" alt="Без снимка" style="width: 200px; height: auto;"><br>
    {/if}

    <label>Тип:</label>
    <select name="type-id" id="type-select" required>
        <option value="">Избери тип</option>
        {foreach from=$types item=type}
            <option value="{$type.id}" {if $type.id == $media.type_id}selected{/if}>{$type.name}</option>
        {/foreach}
    </select><br><br>

    <label>Жанр:</label>
    <select name="genre" id="genre-select" required>
        <option value="">Избери жанр</option>
        {foreach from=$genres item=genre}
            <option value="{$genre.id}" {if $genre.id == $media.genre_id}selected{/if}>{$genre.name}</option>
        {/foreach}
        <option value="other">Друго</option>
    </select><br><br>

    <div id="custom-genre-wrapper" style="display: none;">
        <label for="custom_genre_name">Нов жанр:</label>
        <input type="text" name="custom_genre_name" id="custom_genre_name"><br><br>
    </div>

    <label>Име:</label>
    <input type="text" name="name" id="name" value="{$media.name}" required><br><br>

    <label>Снимка:</label>
    <input type="file" name="image" id="image" accept="image/*"><br><br>

    <input type="hidden" name="poster_url" id="poster_url">

    <label>Година:</label>
    <input type="number" name="year" id="year" min="1800" max="2100" value="{$media.year}"><br><br>

    <div id="episodes-wrapper" {if $media.type_id == 2}style="display: block;"{else}style="display: none;"{/if}>
        <label for="episodes_count">Брой епизоди:</label>
        <input type="number" name="episodes_count" id="episodes_count" min="1" value="{$media.episodes_count}"><br><br>
    </div>

    <label>Продължителност (в минути):</label>
    <input type="number" name="duration" id="duration" min="1" value="{$media.duration}"><br><br>

    <button type="submit">Запази промяната</button>
</form>

{/block}

{block name="scripts"}

<script>
    function handleToggleEpisodesInput() {
        $('#type-select').on('change', function () {
            const selected = $(this).find("option:selected").text().toLowerCase();

            if (selected === 'сериал') {
                $('#episodes-wrapper').slideDown(150);
            } else {
                $('#episodes-wrapper').slideUp(150);
                $('#episodes_count').val('');
            }
        });
    }

    function handleToggleNewGenreInput() {
        $('#genre-select').on('change', function () {
            const selected = $(this).find("option:selected").text().toLowerCase();

            if (selected === 'друго') {
                $('#custom-genre-wrapper').slideDown(150);
            } else {
                $('#custom-genre-wrapper').slideUp(150);
                $('#custom_genre_name').val('');
            }
        });
    }

    function handleImagePreview() {
        $('#image').on('change', function (event) {
            const fileInput = event.target;
            const preview = document.getElementById('preview-image');

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(fileInput.files[0]);
            }
        });
    }

    $(function () {
        handleToggleEpisodesInput();
        handleToggleNewGenreInput();
        handleImagePreview();

        $('#type-select').trigger('change');
        $('#genre-select').trigger('change');
    });
</script>

{/block}
