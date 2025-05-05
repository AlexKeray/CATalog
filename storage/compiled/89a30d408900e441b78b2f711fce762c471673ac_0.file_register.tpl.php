<?php
/* Smarty version 5.4.5, created on 2025-05-05 10:49:08
  from 'file:register.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.5',
  'unifunc' => 'content_68187b84726995_78900099',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '89a30d408900e441b78b2f711fce762c471673ac' => 
    array (
      0 => 'register.tpl',
      1 => 1746433749,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_68187b84726995_78900099 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_117320779568187b8471ec43_83219379', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "layout.tpl", $_smarty_current_dir);
}
/* {block "content"} */
class Block_117320779568187b8471ec43_83219379 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
?>

    <form method="post">
        <input type="text" name="username" placeholder="Потребителско име" required>
        <input type="password" name="password" placeholder="Парола" required>
        <button type="submit">Регистрация</button>
    </form>
<?php
}
}
/* {/block "content"} */
}
