<?php
/**
*   Ğîäèòåëüñêèé àáñòğàêòíûé êëàññ äëÿ ğÿäà êëàññîâ ğàáîòû ñ ìàññèâîì $_GET[]
*	Êëàññ äëÿ èíèöèèëèçàöèè è ôèëüòğîâàíèÿ óïğàâëÿşùèõ âõîäíûõ ïàğàìåòğîâ
* 
* ---------------------------------------------------------
* | Áèáëèîòåêà: Dune                                       |
* | Ôàéë: RequestFormatGet.php                             |
* | Â áèáëèîòåêå: Dune/Filter/Parent/RequestFormatGet.php  |
* | Àâòîğ: Àíäğåé Ğûæîâ (Dune) <dune@pochta.ru>            |
* | Âåğñèÿ: 1.01                                           |
* | Ñàéò: www.rznlf.ru                                     |
* ---------------------------------------------------------
* 
*
* Âåğñèÿ 1.00 -> 1.01
* ----------------------
*  Óñòğàíåíà îøèáêà. ×èñëîâûå äàííûå = 0 èíòåğïğåòèğîâàëèñü êàê îòñóòñòâèå äàííûõ
* 
*/

abstract class Dune_Filter_Parent_RequestFormatGet
{

    protected $value;
    protected $have = false;
    
    /**
     * Õğàíèò çíà÷åíèå ïî óìîë÷àíèş
     *
     * @var mixed
     */
    protected $defaultValue;
    
    protected function __construct($name, $def = '')
    {
    	$this->defaultValue = $def;
    	
      	if (empty($_GET[$name]))
      	{
       		$this->value = $this->defaultValue;
      	}
       	else 
       	{
            $this->makeFilter(trim($_GET[$name]));
            if ($this->value !== '')
            {
                $this->have = true;
            }
            else 
                $this->value = $this->defaultValue;
       	}
    }
    
    // Ïğîâåğêà íà ñîîòâåòñòâèå êëş÷à ôèëüòğà ïğåäóñòàíîâëåííûì
    protected function makeFilter($value)
    {
        $this->value = $value;
    }
    
    public function get()
    {
    	return $this->value;
    }
    
    public function have()
    {
    	return $this->have;
    }

}