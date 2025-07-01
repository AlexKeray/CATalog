<?php
/* Smarty version 5.4.5, created on 2025-07-01 20:58:30
  from 'file:common/layout.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.5',
  'unifunc' => 'content_68642fd6e119f3_18142788',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3fd83d0f29280d0e98b695139a98d0a0230ae8c8' => 
    array (
      0 => 'common/layout.tpl',
      1 => 1751396306,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_68642fd6e119f3_18142788 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views\\common';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, false);
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <meta charset="UTF-8">
    <title>CATalog</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body>

    <nav id="mainNav" class="navbar navbar-expand-md sticky-top py-3 navbar-dark bg-dark">
        <div class="container">
                        <div class="collapse navbar-collapse multi-collapse" id="menu1">
                                <ul class="navbar-nav mе-auto d-flex">
                    <li class="nav-item px-3">
                        <a class="nav-link" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/home.php">Начало</a>
                    </li>
                    <?php if ((true && (true && null !== ($_smarty_tpl->getValue('user')['id'] ?? null)))) {?>
                        <li class="nav-item px-3">
                            <a class="nav-link" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/personal-media.php">Лична колекция</a>
                        </li>
                    <?php }?>
                </ul>
            </div>

            
                        <a class="navbar-brand text-white" href="#">CATalog</a>

                        <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target=".multi-collapse">
                <span class="navbar-toggler-icon"></span>
            </button>

                        <div class="collapse navbar-collapse multi-collapse d-flex" id="menu2">
                <?php if ((true && (true && null !== ($_smarty_tpl->getValue('user')['id'] ?? null)))) {?>
                    <div class="d-flex ms-auto align-items-center">
                        <ul class="navbar-nav d-flex mb-0">
                            <li class="nav-item px-3">
                                <a class="nav-link" href="#">Welcome <?php echo ($_smarty_tpl->getValue('user')['username']);?>
</a>
                            </li>
                        </ul>
                        <a class="btn btn-primary shadow ms-2" role="button" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/logout.php">Изход</a>
                    </div>
                <?php } else { ?>
                    <div class="d-flex ms-auto align-items-center">
                        <a class="btn btn-primary shadow ms-2" role="button" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/register.php">Регистрация</a>
                        <a class="btn btn-primary shadow ms-2" role="button" href="<?php echo $_smarty_tpl->getValue('base_url');?>
/login.php">Вход</a>
                    </div>
                <?php }?>
            </div>
        </div>
    </nav>

<hr>

<?php if ((true && ($_smarty_tpl->hasVariable('message') && null !== ($_smarty_tpl->getValue('message') ?? null)))) {?>
    <div class="alert alert-success" role="alert">
        <?php echo $_smarty_tpl->getValue('message');?>

    </div>
<?php }?>

<?php if ((true && ($_smarty_tpl->hasVariable('success') && null !== ($_smarty_tpl->getValue('success') ?? null)))) {?>
    <div class="alert alert-success" role="alert">
        <?php echo $_smarty_tpl->getValue('success');?>

    </div>
<?php }?>

<?php if ((true && ($_smarty_tpl->hasVariable('warning') && null !== ($_smarty_tpl->getValue('warning') ?? null)))) {?>
    <div class="alert alert-warning" role="alert">
        <?php echo $_smarty_tpl->getValue('warning');?>

    </div>
<?php }?>

<?php if ((true && ($_smarty_tpl->hasVariable('error') && null !== ($_smarty_tpl->getValue('error') ?? null)))) {?>
    <div class="alert alert-danger" role="alert">
        <?php echo $_smarty_tpl->getValue('error');?>

    </div>
<?php }?>

<div id="genre-alert-placeholder"></div>

<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_189654566168642fd6e036d7_11360622', "content");
?>


<?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-3.6.0.min.js"><?php echo '</script'; ?>
>
<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_12420041368642fd6e10b31_32492302', "scripts");
?>


</body>
</html><?php }
/* {block "content"} */
class Block_189654566168642fd6e036d7_11360622 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views\\common';
}
}
/* {/block "content"} */
/* {block "scripts"} */
class Block_12420041368642fd6e10b31_32492302 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views\\common';
}
}
/* {/block "scripts"} */
}
