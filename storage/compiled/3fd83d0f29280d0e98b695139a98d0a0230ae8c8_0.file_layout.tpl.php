<?php
/* Smarty version 5.4.5, created on 2025-05-19 10:28:33
  from 'file:common/layout.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.5',
  'unifunc' => 'content_682aebb17c5331_80251699',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3fd83d0f29280d0e98b695139a98d0a0230ae8c8' => 
    array (
      0 => 'common/layout.tpl',
      1 => 1747642759,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_682aebb17c5331_80251699 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views\\common';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, false);
?>
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
        <li><a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/home.php">Начало</a></li>
        <?php if ((true && (true && null !== ($_smarty_tpl->getValue('user')['id'] ?? null)))) {?>
            <li><a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/personal-media.php">Лична колекция</a></li>
            <li><a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/logout.php">Изход (<?php echo ($_smarty_tpl->getValue('user')['username']);?>
)</a></li>
        <?php } else { ?>
            <li><a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/login.php">Вход</a></li>
            <li><a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/register.php">Регистрация</a></li>
        <?php }?>
    </ul>
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
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_1074265817682aebb17c3596_70756534', "content");
?>


<?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-3.6.0.min.js"><?php echo '</script'; ?>
>
<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_879199383682aebb17c4751_12865462', "scripts");
?>


</body>
</html><?php }
/* {block "content"} */
class Block_1074265817682aebb17c3596_70756534 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views\\common';
}
}
/* {/block "content"} */
/* {block "scripts"} */
class Block_879199383682aebb17c4751_12865462 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views\\common';
}
}
/* {/block "scripts"} */
}
