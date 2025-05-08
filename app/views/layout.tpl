<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <title>CATalog</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <nav>
    <ul>
        <li><a href="http://localhost/CATalog/home.php">Начало</a></li>
        {if $user}
            <li><a href="http://localhost/CATalog/upload.php">Добави филм</a></li>
            <li><a href="http://localhost/CATalog/logout.php">Изход ({$user})</a></li>
        {else}
            <li><a href="http://localhost/CATalog/login.php">Вход</a></li>
            <li><a href="http://localhost/CATalog/register.php">Регистрация</a></li>
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

{* Основно съдържание тук *}
{block name="content"}{/block}

</body>
</html>