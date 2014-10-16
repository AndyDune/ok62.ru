<h2>Объекты. Главная страница.</h2>
<?php
if ($this->list)
{
    $sections = new Special_Vtor_Organization_Parents_List();
    foreach ($this->list as $value)
    {
        if ($value['section_id'])
        {
            $sections->setSection($value['section_id']);
            $link = $sections->getLink() . '/';
        }
        else 
            $link = '';
        ?><div class="one-text-on-main"><a href="<?php echo $this->url, $link, $value['name_code'] ?>.html"><?php echo $value['name']; ?></a></div><?php
    }
}
?>
