{extends file="common/layout.tpl"}

{block name="content"}


<h2>Лична колекция</h2>

<button id="toggle-add-form">+ Добави филм/сериал</button>

<button id="toggle-genre-form" class="btn btn-secondary">+ Редактирай/добави жанр</button>

<a href="{$base_url}/exportExcel" class="btn btn-success">Експортирай в Excel</a>

<div id="add-form-wrapper" style="display: none;">
    {include file="upload.tpl"}

    <p><strong>Попълни чрез търсачка</strong></p>

    <form id="tmdb-search-form" style="margin-bottom: 10px;">
        <input type="text" id="tmdb-query" placeholder="Търси заглавие..." required>
        <button type="submit">Търси</button>
        <div id="spinner" style="display: none; text-align: center; margin-top: 10px;">
            <img src="{$base_url}/misc/loading.gif" alt="Зареждане..." width="50">
        </div>
    </form>

    <div id="search-results"></div>

</div>

<div id="genre-form-wrapper" style="display: none;">
    {include file="editGenre.tpl"}
</div>

{if isset($media) && $media|@count > 0}  {* $media|@count брои колко елемента има в $media *}
    {foreach from=$media item=mediaItem}
        <div style="margin-bottom: 30px;">
            {if $mediaItem.image_path}
                <img src="{$mediaItem.image_path}" alt="Постер" style="width: 200px; height: auto;">
            {else}
                <img src="misc/question.jpg" alt="Без снимка" style="width: 200px; height: auto;">
            {/if}
            <h3>{$mediaItem.name}</h3>
            <button class="btn btn-danger btn-sm delete-media" data-id="{$mediaItem.id}">
                Изтрий
            </button>
            <form action="{$base_url}/edit/{$mediaItem.id}" method="get" style="display: inline;">
                <button class="btn btn-warning btn-sm">Промени</button>
            </form>
            <p>Тип: {$mediaItem.type_name}</p>
            <p>Жанр: {$mediaItem.genre_name}</p>
            <p>Година: {$mediaItem.year != '' ? $mediaItem.year : '-'}</p>
            {if $mediaItem.type_name == "Сериал"}
                <p>Брой епизоди: {$mediaItem.episodes_count != '' ? $mediaItem.episodes_count : '-'}</p>
            {/if}
            <p>Продължителност: {$mediaItem.duration != '' ? $mediaItem.duration : '-'}</p>

            
        <hr>
        </div>
    {/foreach}
{else}
    <p>Няма добавени филми/сериали.</p>
{/if}



{/block}

{block name="scripts"}

<script>

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
        $(this).text(isVisible ? '+ Добави филм/сериал' : '- Добави филм/сериал');
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

    function handleToggleGenreForm() {
        $('#toggle-genre-form').on('click', function () {
            const wrapper = $('#genre-form-wrapper');
            const isVisible = wrapper.is(':visible');
            wrapper.slideToggle(200);
            $(this).text(isVisible ? '+ Редактирай/добави жанр' : '- Редактирай/добави жанр');
        });

        $('#genre-select-main').on('change', function () {
            const selected = $(this).find('option:selected'); 
            const value = $(this).val();

            if (value === 'new') {
                $('#new-genre-fields').slideDown(150);
                $('#create-genre-btn').show();
                $('#edit-genre-btn, #delete-genre-btn').hide();
                $('input[name="genre_name"]').val('');
                $('textarea[name="genre_description"]').val('');
            } else if (value !== '') {
                $('#new-genre-fields').slideDown(150);
                $('#create-genre-btn').hide();
                $('#edit-genre-btn, #delete-genre-btn').show();
                const name = selected.data('name') || '';
                const desc = selected.data('description') || '';
                $('input[name="genre_name"]').val(name);
                $('textarea[name="genre_description"]').val(desc);
            } else {
                $('#new-genre-fields').slideUp(150);
                $('#create-genre-btn, #edit-genre-btn, #delete-genre-btn').hide();
                $('input[name="genre_name"]').val('');
                $('textarea[name="genre_description"]').val('');
            }
        });

        $('#create-genre-btn').on('click', function () {
        const name = $('input[name="genre_name"]').val();
        const description = $('textarea[name="genre_description"]').val();

        $.post('{$base_url}/genre_create.php', { name, description }, function (res) {
            location.reload();
            sessionStorage.setItem('genreMessage', res.message);
            sessionStorage.setItem('genreMessageType', 'success');
        }, 'json');
        });

        $('#edit-genre-btn').on('click', function () {
            const id = $('#genre-select-main').val();
            const name = $('input[name="genre_name"]').val();
            const description = $('textarea[name="genre_description"]').val();

            $.post('{$base_url}/genre_edit.php', { id, name, description }, function (res) {
                sessionStorage.setItem('genreMessage', res.message);
                sessionStorage.setItem('genreMessageType', 'success');
                location.reload();
            }, 'json');
        });



        $('#delete-genre-btn').on('click', function () {
            const id = $('#genre-select-main').val();

            if (!confirm('Сигурен ли си, че искаш да изтриеш този жанр?')) return;

            $.post('{$base_url}/genre_delete.php', { id }, function (res) {
                sessionStorage.setItem('genreMessage', res.message);
                sessionStorage.setItem('genreMessageType', 'success');
                location.reload();
            }, 'json').fail(function (xhr) {
                try {
                    const res = JSON.parse(xhr.responseText);
                    showGenreAlert(res.message, 'danger');
                } catch {
                    showGenreAlert('Възникна грешка при изтриването.', 'danger');
                }
            });
        });

    }


    function handleTMDbQueryAjax() {

        $('#tmdb-search-form').on('submit', function (e) {
            e.preventDefault();
            const query = $('#tmdb-query').val();

            $('#spinner').show();         // Покажи спинъра
            $('#search-results').empty(); // Изчисти предишни резултати

            $.get('{$base_url}/searchAjax', { query }, function (data) {
                $('#search-results').html(data);
            }).always(function () {
                $('#spinner').hide();     // Скрий спинъра при успех или грешка
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
        $(document).on('click', '.delete-media', function () {
            const btn = $(this);
            const mediaId = btn.data('id');

            if (!confirm('Сигурни ли сте, че искате да изтриете този филм/сериал?')) return;

            $.ajax({
                type: 'POST',
                url: '{$base_url}/delete.php',
                data: { mediaId: mediaId },
                success: function () {
                    btn.closest('div').slideUp(300, function () {
                        $(this).remove();
                    });
                },
                error: function () {
                    alert('Възникна грешка при изтриване.');
                }
            });
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

        handleToggleNewGenreInput();

        handleToggleGenreForm();

        handleTMDbQueryAjax();
    
        handleFillUploadFormFromQuery();
    
        handleDeleteMedia();

    });
</script>




{/block}