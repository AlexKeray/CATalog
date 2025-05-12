{extends file="layout.tpl"}

{block name="content"}

    
    {if isset($user.id)}
        <h1>Здравей, {$user.username}!</h1>
    {else}
        <h1>Здравей!</h1>
    {/if}

        <h2>Списък с филми и сериали</h2>

        {if isset($media) && $media|@count > 0}  {* $media|@count брои колко елемента има в $media *}
            {foreach from=$media item=mediaItem}
                <div style="margin-bottom: 30px;">
                    <h3>{$mediaItem.name}</h3>
                    <p>Жанр: {$mediaItem.genre_name}</p>
                    <p>Година: {$mediaItem.year}</p>
                    <p>Продължителност: {$mediaItem.duration} минути</p>

                    {if $mediaItem.image_path}
                        <img src="{$mediaItem.image_path}" alt="Постер" style="max-width: 200px;">
                    {/if}
                </div>
                <hr>
            {/foreach}
        {else}
            <p>Няма добавени филми/сериали.</p>
        {/if}

{/block}
