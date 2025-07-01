<?php
/* Smarty version 5.4.5, created on 2025-05-20 08:48:55
  from 'file:home.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.5',
  'unifunc' => 'content_682c25d77f3ec6_81061545',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '84727bc302e2d9060681f782ba87aa3b0a16853f' => 
    array (
      0 => 'home.tpl',
      1 => 1747723733,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_682c25d77f3ec6_81061545 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_1705307709682c25d77cfac7_38598561', "content");
?>

<?php $_smarty_tpl->getInheritance()->endChild($_smarty_tpl, "common/layout.tpl", $_smarty_current_dir);
}
/* {block "content"} */
class Block_1705307709682c25d77cfac7_38598561 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\CATalog\\app\\views';
?>


    
    <?php if ((true && (true && null !== ($_smarty_tpl->getValue('user')['id'] ?? null)))) {?>
        <h1>Здравей, <?php echo $_smarty_tpl->getValue('user')['username'];?>
!</h1>
    <?php } else { ?>
        <h1>Здравей!</h1>
    <?php }?>

        <h2>Списък с филми и сериали</h2>

        <?php if ((true && ($_smarty_tpl->hasVariable('media') && null !== ($_smarty_tpl->getValue('media') ?? null))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('media')) > 0) {?>              <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('media'), 'mediaItem');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('mediaItem')->value) {
$foreach0DoElse = false;
?>
                <hr>
                <div style="margin-bottom: 30px;">
                    <?php if ($_smarty_tpl->getValue('mediaItem')['image_path']) {?>
                        <img src="<?php echo $_smarty_tpl->getValue('mediaItem')['image_path'];?>
" alt="Постер" style="width: 200px; height: auto;">
                    <?php } else { ?>
                        <img src="misc/question.jpg" alt="Без снимка" style="width: 200px; height: auto;">
                    <?php }?>
                    <h3><?php echo $_smarty_tpl->getValue('mediaItem')['name'];?>
</h3>
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
}
