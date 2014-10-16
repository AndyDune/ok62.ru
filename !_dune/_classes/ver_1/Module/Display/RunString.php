<?php

class Module_Display_RunString extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        


Dune_Static_JavaScriptsList::add('jquery.li-scroller');
Dune_Static_JavaScriptsList::add('jquery.corner', 100);
//Dune_Static_JavaScriptsList::add('jquery.curvycorners.packed');

Dune_Static_JavaScriptsList::add('dune.base', 501);


$q = 'SELECT * FROM `unity_message_dinamic` WHERE `type` = 1 ORDER BY `order`';
$DB = Dune_MysqliSystem::getInstance();
$result = $DB->query($q, null, Dune_MysqliSystem::RESULT_IASSOC);
if (count($result)) {
?>
<div id="dinamic-messages">
<ul class="no-script" id="li-scroll"> 
<?php

/*
    <li><span class="background"><span>19/02/2007</span> Отличный выбор <a href="#">Квартира в Рязани</a>
    <div class="ugol-left-top" ></div><div class="ugol-right-bottom" ></div><div class="ugol-left-bottom" ></div> <div class="ugol-right-top" ></div>
    </span></li> 
    <li><span class="background"><span>19/02/2007</span> Выбор так себе но дешево <a href="#">Кваритра в Рязани</a>
    <div class="ugol-left-top" ></div><div class="ugol-right-bottom" ></div><div class="ugol-left-bottom" ></div> <div class="ugol-right-top" ></div>
    </span></li> 
    <li><span class="background"><span>19/02/2007</span><a href="#">Зайди ка</a>
    <div class="ugol-left-top" ></div><div class="ugol-right-bottom" ></div><div class="ugol-left-bottom" ></div> <div class="ugol-right-top" ></div>
    </span></li> 
*/
$x = 0;
foreach ($result as $value)
{
    if ($x)
    {
?> <li>
    <span class="background">
<img src="<?php echo $this->view_path; ?>/img/pics/logo.png" />    
    </span></li><?php
        
    }
?> <li>
    <span class="background">
    <?php echo $value['text'] ?>
    </span></li><?php
    $x++;
}   
?>    
</ul>
</div>
<?php
}




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    