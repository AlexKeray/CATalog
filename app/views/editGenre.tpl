<div class="container d-flex justify-content-center">
    <div class="w-100" style="max-width: 800px;">
        <h4 class="text-center text-white my-2">Добави или редактирай жанр</h4>

        <div class="d-flex justify-content-center flex-wrap gap-3 my-3">
                <button type="button" class="btn btn-light rounded-pill" data-mode="create">Добави жанр</button>
                <button type="button" class="btn btn-outline-light rounded-pill" data-mode="edit">Редактирай жанр</button>
        </div>

        <form id="create-genre-form" class="text-white mt-4 text-center" style="display: none;">
            <div id="new-genre-fields" class="w-50 mx-auto">
                <div class="mb-3 text-start">
                    <label for="create-genre-name" class="form-label">Име:</label>
                    <input id="create-genre-name" type="text" name="create-genre-name" class="form-control" placeholder="Име на жанра">
                </div>
                <div class="mb-3 text-start">
                    <label for="create-genre-description" class="form-label">Описание:</label>
                    <textarea id="create-genre-description" name="create-genre-description" class="form-control" rows="4" placeholder="Описание"></textarea>
                </div>
                <button type="button" id="create-genre-btn" class="btn btn-outline-success rounded-pill px-4 py-1 me-2" style="display: none;">Създай</button>
            </div>
        </form>

        <form id="edit-genre-form" class="text-white mt-4 text-center" style="display: none;">
            <div class="w-50 mx-auto">
                <div class="mb-3 text-start">
                    <label for="edit-genre-select" class="form-label">Жанр:</label>
                    <select id="edit-genre-select" name="genre" class="form-select">
                        <option value=""></option>
                        {foreach from=$userGenres item=genre}
                            <option value="{$genre.id}" data-name="{$genre.name|escape}" data-description="{$genre.description|default:''|escape}">
                                {$genre.name}
                            </option>
                        {/foreach}
                    </select>
                </div>

                <div id="new-genre-fields">
                    <div class="mb-3 text-start">
                        <label for="edit-genre_name" class="form-label">Име:</label>
                        <input type="text" id="edit-genre-name" name="edit-genre-name" class="form-control" placeholder="Име на жанра">
                    </div>
                    <div class="mb-3 text-start">
                        <label for="edit-genre-description" class="form-label">Описание:</label>
                        <textarea id="edit-genre-description" name="edit-genre-description" class="form-control" rows="4" placeholder="Описание"></textarea>
                    </div>
                </div>

                <div id="genre-buttons" class="text-center mt-3">
                    <button type="button" id="edit-genre-btn" class="btn btn-outline-warning rounded-pill px-4 py-1 me-2" style="display: none;">Редактирай</button>
                    <button type="button" id="delete-genre-btn" class="btn btn-outline-danger rounded-pill px-4 py-1" style="display: none;">Изтрий</button>
                </div>
            </div>
        </form>

    </div>
</div>
