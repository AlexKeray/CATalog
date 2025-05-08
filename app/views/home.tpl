{extends file="layout.tpl"}

{block name="content"}

    {if $user === null}
    <h1>Моля, логни се.</h1>
    {else}
        <h1>Здравей, {$user}!</h1>
        <h2>Списък с филми и сериали</h2>

        {if isset($movies) && $movies|@count > 0}  {* $movies|@count брои колко елемента има в $movies *}
            {foreach from=$movies item=movie}
                <div style="margin-bottom: 30px;">
                    <h3>{$movie.name}</h3>
                    <p>Жанр: {$movie.genre_name}</p>
                    <p>Година: {$movie.year}</p>
                    <p>Продължителност: {$movie.duration} минути</p>

                    {if $movie.image_path}
                        <img src="{$movie.image_path}" alt="Постер" style="max-width: 200px;">
                    {/if}
                </div>
                <hr>
            {/foreach}
        {else}
            <p>Няма добавени филми/сериали.</p>
        {/if}
    {/if}

{/block}
