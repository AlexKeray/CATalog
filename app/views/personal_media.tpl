{extends file="common/layout.tpl"}

{block name="content"}

<h2>Лична колекция</h2>

<hr>
<a href="{$base_url}/upload.php" class="btn btn-success mb-4">
    <i class="bi bi-plus-lg"></i> Добави филм/сериал
</a>
<hr>

    {if isset($media) && $media|@count > 0}  {* $media|@count брои колко елемента има в $media *}
        {foreach from=$media item=mediaItem}
            <div style="margin-bottom: 30px;">
                <h3>{$mediaItem.name}</h3>
                <button class="btn btn-danger btn-sm delete-media" data-id="{$mediaItem.id}">
                    Изтрий
                </button>
                <p>Тип: {$mediaItem.type_name}</p>
                <p>Жанр: {$mediaItem.genre_name}</p>
                <p>Година: {$mediaItem.year}</p>
                {if $mediaItem.type_name == "Сериал"}
                    <p>Брой епизоди: {$mediaItem.episodes_count}</p>
                {/if}
                <p>Продължителност: {$mediaItem.duration} минути</p>

                {if $mediaItem.image_path}
                    <img src="{$mediaItem.image_path}" alt="Постер" style="max-width: 200px;">
                {/if}
            <hr>
            </div>
        {/foreach}
    {else}
        <p>Няма добавени филми/сериали.</p>
    {/if}

{/block}

{block name="scripts"}
<script>
$(function () {
    $('.delete-media').on('click', function () {
        if (!confirm('Сигурен ли си, че искаш да изтриеш този филм?')) return;

        const button = $(this);
        const mediaId = button.data('id');

        $.ajax({
            url: '{$base_url}/delete.php',
            method: 'POST',
            data: { mediaId: mediaId },
            success: function () {
                button.closest('div').fadeOut(); // скрива целия блок с филма
            },
            error: function () {
                alert('Възникна грешка при изтриване.');
            }
        });
    });
});
</script>
{/block}