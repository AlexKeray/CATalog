{extends file="common/layout.tpl"}

{block name="content"}

<h2 class="text-center text-white my-4">Твоите филми и сериали</h2>



<div class="d-flex justify-content-center flex-wrap gap-3 my-3">
    <a id="toggle-add-form" class="btn btn-outline-light rounded-pill">+ Добави филм или сериал</a>

    <a id="toggle-genre-form" class="btn btn-outline-light rounded-pill">+ Добави или редактирай жанр</a>

    <a class="btn btn-outline-success rounded-pill" href="{$base_url}/exportExcel">Експортирай в Excel</a>

    <a class="btn btn-outline-danger rounded-pill" href="{$base_url}/export_pdf">Експортирай в PDF</a>
</div>

<div id="add-form-wrapper" style="display: none;">
    {include file="common/upload.tpl"}
    {include file="common/searchTmdb.tpl"}
</div>

<div id="genre-form-wrapper" style="display: none;">
    {include file="editGenre.tpl"}
</div>

{if isset($media) && $media|@count > 0}  {* $media|@count брои колко елемента има в $media *}
    {include file="common/media.tpl" media=$media editMode=$editMode}
{else}
    <p>Няма добавени филми/сериали.</p>
{/if}



{/block}

{block name="scripts"}


<script>

    const baseUrl = '{$base_url}';

    function showGenreAlert(message, type = 'success') {
        const html = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
        message +
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Затвори"></button>' +
        '</div>';

        $('#genre-alert-placeholder').html(html);
    }

    function handleToggleUploadForm() {

        $('#toggle-add-form').on('click', function () {
        const wrapper = $('#add-form-wrapper');
        const isVisible = wrapper.is(':visible');

        wrapper.slideToggle(200);
        $(this).text(isVisible ? '+ Добави филм или сериал' : '- Добави филм или сериал');
        });
    }

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

    function handleToggleGenreForms() {
        $('#toggle-genre-form').on('click', function () {
            const wrapper = $('#genre-form-wrapper');
            const isVisible = wrapper.is(':visible');
            wrapper.slideToggle(200);
            $(this).text(isVisible ? '+ Добави или редактирай жанр' : '- Добави или редактирай жанр');
        });
    }

    function handleSwappingGenreForms() {
        const $createBtn = $('[data-mode="create"]');
        const $editBtn = $('[data-mode="edit"]');
        const $createForm = $('#create-genre-form');
        const $editForm = $('#edit-genre-form');
        const $createSubmit = $('#create-genre-btn');
        const $editSubmit = $('#edit-genre-btn');
        const $deleteSubmit = $('#delete-genre-btn');

        function setMode(mode) {
            if (mode === 'create') {
                $createForm.show();
                $editForm.hide();

                $createSubmit.show();
                $editSubmit.hide();
                $deleteSubmit.hide();

                $createBtn.removeClass('btn-outline-light').addClass('btn-light');
                $editBtn.removeClass('btn-light').addClass('btn-outline-light');

                // Изчисти полетата
                $createForm.find('input[name="genre_name"]').val('');
                $createForm.find('textarea[name="genre_description"]').val('');
            } else {
                $editForm.show();
                $createForm.hide();

                $editSubmit.show();
                $deleteSubmit.show();
                $createSubmit.hide();

                $editBtn.removeClass('btn-outline-light').addClass('btn-light');
                $createBtn.removeClass('btn-light').addClass('btn-outline-light');
            }
        }



        $createBtn.on('click', function () {
            setMode('create');
        });

        $editBtn.on('click', function () {
            setMode('edit');
        });

        setMode('create'); // По подразбиране стартира с "Добави жанр"
    }

    function handleGenreSelectFill() {
        $('#edit-genre-select').on('change', function () {
            const selected = $(this).find('option:selected');
            const name = selected.attr('data-name') || '';
            const description = selected.attr('data-description') || '';

            $('#edit-genre-name').val(name);
            $('#edit-genre-description').val(description);
        });
    }


    function handleCreateGenre() {
        $('#create-genre-btn').on('click', function () {
            const name = $('#create-genre-name').val().trim();
            const description = $('#create-genre-description').val().trim();

            if (!name) {
                showGenreAlert('Името е задължително.', 'danger');
                return;
            }

            $.post(baseUrl + '/genre_create', { name, description }, function (res) {
                if (res.success && res.id) {
                    const option = $('<option>')
                        .val(res.id)
                        .attr('data-name', name)
                        .attr('data-description', description)
                        .text(name);
                    $('#edit-genre-select').append(option);
                    showGenreAlert(res.message, 'success');
                } else {
                    showGenreAlert(res.message || 'Грешка при създаване.', 'danger');
                }
            }, 'json').fail(function (xhr) {
                const res = xhr.responseJSON || {};
                showGenreAlert(res.message || 'Възникна грешка при заявката.', 'danger');
            });
        });
    }


