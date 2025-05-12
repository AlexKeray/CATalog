<?php
/* Smarty version 5.4.5, created on 2025-05-12 16:57:29
  from 'file:upload.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.5',
  'unifunc' => 'content_68220c595585d7_68552612',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '56cb6511cd9132700e9fecf3e17fa2dac771171f' => 
    array (
      0 => 'upload.tpl',
      1 => 1747061602,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_68220c595585d7_68552612 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_106560964468220c595409f0_34872996', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_212124598568220c595570d8_95042632', "scripts");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "content"} */
class Block_106560964468220c595409f0_34872996 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
?>

<h2>Добави Филм/Сериал</h2>

<form action="<?php echo $_smarty_tpl->getValue('base_url');?>
/upload.php" method="post" enctype="multipart/form-data">
    <label>Тип:</label>
    <select name="type-id" id="type-select" required>
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

    <div id="episodes-container"></div>

    <label>Продължителност (в минути):</label>
    <input type="number" name="duration" min="1" required><br><br>

    <button type="submit">Качи</button>
</form>

<?php
}
}
/* {/block "content"} */
/* {block "scripts"} */
class Block_212124598568220c595570d8_95042632 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
?>

<?php echo '<script'; ?>
>
$(function () {
    $('#type-select').on('change', function () {
        const selected = $(this).val();

        if ($(this).find("option:selected").text() === 'Сериал') {
            $('#episodes-container').html(`
                <label for="episodes_count">Брой епизоди:</label>
                <input type="number" name="episodes_count" id="episodes_count" class="form-control" min="1">
            `);
        } else {
            $('#episodes-container').empty();
        }
    });
});
<?php echo '</script'; ?>
>

<?php
}
}
/* {/block "scripts"} */
}
