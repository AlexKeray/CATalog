<?php
/* Smarty version 5.4.5, created on 2025-05-12 09:05:48
  from 'file:register.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.5',
  'unifunc' => 'content_68219dcc17bbb7_85893157',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '89a30d408900e441b78b2f711fce762c471673ac' => 
    array (
      0 => 'register.tpl',
      1 => 1747033302,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_68219dcc17bbb7_85893157 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_136778105068219dcc1720f1_54802757', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "layout.tpl", $_smarty_current_dir);
}
/* {block "content"} */
class Block_136778105068219dcc1720f1_54802757 extends \Smarty\Runtime\Block
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
