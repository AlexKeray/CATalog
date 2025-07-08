<style>
.movie-overlay {
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
    background-color: rgba(0, 0, 0, 0.8); /* прозрачен фон */
}

.movie-card:hover .movie-overlay {
    opacity: 1;
    pointer-events: all;
}

.border-darker {
    border-color: #121212 !important; /* по-тъмен от bg-dark */
}

</style>

<div class="media-item col-6 col-sm-4 col-md-4 col-lg-3 col-xl-3 col-xxl-2">
    <div class="card movie-card position-relative overflow-hidden bg-dark border border-darker" style="max-height: 80vh; min-height: 300px;">
        
        <!-- Снимка без изрязване -->
        <div class="d-flex justify-content-center align-items-center bg-dark" style="height: 350px; overflow: hidden;">
            {if $mediaItem.image_path}
                <img src="{$mediaItem.image_path}" class="img-fluid" style="height: 100%; width: auto; object-fit: contain;" alt="Постер">
            {else}
                <img src="misc/questionWhite.png" class="img-fluid" style="height: 100%; width: auto; object-fit: contain;" alt="Постер">
            {/if}
        </div>


        <!-- Заглавие (винаги видимо) -->
        <div class="position-absolute bottom-0 start-0 w-100 text-center text-white bg-dark bg-opacity-75 py-2">
            <strong>{$mediaItem.name}</strong>
        </div>

        <!-- Overlay -->
        <div class="movie-overlay position-absolute top-0 start-0 w-100 h-100 text-white d-flex flex-column justify-content-between text-center px-3 py-3" style="background-color: rgba(0,0,0,0.75);">
            
            <div class="mt-auto mb-auto">
                {if $mediaItem.name === null || $mediaItem.name === ''}
                    <p class="mb-1">???</p>
                {else}
                    <h5 class="mb-3">{$mediaItem.name}</h5>
                {/if}
                {if $mediaItem.type_name === null || $mediaItem.type_name === ''}
                    <p class="mb-1">Тип: ???</p>
                {else}
                    <p class="mb-1">Тип: {$mediaItem.type_name}</p>
                {/if}
                {if $mediaItem.genre_name === null || $mediaItem.genre_name === ''}
                    <p class="mb-1">Жанр: ???</p>
                {else}
                    <p class="mb-1">Жанр: {$mediaItem.genre_name}</p>
                {/if}
                {if $mediaItem.year === null || $mediaItem.year === ''}
                    <p class="mb-1">Година: ???</p>
                {else}
                    <p class="mb-1">Година: {$mediaItem.year}</p>
                {/if}
                {if $mediaItem.type_name == "Сериал"}
                    {if $mediaItem.episodes_count === null || $mediaItem.episodes_count === '' || $mediaItem.episodes_count === 0}
                        <p class="mb-1">Епизоди: ???</p>
                    {else}
                        <p class="mb-1">Епизоди: {$mediaItem.episodes_count}</p>
                    {/if}
                {/if}
                <p class="mb-1">Продължителност:</p>
                <p class="mb-1">
                    {if $mediaItem.duration === null || $mediaItem.duration === ''}
                        ???
                    {elseif $mediaItem.duration == 1}
                        1 минута
                    {else}
                        {$mediaItem.duration} минути
                    {/if}
                </p>
            </div>

            {if $editMode == true}
                <div class="d-flex justify-content-center gap-3 pt-2 pb-1">
                    <a href="{$base_url}/edit/{$mediaItem.id}" class="icon-btn">
                        <img src="misc/editWhite.svg" alt="Редактирай" width="24" height="24">
                    </a>
                    <button class="btn p-0 bg-transparent border-0 icon-btn delete-btn" data-id="{$mediaItem.id}">
                        <img src="misc/binWhite.svg" alt="Изтрий" width="24" height="24">
                    </button>
                </div>
            {/if}
            {if $copyMode == true}
                <div class="d-flex justify-content-center gap-3 pt-2 pb-1">
                    <button class="btn p-0 bg-transparent border-0 icon-btn fill-form-btn"
                        data-id="{$mediaItem.id}"
                        data-title="{$mediaItem.name|escape}"
                        data-type="{$mediaItem.type_name|escape}"
                        data-genre="{$mediaItem.genre_name|escape}"
                        data-year="{$mediaItem.year|escape}"
                        data-duration="{$mediaItem.duration|escape}"
                        data-episodes="{$mediaItem.episodes_count|escape}"
                        data-poster="{$mediaItem.image_path|escape}">
                        <img src="misc/copyPaste.svg" alt="Копирай" width="24" height="24">
                    </button>
                </div>
            {/if}
        </div>
    </div>
</div>
