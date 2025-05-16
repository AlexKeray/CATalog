{extends file="common/layout.tpl"}

{block name="content"}


<h2>Лична колекция</h2>

<a href="{$base_url}/exportExcel" class="btn btn-success">Експортирай в Excel</a>

<button id="toggle-add-form">+ Добави филм/сериал</button>

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

        handleToggleUploadForm();

        handleToggleEpisodesInput();

        handleToggleNewGenreInput();

        handleTMDbQueryAjax();
    
        handleFillUploadFormFromQuery();
    
        handleDeleteMedia();

    });
</script>




{/block}