<?php
/* Smarty version 5.4.5, created on 2025-05-05 10:29:50
  from 'file:home.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.5',
  'unifunc' => 'content_681876fe4c50c8_57246165',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '84727bc302e2d9060681f782ba87aa3b0a16853f' => 
    array (
      0 => 'home.tpl',
      1 => 1746433759,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_681876fe4c50c8_57246165 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_1956561883681876fe496638_58588975', "content");
?>

<?php $_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "layout.tpl", $_smarty_current_dir);
}
/* {block "content"} */
class Block_1956561883681876fe496638_58588975 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
?>

    <?php if ($_smarty_tpl->getValue('user')) {?>
        <h1>Здравей, <?php echo $_smarty_tpl->getValue('user');?>
!</h1>
    <?php } else { ?>
        <h1>Моля, логни се.</h1>
    <?php }
}
}
/* {/block "content"} */
}
