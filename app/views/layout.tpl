<nav>
    <ul>
        <li><a href="http://localhost/CATalog/home.php">Начало</a></li>
        {if $user}
            <li><a href="http://localhost/CATalog/logout.php">Изход ({$user})</a></li>
        {else}
            <li><a href="http://localhost/CATalog/login.php">Вход</a></li>
            <li><a href="http://localhost/CATalog/register.php">Регистрация</a></li>
        {/if}
    </ul>
</nav>

<hr>

{if isset($message)}
    <p>{$message}</p>
{/if}

{* Основно съдържание тук *}
{block name="content"}{/block}