<?php
if (is_array($this->data))
{

ob_start();
?>
<div id="more_edit_menu">        
<div>

<ul id="ul-hipotec-left-menu">
<?php foreach ($this->data as $value) { ?>
    <li<?php
       if (($value['code'] == $this->op) or (($this->op == 'Main') and (!$value['code'])))
       {
           ?> class="active-level-1"<?php
       }
       if ($value['code'])
           $value['code'] = '&op=' . $value['code'];
    ?>><a href="<?php echo $this->url;?><?php echo $value['code'];?>"><?php echo $value['name']?></a>
    
    </li>
<?php } ?>
</ul>
</div>
<div class="ugol-left-top"></div>
<div class="ugol-left-bottom"></div>
<div class="ugol-right-top"></div>
<div class="ugol-right-bottom"></div>
</div>


<?php
$text = ob_get_clean();
}
else 			
    $text = '';
$this->results['text'] = $text;
