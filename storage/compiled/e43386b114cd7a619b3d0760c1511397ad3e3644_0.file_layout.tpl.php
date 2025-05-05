<?php
/* Smarty version 5.4.5, created on 2025-05-05 11:09:08
  from 'file:layout.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.5',
  'unifunc' => 'content_68188034db6e10_78127874',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e43386b114cd7a619b3d0760c1511397ad3e3644' => 
    array (
      0 => 'layout.tpl',
      1 => 1746436141,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_68188034db6e10_78127874 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, false);
?>
<nav>
    <ul>
        <li><a href="http://localhost/CATalog/home.php">Начало</a></li>
        <?php if ($_smarty_tpl->getValue('user')) {?>
            <li><a href="http://localhost/CATalog/logout.php">Изход (<?php echo $_smarty_tpl->getValue('user');?>
)</a></li>
        <?php } else { ?>
            <li><a href="http://localhost/CATalog/login.php">Вход</a></li>
            <li><a href="http://localhost/CATalog/register.php">Регистрация</a></li>
        <?php }?>
    </ul>
</nav>

<hr>

<?php if ((true && ($_smarty_tpl->hasVariable('message') && null !== ($_smarty_tpl->getValue('message') ?? null)))) {?>
    <p><?php echo $_smarty_tpl->getValue('message');?>
</p>
<?php }?>

<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_20992807768188034db0b27_62058650', "content");
}
/* {block "content"} */
class Block_20992807768188034db0b27_62058650 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
}
}
/* {/block "content"} */
}
