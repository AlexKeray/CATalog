<!DOCTYPE html>
<html lang="bg">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <meta charset="UTF-8">
    <title>CATalog</title>

    {* 
        Bootstrap CSS
        Взима се от външен сървър а не локално.
    *}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    {* Bootstrap Icons *}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body>

    <nav id="mainNav" class="navbar navbar-expand-md sticky-top py-3 navbar-dark bg-dark">
        <div class="container">
            {* Тук ще е навигационната лента. Тя ще е вляво от логото. *}
            <div class="collapse navbar-collapse multi-collapse" id="menu1">
                {* Занимава се с nav-link-овете *}
                <ul class="navbar-nav mе-auto d-flex">
                    <li class="nav-item px-3">
                        <a class="nav-link" href="{$base_url}/home.php">Начало</a>
                    </li>
                    {if isset($user.id)}
                        <li class="nav-item px-3">
                            <a class="nav-link" href="{$base_url}/personal-media.php">Лична колекция</a>
                        </li>
                    {/if}
                </ul>
            </div>

            
            {* Тук ще е логото, което трябва да е снимка а не надпис *}
            <a class="navbar-brand text-white" href="#">CATalog</a>

            {* Хамбургер меню бутона*}
            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target=".multi-collapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            {*
                Тук ще са бутоните за логин и регистрация 
                или името на потребителя и изход 
            *}
            <div class="collapse navbar-collapse multi-collapse d-flex" id="menu2">
                {if isset($user.id)}
                    <div class="d-flex ms-auto align-items-center">
                        <ul class="navbar-nav d-flex mb-0">
                            <li class="nav-item px-3">
                                <a class="nav-link" href="#">Welcome {($user.username)}</a>
                            </li>
                        </ul>
                        <a class="btn btn-primary shadow ms-2" role="button" href="{$base_url}/logout.php">Изход</a>
                    </div>
                {else}
                    <div class="d-flex ms-auto align-items-center">
                        <a class="btn btn-primary shadow ms-2" role="button" href="{$base_url}/register.php">Регистрация</a>
                        <a class="btn btn-primary shadow ms-2" role="button" href="{$base_url}/login.php">Вход</a>
                    </div>
                {/if}
            </div>
        </div>
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