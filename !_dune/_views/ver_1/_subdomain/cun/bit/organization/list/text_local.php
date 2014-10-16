<div id="ocatalogue">
<h1>Каталог. <?php echo $this->section_data['name']; ?></h1>
<?php echo $this->section_text; ?>
<h2></h2>
<?php
if ($this->list)
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

            
        ?><td style="width:150px;"><a href="<?php echo $this->url, $link, $value['name_code'] ?>.html"><img width="150" height="150" src="<?php echo $link_pic; ?>" alt="<?php echo $value['name']; ?>" /></a></td><td><?php
        ?><h3><a href="<?php echo $this->url, $link, $value['name_code'] ?>.html"><?php echo $value['name']; ?></a></h3><?php
        if ($value['annotation'])
        {
            ?><p><?php echo substr($value['annotation'], 0, 400);  ?></p><?php
        }
        ?><p class="to-info-page"><a href="<?php echo $this->url, $link, $value['name_code'] ?>.html">подробности &gt;&gt;</a></p><?php
        ?></td></tr><?php
    }
    ?></table><?php
}


if ($this->count > $this->per_page)
{
?><hr /><?php
$navigator = new Dune_Navigate_Page($this->url . '?page=', $this->count, $this->page, $this->per_page);
echo $navigator->getNavigator();
}

?>
</div>