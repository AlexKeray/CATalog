<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>CATalog</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body>

    <nav>
    <ul>
        <li><a href="{$base_url}/home.php">Начало</a></li>
        {if isset($user.id)}
            <li><a href="{$base_url}/personal-media.php">Лична колекция</a></li>
            <li><a href="{$base_url}/logout.php">Изход ({($user.username)})</a></li>
        {else}
            <li><a href="{$base_url}/login.php">Вход</a></li>
            <li><a href="{$base_url}/register.php">Регистрация</a></li>
        {/if}
    </ul>
</nav>

<hr>

{if isset($message)}
    <div class="alert alert-success" role="alert">
        {$message}
    </div>
{/if}

{if isset($success)}
    <div class="alert alert-success" role="alert">
        {$success}
    </div>
{/if}

{if isset($warning)}
    <div class="alert alert-warning" role="alert">
        {$warning}
    </div>
{/if}

{if isset($error)}
    <div class="alert alert-danger" role="alert">
        {$error}
    </div>
{/if}

<div id="genre-alert-placeholder"></div>

{* Основно съдържание тук *}
{block name="content"}{/block}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{block name="scripts"}{/block}

</body>
</html>