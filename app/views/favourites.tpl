{extends file="common/layout.tpl"}

{block name="content"}

<h2 class="text-center text-white my-4">Добави филм или сериал</h2>

<div id="add-form-wrapper">
    {include file="common/upload.tpl"}
    {include file="common/searchTmdb.tpl"}
</div>

{/block}

{block name="scripts"}
{/block}