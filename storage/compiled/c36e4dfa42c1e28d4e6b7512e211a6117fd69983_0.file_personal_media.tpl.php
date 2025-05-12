<?php
/* Smarty version 5.4.5, created on 2025-05-12 16:11:26
  from 'file:personal_media.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.5',
  'unifunc' => 'content_6822018e42b578_65970825',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c36e4dfa42c1e28d4e6b7512e211a6117fd69983' => 
    array (
      0 => 'personal_media.tpl',
      1 => 1747058141,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6822018e42b578_65970825 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_19950198046822018e3d0721_67130656', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_1111336086822018e4297b2_88295222', "scripts");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "content"} */
class Block_19950198046822018e3d0721_67130656 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
?>


<h2>Лична колекция</h2>

<hr>
<a href="<?php echo $_smarty_tpl->getValue('base_url');?>
/upload.php" class="btn btn-success mb-4">
    <i class="bi bi-plus-lg"></i> Добави филм/сериал
</a>
<hr>

    <?php if ((true && ($_smarty_tpl->hasVariable('media') && null !== ($_smarty_tpl->getValue('media') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('media')) > 0) {?>          <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('media'), 'mediaItem');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('mediaItem')->value) {
$foreach0DoElse = false;
?>
            <div style="margin-bottom: 30px;">
                <h3><?php echo $_smarty_tpl->getValue('mediaItem')['name'];?>
</h3>
                <button class="btn btn-danger btn-sm delete-media" data-id="<?php echo $_smarty_tpl->getValue('mediaItem')['id'];?>
">
                    Изтрий
                </button>
                <p>Тип: <?php echo $_smarty_tpl->getValue('mediaItem')['type_name'];?>
</p>
                <p>Жанр: <?php echo $_smarty_tpl->getValue('mediaItem')['genre_name'];?>
</p>
                <p>Година: <?php echo $_smarty_tpl->getValue('mediaItem')['year'];?>
</p>
                <?php if ($_smarty_tpl->getValue('mediaItem')['type_name'] == "Сериал") {?>
                    <p>Брой епизоди: <?php echo $_smarty_tpl->getValue('mediaItem')['episodes_count'];?>
</p>
                <?php }?>
                <p>Продължителност: <?php echo $_smarty_tpl->getValue('mediaItem')['duration'];?>
 минути</p>

                <?php if ($_smarty_tpl->getValue('mediaItem')['image_path']) {?>
                    <img src="<?php echo $_smarty_tpl->getValue('mediaItem')['image_path'];?>
" alt="Постер" style="max-width: 200px;">
                <?php }?>
            <hr>
            </div>
        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
    <?php } else { ?>
        <p>Няма добавени филми/сериали.</p>
    <?php }?>

<?php
}
}
/* {/block "content"} */
/* {block "scripts"} */
class Block_1111336086822018e4297b2_88295222 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
?>

<?php echo '<script'; ?>
>
$(function () {
    $('.delete-media').on('click', function () {
        if (!confirm('Сигурен ли си, че искаш да изтриеш този филм?')) return;

        const button = $(this);
        const mediaId = button.data('id');

        $.ajax({
            url: '<?php echo $_smarty_tpl->getValue('base_url');?>
/delete.php',
            method: 'POST',
            data: { mediaId: mediaId },
            success: function () {
                button.closest('div').fadeOut(); // скрива целия блок с филма
            },
            error: function () {
                alert('Възникна грешка при изтриване.');
            }
        });
    });
});
<?php echo '</script'; ?>
>
<?php
}
}
/* {/block "scripts"} */
}
