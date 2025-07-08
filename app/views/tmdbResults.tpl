{if isset($media) && $media|@count > 0}
    <p class="text-success">Намерени резултати: {$media|@count}</p>
{else}
    <p class="text-danger">Няма намерени резултати.</p>
{/if}
<div class="container-fluid my-4">
    <div class="row g-3 pb-4" style="margin-bottom: 100px;">


        {if isset($media) && $media|@count > 0}
            {foreach from=$media item=mediaItem}
                {include file="common/movieCard.tpl" mediaItem=$mediaItem editMode=$editMode copyMode=$copyMode}
            {/foreach}
        {/if}

        
    </div>
</div>