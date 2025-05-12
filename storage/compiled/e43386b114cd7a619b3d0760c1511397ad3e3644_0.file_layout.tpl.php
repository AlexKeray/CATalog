<?php
/* Smarty version 5.4.5, created on 2025-05-12 10:31:11
  from 'file:layout.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.5',
  'unifunc' => 'content_6821b1cf2ba208_50072885',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e43386b114cd7a619b3d0760c1511397ad3e3644' => 
    array (
      0 => 'layout.tpl',
      1 => 1747038669,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6821b1cf2ba208_50072885 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, false);
?>
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
        <?php if ((true && (true && null !== ($_smarty_tpl->getValue('user')['id'] ?? null)))) {?>
            <li><a href="http://localhost/CATalog/upload.php">Добави филм</a></li>
            <li><a href="http://localhost/CATalog/logout.php">Изход (<?php echo ($_smarty_tpl->getValue('user')['username']);?>
)</a></li>
        <?php } else { ?>
            <li><a href="http://localhost/CATalog/login.php">Вход</a></li>
            <li><a href="http://localhost/CATalog/register.php">Регистрация</a></li>
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

<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_2589370536821b1cf2b0950_55299383', "content");
?>


</body>
</html><?php }
/* {block "content"} */
class Block_2589370536821b1cf2b0950_55299383 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
}
}
/* {/block "content"} */
}
