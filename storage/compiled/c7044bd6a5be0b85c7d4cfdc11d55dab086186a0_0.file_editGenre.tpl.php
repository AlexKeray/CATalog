<?php
/* Smarty version 5.4.5, created on 2025-05-19 10:51:13
  from 'file:editGenre.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.5',
  'unifunc' => 'content_682af101c32d75_34539339',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c7044bd6a5be0b85c7d4cfdc11d55dab086186a0' => 
    array (
      0 => 'editGenre.tpl',
      1 => 1747644670,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_682af101c32d75_34539339 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
?>
<form id="genre-form">
    <label for="genre-select-main">Жанр:</label>
    <select id="genre-select-main" name="genre">
        <option value="">Избери жанр</option>
        <option value="new">Създай нов жанр</option>
        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('genres'), 'genre');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('genre')->value) {
$foreach0DoElse = false;
?>
            <option value="<?php echo $_smarty_tpl->getValue('genre')['id'];?>
" data-name="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('genre')['name'], ENT_QUOTES, 'UTF-8', true);?>
" data-description="<?php echo htmlspecialchars((string)(($tmp = $_smarty_tpl->getValue('genre')['description'] ?? null)===null||$tmp==='' ? '' ?? null : $tmp), ENT_QUOTES, 'UTF-8', true);?>
"><?php echo $_smarty_tpl->getValue('genre')['name'];?>
</option>
        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
    </select>

    <div id="new-genre-fields" style="display: none; margin-top: 10px;">
        <label for="genre_name">Име:</label>
        <input type="text" name="genre_name" placeholder="Име на жанра">
        <label for="genre_description">Описание:</label>
        <textarea name="genre_description" placeholder="Описание"></textarea>
    </div>

    <div id="genre-buttons" style="margin-top: 10px;">
        <button type="button" id="create-genre-btn" style="display: none;">Създай</button>
        <button type="button" id="edit-genre-btn" style="display: none;">Редактирай</button>
        <button type="button" id="delete-genre-btn" style="display: none;">Изтрий</button>
    </div>
</form>
<?php }
}
