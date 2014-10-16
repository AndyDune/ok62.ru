<div id="ocatalogue-sections">
<h2>Разделы</h2>
<?php

foreach ($this->sections as $value)
{ 
    if (!$value['count_text'])
        continue;
        if ($value['pic'])
        {
            $link_pic = '/ddata/ocatalogue/section/' . $value['pic'];
        }
        else 
            $link_pic = $this->view_folder .'/img/ocatalogue_section_pic.gif';
    
    ?><div class="one-sections"><a href="<?php echo $this->url, $value['name_code'] ?>/"><table><tr><td style="width:50px;"><img src="<?php echo $link_pic; ?>" alt="<?php echo $value['name']; ?>" /></td><td><?php echo $value['name']; ?> (<?php echo $value['count_text']; ?>)</td></tr></table></a></div><?php
}
?></div>