<?php
//////////////////////////////
// catalogue/base.css
// catalogue/info.css
//
?>
<div id="content">
<?php echo $this->type; ?>

<div id="canvas"> <?php // Странное: при описаниии  casnvas - контент улетает выше блока ?>
<div class="line" id="line1">	  	
	  <div class="item" id="catalogue-left"><div class="sap-content">
	  <?php echo $this->adress_main; ?>
	  </div></div>
	  
	  <div class="item" id="catalogue-main-all"><div class="sap-content">
	  
	  <?php echo $this->elected; ?>
	       <?php if ($this->h1_text)
	       {
	           ?><h1><?php echo $this->h1_text ?></h1><?php
	       } ?>
	       <div id="crumbs"><?php echo $this->crumbs; ?></div>
	       <?php echo $this->main; ?>
	       <?php echo $this->bottom_content; ?>
	  </div></div>
	  
</div>
</div>

</div>