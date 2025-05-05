{extends file="layout.tpl"}

{block name="content"}
    {if $user}
        <h1>Здравей, {$user}!</h1>
    {else}
        <h1>Моля, логни се.</h1>
    {/if}
{/block}
