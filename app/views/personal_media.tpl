{extends file="common/layout.tpl"}

{block name="content"}

<h2 class="text-center text-white my-4">Твоите филми и сериали</h2>



<div class="d-flex justify-content-center flex-wrap gap-3 my-3">
    <a id="toggle-add-form" class="btn btn-outline-light rounded-pill">+ Добави филм или сериал</a>

    <a id="toggle-genre-form" class="btn btn-outline-light rounded-pill">+ Добави или редактирай жанр</a>

    <a class="btn btn-outline-success rounded-pill" href="{$base_url}/exportExcel">Експортирай в Excel</a>

    <a class="btn btn-outline-danger rounded-pill" href="{$base_url}/export_pdf">Експортирай в PDF</a>
</div>

<div id="add-form-wrapper" style="display: none; margin-bottom: 25px;">
    {include file="common/upload.tpl" allGenres=$allGenres}
    {include file="common/searchTmdb.tpl"}
</div>

<div id="genre-form-wrapper" style="display: none; margin-bottom: 25px;">
    {include file="editGenre.tpl" userGenres=$userGenres}
</div>

{if isset($media) && $media|@count > 0}  {* $media|@count брои колко елемента има в $media *}
    {include file="common/media.tpl" media=$media editMode=$editMode}
{else}
    <p class="text-center" style="color:white;">Няма добавени филми/сериали.</p>
{/if}



{/block}

{block name="scripts"}


<script>

    const baseUrl = '{$base_url}';

    function showAlert(message, type = 'message') {
        const $alert = $('#global-alert');

        const alertClasses = {
            message: 'alert-info',
            success: 'alert-success',
            warning: 'alert-warning',
            error:   'alert-danger'
        };

        // Нормализиране на типа
        let bootstrapClass;
        if (type in alertClasses) {
            bootstrapClass = alertClasses[type];
        } else {
            bootstrapClass = alertClasses.message;
        }

        // Показване на съобщението
        $alert
            .removeClass('d-none alert-info alert-success alert-warning alert-danger')
            .addClass('alert ' + bootstrapClass)
            .text(message)
            .fadeIn();

        setTimeout(() => $alert.fadeOut(), 5000);
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
                showAlert('Името е задължително.', 'error');
                return;
            }

            $.post(baseUrl + '/genre_create', { name, description }, function (res) {
                if (res.success && res.id) {
                    const option = $('<option>')
                        .val(res.id)
                        .attr('data-name', name)
                        .attr('data-description', description)
                        .text(name);

                    $('#genre-select, #edit-genre-select').append(option);

                    // Изчистване на полетата
                    $('#create-genre-name').val('');
                    $('#create-genre-description').val('');

                    showAlert('Жанрът е създаден успешно.', 'success');
                } else {
                    showAlert('Възникна грешка.', 'error');
                }
            }, 'json').fail(function (xhr) {
                const res = xhr.responseJSON || {};
                showAlert('Възникна грешка.', 'error');
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
                showAlert('Изберете жанр и попълнете име.', 'error');
                return;
            }

            $.post(baseUrl + '/genre_edit', { id, name, description }, function (res) {
                let alertType = 'success';

                switch (res.status) {
                    case 'unauthorized':
                        alertType = 'error';
                        break;
                    case 'no_change':
                        alertType = 'warning';
                        break;
                    case 'updated':
                    default:
                        alertType = 'success';
                        break;
                }

                if (res.status === 'updated') {
                    // Промяна в edit-genre-select
                    const $optionEdit = $('#edit-genre-select').find('option[value="' + id + '"]');
                    $optionEdit
                        .text(name)
                        .data('name', name)
                        .data('description', description);

                    // Промяна и в genre-select
                    const $optionAdd = $('#genre-select').find('option[value="' + id + '"]');
                    $optionAdd
                        .text(name)
                        .data('name', name)
                        .data('description', description);

                    // Обновяване на стойности
                    $select.val(id);
                    $('#edit-genre-name').val(name);
                    $('#edit-genre-description').val(description);
                }

                showAlert(res.message, alertType);
            }, 'json').fail(function (xhr) {
                const res = xhr.responseJSON || {};
                showAlert(res.message, 'error');
            });
        });
    }

    function handleDeleteGenre() {
        $('#delete-genre-btn').on('click', function () {
            const $select = $('#edit-genre-select');
            const id = $select.val();

            if (!id) {
                showAlert('Моля избери жанр за изтриване.', 'error');
                return;
            }

            if (!confirm('Сигурен ли си, че искаш да изтриеш този жанр?')) return;

            $.post(baseUrl + '/genre_delete', { id }, function (res) {
                // Премахване от всички селекти
                $('#edit-genre-select option[value="' + id + '"]').remove();
                $('#genre-select option[value="' + id + '"]').remove();

                // Изчистване на полетата
                $select.val('');
                $('#edit-genre-name').val('');
                $('#edit-genre-description').val('');

                showAlert('Жанрът е изтрит.', 'success');
            }, 'json').fail(function (xhr) {
                const res = xhr.responseJSON || {};
                showAlert('Възникна грешка.', 'error');
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

            // Изчистване на избрания файл от компютъра
            $('#image').val('');

            // Попълване на стойности
            $('#name').val(btn.data('title'));
            $('#year').val(btn.data('year'));
            $('#duration').val(btn.data('duration'));

            // Постер
            const posterUrl = btn.data('poster');
            const fallback = $('#poster_preview').data('fallback') || 'misc/questionWhite.png';

            if (posterUrl) {
                $('#poster_url').val(posterUrl);
                $('#poster_preview').attr('src', posterUrl);
            } else {
                $('#poster_url').val('');
                $('#poster_preview').attr('src', fallback);
            }

            // Тип
            $('#type-select option').each(function () {
                if ($(this).text().trim().toLowerCase() === btn.data('type').toLowerCase()) {
                    $('#type-select').val($(this).val()).trigger('change');
                }
            });

            // Жанр
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

            // Епизоди
            if (btn.data('type').toLowerCase() === 'сериал') {
                $('#episodes-wrapper').show();
                $('#episodes_count').val(btn.data('episodes'));
            } else {
                $('#episodes-wrapper').hide();
                $('#episodes_count').val('');
            }
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

    $(document).ready(function () {
        // Показване на избрана снимка от компютъра
        $('#image').on('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#poster_preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });

        // Показване на външна снимка (от TMDb)
        const posterUrl = $('#poster_url').val();
        if (posterUrl) {
            $('#poster_preview').attr('src', posterUrl);
        }
    });



    $(function () {

        const message = sessionStorage.getItem('genreMessage');
        const type = sessionStorage.getItem('genreMessageType');

        if (message) {
            showAlert(message, 'success');
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