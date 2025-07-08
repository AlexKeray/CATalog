<form class="text-white" action="{$submit_url}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="media_id" value="{$media.id}">

    <div class="d-flex justify-content-center align-items-center flex-wrap gap-5">
        <!-- Лява колона: полетата -->
        <div style="flex: 1 1 360px; max-width: 360px;">
            <div class="mb-3">
                <label for="type-select" class="form-label">Тип:</label>
                <select name="type-id" id="type-select" class="form-select" required>
                    <option value="">Избери тип</option>
                    {foreach from=$types item=type}
                        <option value="{$type.id}" {if $type.id == $media.type_id}selected{/if}>{$type.name}</option>
                    {/foreach}
                </select>
            </div>

            <div class="mb-3">
                <label for="genre-select" class="form-label">Жанр:</label>
                <select name="genre" id="genre-select" class="form-select">
                    <option value=""></option>
                    {foreach from=$allGenres item=genre}
                        <option value="{$genre.id}" {if $genre.id == $media.genre_id}selected{/if}>{$genre.name}</option>
                    {/foreach}
                </select>
            </div>

            <div class="mb-3" id="custom-genre-wrapper" style="display: none;">
                <label for="custom_genre_name" class="form-label">Нов жанр:</label>
                <input type="text" name="custom_genre_name" id="custom_genre_name" class="form-control">
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Име:</label>
                <input type="text" name="name" id="name" value="{$media.name}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Снимка:</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
            </div>

            <input type="hidden" name="poster_url" id="poster_url">

            <div class="mb-3">
                <label for="year" class="form-label">Година:</label>
                <input type="number" name="year" id="year" class="form-control" min="1800" max="2100" value="{$media.year}">
            </div>

            <div class="mb-3">
                <label for="duration" class="form-label">Продължителност (в минути):</label>
                <input type="number" name="duration" id="duration" class="form-control" min="1" value="{$media.duration}">
            </div>

            <div class="mb-3" id="episodes-wrapper" {if $media.type_id == 2}style="display: block;"{else}style="display: none;"{/if}>
                <label for="episodes_count" class="form-label">Брой епизоди:</label>
                <input type="number" name="episodes_count" id="episodes_count" class="form-control" min="1" value="{$media.episodes_count}">
            </div>
        </div>

        <!-- Дясна колона: preview снимка, центрирана вертикално -->
        <div class="card movie-card position-relative overflow-hidden bg-dark border" style="max-height: 450px; max-width: 300px; border-color: black !important">
            <!-- Снимка без изрязване -->
            <div class="d-flex justify-content-center align-items-center bg-dark">
                {if $media.image_path}
                    <img id="preview" src="{$base_url}/{$media.image_path}" class="img-fluid object-fit-contain" style="max-height: 100%; max-width: 100%;" alt="Постер">
                {else}
                    <img id="preview" src="{$base_url}/misc/questionWhite.png" class="img-fluid object-fit-contain" style="max-height: 100%; max-width: 100%;" alt="Постер">
                {/if}
            </div>
        </div>

    </div>

    <!-- Центриран бутон -->
    <div class="text-center mt-4  mb-4">
        <button type="submit" class="btn btn-outline-primary rounded-pill px-4">{$submit_text}</button>
    </div>
</form>


<!-- {$base_url}/edit.php -->