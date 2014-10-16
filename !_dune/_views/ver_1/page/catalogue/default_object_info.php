<?php
//////////////////////////////
// catalogue/base.css
// catalogue/info.css
//
?>
<div id="content">
<?php echo $this->type; ?>

<div id="canvas_object_info"> <?php // Странное: при описаниии  casnvas - контент улетает выше блока ?>
<div class="line" id="line1">	  	
	  <div class="item" id="catalogue-left"><div class="sap-content">
	  <?php echo $this->adress_main; ?>
	  </div></div>
	  
	  <div class="item" id="catalogue-main"><div class="sap-content">
	       <div id="crumbs"><?php echo $this->crumbs; ?></div>
	       <?php echo $this->main; ?>
	       <?php echo $this->bottom_content; ?>
	  </div></div>
	  
	  <div class="item" id="catalogue-right"><div class="sap-content">
	  	<?php echo $this->info_add; ?>
	  </div></div>
</div>
</div>

</div>