<?php
/* Smarty version 5.4.5, created on 2025-05-14 07:04:22
  from 'file:login.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.5',
  'unifunc' => 'content_68242456bfe4d4_58429690',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'da0d20a4627c017653c2408a309316891cd0d0d4' => 
    array (
      0 => 'login.tpl',
      1 => 1747049113,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_68242456bfe4d4_58429690 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_148287911068242456b56c16_87270205', "content");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "content"} */
class Block_148287911068242456b56c16_87270205 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
?>

    <form method="post">
        <input type="text"
            name="username"
            placeholder="Потребителско име"
            value="<?php echo (($tmp = $_smarty_tpl->getValue('old_username') ?? null)===null||$tmp==='' ? '' ?? null : $tmp);?>
"
            required>

        <input type="password"
            name="password"
            placeholder="Парола"
            required>

        <button type="submit">Вход</button>
    </form>
<?php
}
}
/* {/block "content"} */
}
