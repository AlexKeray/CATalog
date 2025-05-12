<?php
/* Smarty version 5.4.5, created on 2025-05-12 10:58:47
  from 'file:upload.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.5',
  'unifunc' => 'content_6821b847b4d6d8_48280285',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '56cb6511cd9132700e9fecf3e17fa2dac771171f' => 
    array (
      0 => 'upload.tpl',
      1 => 1747040324,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6821b847b4d6d8_48280285 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_699679196821b847b38640_96072049', "content");
?>

<?php $_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "layout.tpl", $_smarty_current_dir);
}
/* {block "content"} */
class Block_699679196821b847b38640_96072049 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
?>

<h2>Добави Филм/Сериал</h2>

<form action="/CATalog/upload.php" method="post" enctype="multipart/form-data">
    <label>Тип:</label>
    <select name="type" required>
        <option value="">Избери тип</option>
        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('types'), 'type');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('type')->value) {
$foreach0DoElse = false;
?>
            <option value="<?php echo $_smarty_tpl->getValue('type')['id'];?>
"><?php echo $_smarty_tpl->getValue('type')['name'];?>
</option>
        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
    </select><br><br>
    <label>Жанр:</label>
    <select name="genre" required>
        <option value="">Избери жанр</option>
        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('genres'), 'genre');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('genre')->value) {
$foreach1DoElse = false;
?>
            <option value="<?php echo $_smarty_tpl->getValue('genre')['id'];?>
"><?php echo $_smarty_tpl->getValue('genre')['name'];?>
</option>
        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
    </select><br><br>

    <label>Име:</label>
    <input type="text" name="name" ><br><br>

    <label>Снимка:</label>
    <input type="file" name="image" accept="image/*"><br><br> 
    <label>Година:</label>
    <input type="number" name="year" min="1800" max="2100" required><br><br>

    <label>Продължителност (в минути):</label>
    <input type="number" name="duration" min="1" required><br><br>

    <button type="submit">Качи</button>
</form>

<?php
}
}
/* {/block "content"} */
}
