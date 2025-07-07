<div class="container d-flex justify-content-center">
    <div class="w-100" style="max-width: 800px;">
        <h4 class="text-center text-white my-2">Добави филм или сериал</h4>
        <form class="text-white mt-4" action="{$base_url}/upload.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <!-- Лява колона -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="type-select" class="form-label">Тип:</label>
                        <select name="type-id" id="type-select" class="form-select" required>
                            <option value=""></option>
                            {foreach from=$types item=type}
                                <option value="{$type.id}">{$type.name}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Име:</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Снимка:</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    </div>

                    <div id="episodes-wrapper" style="display: none;" class="mb-3">
                        <label for="episodes_count" class="form-label">Брой епизоди:</label>
                        <input type="number" name="episodes_count" id="episodes_count" class="form-control" min="1">
                    </div>
                </div>

                <!-- Дясна колона -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="genre-select" class="form-label">Жанр:</label>
                        <select name="genre" id="genre-select" class="form-select" required>
                            <option value=""></option>
                            {foreach from=$genres item=genre}
                                <option value="{$genre.id}">{$genre.name}</option>
                            {/foreach}
                        </select>
                    </div>

                    <div id="custom-genre-wrapper" style="display: none;" class="mb-3">
                        <label for="custom_genre_name" class="form-label">Нов жанр:</label>
                        <input type="text" name="custom_genre_name" id="custom_genre_name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="year" class="form-label">Година:</label>
                        <input type="number" name="year" id="year" class="form-control" min="1800" max="2100">
                    </div>
                    
                    <div class="mb-3">
                        <label for="duration" class="form-label">Продължителност (в минути):</label>
                        <input type="number" name="duration" id="duration" class="form-control" min="1">
                    </div>
                    
                </div>
            </div>

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-outline-primary rounded-pill px-5 py-1">Запази</button>
            </div>
        </form>
    </div>
</div>
