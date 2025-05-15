<?php
/* Smarty version 5.4.5, created on 2025-05-15 09:41:34
  from 'file:personal_media.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.5',
  'unifunc' => 'content_68259aae1deb40_15806415',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c36e4dfa42c1e28d4e6b7512e211a6117fd69983' => 
    array (
      0 => 'personal_media.tpl',
      1 => 1747294891,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:upload.tpl' => 1,
  ),
))) {
function content_68259aae1deb40_15806415 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_94007700468259aae1a62f7_55612368', "content");
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_48085758168259aae1db212_98477050', "scripts");
$_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "content"} */
class Block_94007700468259aae1a62f7_55612368 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
?>



<h2>Лична колекция</h2>

<button id="toggle-add-form">+ Добави филм/сериал</button>

<div id="add-form-wrapper" style="display: none;">
    <?php $_smarty_tpl->renderSubTemplate("file:upload.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

    <p><strong>Попълни чрез търсачка</strong></p>

    <form id="tmdb-search-form" style="margin-bottom: 10px;">
        <input type="text" id="tmdb-query" placeholder="Търси заглавие..." required>
        <button type="submit">Търси</button>
    </form>

    <div id="search-results"></div>
</div>

<?php if ((true && ($_smarty_tpl->hasVariable('media') && null !== ($_smarty_tpl->getValue('media') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('media')) > 0) {?>      <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('media'), 'mediaItem');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('mediaItem')->value) {
$foreach0DoElse = false;
?>
        <div style="margin-bottom: 30px;">
            <?php if ($_smarty_tpl->getValue('mediaItem')['image_path']) {?>
                <img src="<?php echo $_smarty_tpl->getValue('mediaItem')['image_path'];?>
" alt="Постер" style="width: 200px; height: auto;">
            <?php } else { ?>
                <img src="misc/question.jpg" alt="Без снимка" style="width: 200px; height: auto;">
            <?php }?>
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
            <p>Година: <?php echo $_smarty_tpl->getValue('mediaItem')['year'] != '' ? $_smarty_tpl->getValue('mediaItem')['year'] : '-';?>
</p>
            <?php if ($_smarty_tpl->getValue('mediaItem')['type_name'] == "Сериал") {?>
                <p>Брой епизоди: <?php echo $_smarty_tpl->getValue('mediaItem')['episodes_count'] != '' ? $_smarty_tpl->getValue('mediaItem')['episodes_count'] : '-';?>
</p>
            <?php }?>
            <p>Продължителност: <?php echo $_smarty_tpl->getValue('mediaItem')['duration'] != '' ? $_smarty_tpl->getValue('mediaItem')['duration'] : '-';?>
</p>

            
        <hr>
        </div>
    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);
} else { ?>
    <p>Няма добавени филми/сериали.</p>
<?php }?>



<?php
}
}
/* {/block "content"} */
/* {block "scripts"} */
class Block_48085758168259aae1db212_98477050 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
?>


<?php echo '<script'; ?>
>
    function handleToggleUploadForm() {

        $('#toggle-add-form').on('click', function () {
        const wrapper = $('#add-form-wrapper');
        const isVisible = wrapper.is(':visible');

        wrapper.slideToggle(200);
        $(this).text(isVisible ? '+ Добави филм/сериал' : '- Добави филм/сериал');
        });
    }

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

    function handleTMDbQueryAjax() {

        $('#tmdb-search-form').on('submit', function (e) {
            e.preventDefault();
            const query = $('#tmdb-query').val();

            $.get('<?php echo $_smarty_tpl->getValue('base_url');?>
/searchAjax', { query }, function (data) {
                $('#search-results').html(data);
            });
        });
    }

    function handleFillUploadFormFromQuery() {
        $('#search-results').on('click', '.fill-form-btn', function () {
            const btn = $(this);

            $('#name').val(btn.data('title'));
            $('#year').val(btn.data('year'));
            $('#duration').val(btn.data('duration'));
            $('#type-select option').each(function () {
                if ($(this).text().trim().toLowerCase() === btn.data('type').toLowerCase()) {
                    $('#type-select').val($(this).val()).trigger('change');
                }
            });

            const genreText = btn.data('genre').trim();
            let matched = false;

            $('#genre-select option').each(function () {
                if ($(this).text().trim().toLowerCase() === genreText.toLowerCase()) {
                    $('#genre-select').val($(this).val()).trigger('change');
                    matched = true;
                }
            });

            if (!matched) {
                $('#genre-select').val('other').trigger('change');
                $('#custom_genre_name').val(genreText);
            }

            if (btn.data('type') === 'сериал') { // или 'Сериал', ако подаваш текст
                $('#episodes-container').html(`
                    <label for="episodes_count">Брой епизоди:</label>
                    <input type="number" name="episodes_count" id="episodes_count" class="form-control" min="1">
                `);
                $('#episodes_count').val(btn.data('episodes'));
            } else {
                $('#episodes-container').empty();
            }
        });
    }

    function handleDeleteMedia() {
        $(document).on('click', '.delete-media', function () {
            const btn = $(this);
            const mediaId = btn.data('id');

            if (!confirm('Сигурни ли сте, че искате да изтриете този филм/сериал?')) return;

            $.ajax({
                type: 'POST',
                url: '<?php echo $_smarty_tpl->getValue('base_url');?>
/delete.php',
                data: { mediaId: mediaId },
                success: function () {
                    btn.closest('div').slideUp(300, function () {
                        $(this).remove();
                    });
                },
                error: function () {
                    alert('Възникна грешка при изтриване.');
                }
            });
        });
    }

    $(function () {

        handleToggleUploadForm();

        handleToggleEpisodesInput();

        handleToggleNewGenreInput();

        handleTMDbQueryAjax();
    
        handleFillUploadFormFromQuery();
    
        handleDeleteMedia();

    });
<?php echo '</script'; ?>
>




<?php
}
}
/* {/block "scripts"} */
}
