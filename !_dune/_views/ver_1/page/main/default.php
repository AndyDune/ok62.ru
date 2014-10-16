<?php
//
// main/base.css
//

?>
<div id="content-main">
<div id="mai-page-blocks">

<div id="div-types-count-outer">
<span class="round-top-left"></span>
<span class="round-bottom-left"></span>
<span class="round-bottom-right"></span>
<span class="round-top-right"></span>
<h2>Объектов в системе</h2>
<div id="div-types-count">
<?php foreach ($this->types_list as $value)
{ ?>
<dl><dt>
<a href="/catalogue/type/<?php echo $value['id']; ?>/"><?php echo $value['count']?></a>
</dt><dd><?php echo $value['name']?></dd></dl>
<?php }?>
</div></div>

<div id="div-objects-last-outer">
<h2>Последние объекты в системе</h2>
<div id="div-objects-last">
<?php foreach ($this->objects_list as $value)
{ ?>
<dl><dt>
<img src="<?php echo $this->view_folder?>/img/objects/collection/1.jpg">
</dt><dd><a href="/catalogue/object/<?php echo $value['id']?>/"><strong><?php echo $value['name_type']?></strong><br /> ул. <?php echo $value['name_street']?>, дом. <?php echo $value['house_number']?>, номер <?php echo $value['room']?>  </a></dd></dl>
<?php }?>
</div>
<span class="round-top-left"></span>
<span class="round-bottom-left"></span>
<span class="round-bottom-right"></span>
<span class="round-top-right"></span>
</div>

</div>
</div>
