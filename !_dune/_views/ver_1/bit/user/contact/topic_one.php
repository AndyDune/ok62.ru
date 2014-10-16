<?php if ($this->object) { ?>
<h3 class="ex">Тема:  
<?php echo $this->object['name_type']; ?>
, <?php echo $this->object['name_settlement']; ?>
, улица <?php echo $this->object['name_street']; ?>
<?php if ($this->object['house_number']) 
{ 
    ?>, дом&nbsp;<?php echo $this->object['house_number'];
}   ?>
<?php if ($this->object['building_number']) 
{ 
    ?>, корпус&nbsp;<?php echo $this->object['building_number'];
}   ?>
<?php if ($this->object['room'] and $this->object['type'] == 1) 
{ 
    ?>, квартира&nbsp;<?php echo $this->object['room'];
}  else if ($this->object['room']) { 
    ?>, номер&nbsp;<?php echo $this->object['room'];    
} ?></h3>
<?php } else {
	?><h3>Общение</h3><?php
}
?>


<div id="talk_page"> <?php // Странное: при описаниии  casnvas - контент улетает выше блока ?>
<div class="line" id="line1">	  	
	  
	  <div class="item" id="talk-page-main-part"><div class="sap-content">


<div id="talk-list">

<?php if ($this->count) { ?>
<?php foreach ($this->list as $key => $value)
{
?>
<dl class="one-message<?php 
if ($this->i == $value['user_id']) 
{
    ?> my-message<?php
}
?>">
<dt>
<a href="/user/info/<?php echo $value['user_id'] ?>/"><?php echo $value['name_user'] ?></a>
 (<?php echo substr($value['time'], 0, 16) ?>)

</dt>
<dd><?php echo $value['text'] ?></dd>
</dl>
<?php }?>
<?php } else {?>

<?php }?>


<p id="edge"><?php echo time(); ?></p>
</div>


<?php echo $this->form; ?>

	  </div></div>
	  
	  <div class="item" id="talk-page-add-part"><div class="sap-content">
	  <div id="topic-info-on-talk"> 	  
<?php if ($this->object) {?>
	  <h3 class="ex">Обсуждаемый объект</h3>
	  <?php if ($this->preview) { ?>
      <img src="<?php echo $this->preview;?>" />	  
      <?php	} else { ?>
      <img src="<?php echo $this->view_folder;?>/img/house-100.png" />
      <?php	} ?>

      <?php if ($this->object['space_calculation'])
      {
       ?><dl><dt>расчетная площадь:</dt><dd> <?php echo $this->object['space_calculation'] ?> кв. м.</dd></dl><?php
      }
      else if ($this->object['space_total'])
      {
       ?><dl><dt>площадь:</dt><dd> <?php echo $this->object['space_total'] ?> кв. м.</dd></dl><?php
      } ?>
      
      <?php if ($this->object['type'] == 1 and $this->object['rooms_count'])
      {
       ?><dl><dt>количество комнат:</dt><dd> <?php echo $this->object['rooms_count'] ?></dd></dl><?php
       
      } ?>
      

      <?php if ($this->object['deal'] == 0 or $this->object['deal'] == 2)
      {
       ?><dl><dt>продажа, цена :</dt><dd><?php
       if ($this->object['price'])
       { 
           echo number_format($this->object['price'], 0, ',', ' ');
           ?> руб.<?php
       }
       else 
       {
           ?>договорная<?php
       }
        ?></dd></dl><?php
      }
      ?>
      
      
      <?php if ($this->object['deal'] == 1 or $this->object['deal'] == 2)
      {
       ?><dl><dt>аренда, цена (1месяц)</dt><dd><?php
       if ($this->object['price_rent'])
       { 
           echo number_format($this->object['price_rent'], 0, ',', ' ');
           ?> руб.<?php
       }
       else 
       {
           ?>договорная<?php
       }
        ?></dd></dl><?php
      }
      ?>
      
       <dl><dt>подробная информация:</dt><dd><a href="/catalogue/type/<?php echo $this->object['type'] ?>/object/<?php echo $this->object['id'] ?>/?talk_mode=private">карточка объекта</a></dd></dl>
       
      
      
<?php } ?>
      
	  <h3 class="ex">Собеседник</h3>
      <?php
      if ($this->array_photo)
      {
          ?><a class="thickbox" href="<?php echo $this->array_photo[1] ?>"><img src="<?php
        echo $this->array_photo[2];
        ?>" width="100" height="100" /></a><?php
      }
      else 
      {
        ?><img src="<?php echo $this->view_folder;?>/img/user/avatars/first.gif" width="100" height="100" /><?
      }
      ?>
	  <dl>
	  <dt></dt>
	  <dd><a href="/user/info/<?php echo $this->interlocutor->getUserId(); ?>/"><?php echo $this->interlocutor->getUserName(); ?></a></dd>
	  </dl>
	  
      </div>	  
	  
	  </div></div>
</div>
</div>
