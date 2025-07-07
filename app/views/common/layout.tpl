<!DOCTYPE html>
<html lang="bg">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
        <meta charset="UTF-8">
        <title>CATalog</title>

        <!-- Bootstrap CSS и икони -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

        <style>
            .debug-border {
                border: 0px dashed deeppink !important;
            }
        </style>

    </head>

    <style>
    .bg-darker {
        background-color: #121212 !important; /* по-тъмен от bg-dark */
    }
    </style>

    <body class="bg-dark">
        <nav class="navbar navbar-expand-md sticky-top py-3 navbar-dark bg-darker">
            <div class="container-fluid debug-border">
                <div class="row align-items-center w-100 gx-0 debug-border">

                    <!-- Лява част (md и нагоре) -->
                    <div class="col-md-4 d-none d-md-block debug-border">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link {if $pageName == 'home'}active{/if}" href="{$base_url}/home.php">Начало</a>
                            </li>
                            {if isset($user.id)}
                                <li class="nav-item">
                                    <a class="nav-link {if $pageName == 'personal_media'}active{/if}" href="{$base_url}/personal-media.php">Твоите филми и сериали</a>
                                </li>
                            {/if}
                        </ul>
                    </div>

                    <!-- Празна колона, само за малки екрани -->
                    <div class="col-3 d-md-none debug-border"></div>

                    <!-- Център: логото -->
                    <div class="col-6 col-md-4 text-center debug-border">
                        <a class="navbar-brand m-0" href="#">CATalog</a>
                    </div>

                    <!-- Дясна част: Username и Вход+Регистрация/Изход -->
                    <div class="col-md-4 d-none d-md-flex justify-content-end align-items-center gap-2 debug-border">
                        {if isset($user.id)}
                            <p class="text-white me-2 mb-0">{($user.username)}</p>
                            <a class="btn btn-outline-light rounded-pill" href="{$base_url}/logout.php">Изход</a>
                        {else}
                            <a class="btn btn-outline-light rounded-pill" href="{$base_url}/login.php">Вход</a>
                            <a class="btn btn-light text-dark rounded-pill" href="{$base_url}/register.php">Регистрация</a>
                        {/if}
                    </div>

                    <!-- Хамбургер бутон (sm) -->
                    <div class="col-3 d-md-none d-flex justify-content-end align-items-center gap-2 px-2 debug-border">
                        {if isset($user.id)}
                            <p class="text-white me-2 mb-0">{($user.username)}</p>
                        {/if}
                        <button class="navbar-toggler"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#navbarCollapse"
                                aria-controls="navbarCollapse"
                                aria-expanded="false"
                                aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>

                    <!-- Меню за мобилни устройства -->
                    <div class="col-12 d-md-none">
                        <div class="collapse navbar-collapse mt-2" id="navbarCollapse">
                            <div class="d-flex flex-column align-items-center text-center">
                                <ul class="navbar-nav w-100">
                                    <li class="nav-item">
                                        <a class="nav-link text-center {if $pageName == 'home'}active{/if}" href="{$base_url}/home.php">Начало</a>
                                    </li>
                                    {if isset($user.id)}
                                        <li class="nav-item">
                                            <a class="nav-link text-center {if $pageName == 'personal_media'}active{/if}" href="{$base_url}/personal-media.php">Лична колекция</a>
                                        </li>
                                    {/if}
                                </ul>

                                {if isset($user.id)}
                                
                                    <div class="d-flex justify-content-center gap-2 mt-3">
                                        <form method="post" action="{$base_url}/logout.php">
                                            <a class="btn btn-outline-light rounded-pill" href="{$base_url}/logout.php">Изход</a>
                                        </form>
                                    </div>
                                {else}
                                    <div class="d-flex justify-content-center gap-2 mt-3">
                                        <a class="btn btn-outline-light rounded-pill" href="{$base_url}/login.php">Вход</a>
                                        <a class="btn btn-light text-dark rounded-pill" href="{$base_url}/register.php">Регистрация</a>
                                    </div>
                                {/if}
                            </div>
                        </div>
                    </div>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        {block name="scripts"}{/block}

    </body>
</html>
