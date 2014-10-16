<div id="ocatalogue">
<?php switch ($this->message) { ?>
<?php case 'overcount': ?>
<p style="etxt-align:center; color:red; font-weight:bold;">Вы превысили число максимально допустимых объявлений</p>
<?php break; ?>
<?php } ?>
<h2>Размещенные</h2>
<p style="text-align:right;"><a class="buttom" href="/adminocatalogue/edit/">Добавить новое</a></p>
<?php
if ($this->count and $this->list)
{
    ?><table id="ocatalogue-lis-text"><?php
    $sections = new Special_Vtor_Organization_Parents_List();
    foreach ($this->list as $value)
    {
        ?><tr><?php
        if ($value['section_id'])
        {
            $sections->setSection($value['section_id']);
            $link = $sections->getLink() . '/';
        }
        else 
            $link = '';
        if ($value['pic'])
        {
            $link_pic = '/ddata/ocatalogue/logo/' . $value['pic'];
        }
        else 
            $link_pic = $this->view_folder .'/img/ocatalogue_text_pic.gif';

            
        ?><td style="width:150px;"><a href="<?php echo $this->url_edit, $value['id'] ?>/"><img width="150" height="150" src="<?php echo $link_pic; ?>" alt="<?php echo $value['name']; ?>" /></a></td><td><?php
        ?><h3><a href="<?php echo $this->url_edit, $value['id'] ?>/"><?php echo $value['name']; ?></a></h3><?php
        if ($value['annotation'])
        {
            ?><p><?php echo substr($value['annotation'], 0, 400);  ?></p><?php
        }
        ?><p class="to-info-page"><a href="<?php echo $this->url_edit, $value['id'] ?>/">редактирование&gt;&gt;</a></p><?php
        ?></td></tr><?php
    }
    ?></table><?php
}
else 
{
    ?><p style="text-align:center; margin: 50px 0 0 0;">Вы не представляете ни одной организации(предприятия)</p><?php
}


if ($this->count > $this->per_page)
{
?><hr /><?php
$navigator = new Dune_Navigate_Page($this->url . '?page=', $this->count, $this->page, $this->per_page);
echo $navigator->getNavigator();
}

?>
</div>