function handleEditGenre() {
    $('#edit-genre-btn').on('click', function () {
        const $select = $('#edit-genre-select');
        const id = $select.val();
        const name = $('#edit-genre-name').val().trim();
        const description = $('#edit-genre-description').val().trim();

        if (!id || !name) {
            showGenreAlert('Изберете жанр и попълнете име.', 'danger');
            return;
        }

        $.post(baseUrl + '/genre_edit', { id, name, description }, function (res) {
            const $option = $select.find('option[value="' + id + '"]');
            $option
                .text(name)
                .data('name', name)
                .data('description', description);

            $select.val(id);
            $('#edit-genre-name').val(name);
            $('#edit-genre-description').val(description);
            showGenreAlert(res.message || 'Жанрът е редактиран.', 'success');
        }, 'json').fail(function (xhr) {
            const res = xhr.responseJSON || {};
            showGenreAlert(res.message || 'Грешка при редакцията.', 'danger');
        });
    });
}




    function handleDeleteGenre() {
        $('#delete-genre-btn').on('click', function () {
            const $select = $('#edit-genre-select');
            const id = $select.val();

            if (!id) {
                showGenreAlert('Моля избери жанр за изтриване.', 'danger');
                return;
            }

            if (!confirm('Сигурен ли си, че искаш да изтриеш този жанр?')) return;

            $.post(baseUrl + '/genre_delete', { id }, function (res) {
                $select.find('option[value="' + id + '"]').remove();
                $select.val('');
                $('#edit-genre-name').val('');
                $('#edit-genre-description').val('');
                showGenreAlert(res.message || 'Жанрът е изтрит.', 'success');
            }, 'json').fail(function (xhr) {
                const res = xhr.responseJSON || {};
                showGenreAlert(res.message || 'Грешка при изтриването.', 'danger');
            });
        });
    }



    function handleTMDbQueryAjax() {
        $(document).ready(function () {
            $('#search-button').on('click', function () {
                const query = $('#tmdb-query').val();

                $('#spinner').show();
                $('#search-results').empty();

                $.get('{$base_url}/searchAjax', { query }, function (data) {
                    $('#search-results').html(data);
                }).always(function () {
                    $('#spinner').hide();
                });
            });
        });
    }

    function handleFillUploadFormFromQuery() {
        $('#search-results').on('click', '.fill-form-btn', function () {
            const btn = $(this);

            $('#name').val(btn.data('title'));
            $('#year').val(btn.data('year'));
            $('#duration').val(btn.data('duration'));
            $('#type-select option').each(function () {
                if ($(this).text().trim().toLowerCase() === btn.data('type').toLowerCase()) {
                    $('#type-select').val($(this).val()).trigger('change');
                }
            });

            const genreText = btn.data('genre').trim();
            let matched = false;

            $('#genre-select option').each(function () {
                if ($(this).text().trim().toLowerCase() === genreText.toLowerCase()) {
                    $('#genre-select').val($(this).val()).trigger('change');
                    matched = true;
                }
            });

            if (!matched) {
                $('#genre-select').val('other').trigger('change');
                $('#custom_genre_name').val(genreText);
            }

            if (btn.data('type') === 'сериал') { // или 'Сериал', ако подаваш текст
                $('#episodes-container').html(`
                    <label for="episodes_count">Брой епизоди:</label>
                    <input type="number" name="episodes_count" id="episodes_count" class="form-control" min="1">
                `);
                $('#episodes_count').val(btn.data('episodes'));
            } else {
                $('#episodes-container').empty();
            }

            const posterUrl = btn.data('poster');
            $('#poster_url').val(posterUrl);
        });
    }

    function handleDeleteMedia() {
        $(document).on('click', '.delete-btn', function () {
            const id = $(this).data('id');
            const $btn = $(this);

            if (confirm('Сигурен ли си, че искаш да изтриеш този елемент?')) {
                $.ajax({
                    url: baseUrl + '/delete',
                    method: 'POST',
                    data: { id: id },
                    success: function () {
                        // Премахни родителския елемент, напр. цялата карта/ред
                        $btn.closest('.media-item').remove();
                    },
                    error: function () {
                        alert('Грешка при изтриване.');
                    }
                });
            }
        });
    }


    $(function () {

        const message = sessionStorage.getItem('genreMessage');
        const type = sessionStorage.getItem('genreMessageType');

        if (message) {
            showGenreAlert(message, type || 'success');
            sessionStorage.removeItem('genreMessage');
            sessionStorage.removeItem('genreMessageType');
        }

        handleToggleUploadForm();

        handleToggleEpisodesInput();

        handleToggleGenreForms();

        handleSwappingGenreForms();

        handleGenreSelectFill();

        handleCreateGenre();

        handleEditGenre();

        handleDeleteGenre();

        handleTMDbQueryAjax();
    
        handleFillUploadFormFromQuery();
    
        handleDeleteMedia();



    });
</script>




{/block}