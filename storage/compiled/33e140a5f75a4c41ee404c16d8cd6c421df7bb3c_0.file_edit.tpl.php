<?php
/* Smarty version 5.4.5, created on 2025-05-16 10:53:45
  from 'file:edit.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.5',
  'unifunc' => 'content_6826fd1942d207_44454211',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '33e140a5f75a4c41ee404c16d8cd6c421df7bb3c' => 
    array (
      0 => 'edit.tpl',
      1 => 1747385622,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6826fd1942d207_44454211 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_13837781526826fd193fe7b6_96729729', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_12229966096826fd1942b372_83260999', "scripts");
?>

<?php $_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "content"} */
class Block_13837781526826fd193fe7b6_96729729 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
?>


<form action="<?php echo $_smarty_tpl->getValue('base_url');?>
/edit.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="media_id" value="<?php echo $_smarty_tpl->getValue('media')['id'];?>
">

    <?php if ($_smarty_tpl->getValue('media')['image_path']) {?>
        <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/<?php echo $_smarty_tpl->getValue('media')['image_path'];?>
"  id="preview-image" alt="Постер" style="width: 200px; height: auto; margin-bottom: 10px;"><br>
    <?php } else { ?>
        <img src="<?php echo $_smarty_tpl->getValue('base_url');?>
/misc/question.jpg"  id="preview-image" alt="Без снимка" style="width: 200px; height: auto;"><br>
    <?php }?>

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
" <?php if ($_smarty_tpl->getValue('type')['id'] == $_smarty_tpl->getValue('media')['type_id']) {?>selected<?php }?>><?php echo $_smarty_tpl->getValue('type')['name'];?>
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
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('genre')->value) {
$foreach1DoElse = false;
?>
            <option value="<?php echo $_smarty_tpl->getValue('genre')['id'];?>
" <?php if ($_smarty_tpl->getValue('genre')['id'] == $_smarty_tpl->getValue('media')['genre_id']) {?>selected<?php }?>><?php echo $_smarty_tpl->getValue('genre')['name'];?>
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
    <input type="text" name="name" id="name" value="<?php echo $_smarty_tpl->getValue('media')['name'];?>
" required><br><br>

    <label>Снимка:</label>
    <input type="file" name="image" id="image" accept="image/*"><br><br>

    <input type="hidden" name="poster_url" id="poster_url">

    <label>Година:</label>
    <input type="number" name="year" id="year" min="1800" max="2100" value="<?php echo $_smarty_tpl->getValue('media')['year'];?>
"><br><br>

    <div id="episodes-wrapper" <?php if ($_smarty_tpl->getValue('media')['type_id'] == 2) {?>style="display: block;"<?php } else { ?>style="display: none;"<?php }?>>
        <label for="episodes_count">Брой епизоди:</label>
        <input type="number" name="episodes_count" id="episodes_count" min="1" value="<?php echo $_smarty_tpl->getValue('media')['episodes_count'];?>
"><br><br>
    </div>

    <label>Продължителност (в минути):</label>
    <input type="number" name="duration" id="duration" min="1" value="<?php echo $_smarty_tpl->getValue('media')['duration'];?>
"><br><br>

    <button type="submit">Запази промяната</button>
</form>

<?php
}
}
/* {/block "content"} */
/* {block "scripts"} */
class Block_12229966096826fd1942b372_83260999 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
?>


<?php echo '<script'; ?>
>
    function handleToggleEpisodesInput() {
        $('#type-select').on('change', function () {
            const selected = $(this).find("option:selected").text().toLowerCase();

            if (selected === 'сериал') {
                $('#episodes-wrapper').slideDown(150);
            } else {
                $('#episodes-wrapper').slideUp(150);
                $('#episodes_count').val('');
            }
        });
    }

    function handleToggleNewGenreInput() {
        $('#genre-select').on('change', function () {
            const selected = $(this).find("option:selected").text().toLowerCase();

            if (selected === 'друго') {
                $('#custom-genre-wrapper').slideDown(150);
            } else {
                $('#custom-genre-wrapper').slideUp(150);
                $('#custom_genre_name').val('');
            }
        });
    }

    function handleImagePreview() {
        $('#image').on('change', function (event) {
            const fileInput = event.target;
            const preview = document.getElementById('preview-image');

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(fileInput.files[0]);
            }
        });
    }

    $(function () {
        handleToggleEpisodesInput();
        handleToggleNewGenreInput();
        handleImagePreview();

        $('#type-select').trigger('change');
        $('#genre-select').trigger('change');
    });
<?php echo '</script'; ?>
>

<?php
}
}
/* {/block "scripts"} */
}
