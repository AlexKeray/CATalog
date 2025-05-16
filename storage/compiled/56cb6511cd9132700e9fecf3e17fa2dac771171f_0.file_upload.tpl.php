<?php
/* Smarty version 5.4.5, created on 2025-05-15 10:24:48
  from 'file:upload.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.5',
  'unifunc' => 'content_6825a4d0ab93a9_59804375',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '56cb6511cd9132700e9fecf3e17fa2dac771171f' => 
    array (
      0 => 'upload.tpl',
      1 => 1747297198,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6825a4d0ab93a9_59804375 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
?>
<form action="<?php echo $_smarty_tpl->getValue('base_url');?>
/upload.php" method="post" enctype="multipart/form-data">
    <label>Тип:</label>
    <select name="type-id" id="type-select" required>
        <option value="">Избери тип</option>
        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('types'), 'type');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('type')->value) {
$foreach1DoElse = false;
?>
            <option value="<?php echo $_smarty_tpl->getValue('type')['id'];?>
"><?php echo $_smarty_tpl->getValue('type')['name'];?>
</option>
        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
    </select><br><br>
    <label>Жанр:</label>
    <select name="genre" id="genre-select" required>
        <option value="">Избери жанр</option>
        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('genres'), 'genre');
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('genre')->value) {
$foreach2DoElse = false;
?>
            <option value="<?php echo $_smarty_tpl->getValue('genre')['id'];?>
"><?php echo $_smarty_tpl->getValue('genre')['name'];?>
</option>
        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
        <option value="other">Друго</option>
    </select><br><br>

    <div id="custom-genre-wrapper" style="display: none;">
        <label for="custom_genre_name">Нов жанр:</label>
        <input type="text" name="custom_genre_name" id="custom_genre_name"><br><br>
    </div>

    <label>Име:</label>
    <input type="text" name="name" id="name" required><br><br>

    <label>Снимка:</label>
    <input type="file" name="image" id="image" accept="image/*"><br><br> 
    <input type="hidden" name="poster_url" id="poster_url">

    <label>Година:</label>
    <input type="number" name="year" id="year" min="1800" max="2100"><br><br>

    <div id="episodes-wrapper" style="display: none;">
        <label for="episodes_count">Брой епизоди:</label>
        <input type="number" name="episodes_count" id="episodes_count" min="1"><br><br>
    </div>


    <label>Продължителност (в минути):</label>
    <input type="number" name="duration" id="duration" min="1"><br><br>

    <button type="submit">Качи</button>
</form>

<?php }
}
