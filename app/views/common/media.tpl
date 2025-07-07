<div class="container-fluid my-4">
    <div class="row g-3">
        {if isset($media) && $media|@count > 0}
            {foreach from=$media item=mediaItem}
                {include file="common/movieCard.tpl" mediaItem=$mediaItem editMode=$editMode}
            {/foreach}
        {else}
            <p>Няма добавени филми/сериали.</p>
        {/if}
    </div>
</div>
