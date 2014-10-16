<?
/**
 * Êëàññ êîíòåéíå äàííûõ. Ñîäåğæèò 3 êîïèè èìåíè ïîëüçîâàòåëÿ.
 * 
 *	Çàùèòà èìåíè ïîëüçîâàòåëÿ îò ïîääåëêè.
 *  Ìåòîäîì çàìåíû ëàòèíñêèõ áóêâ ïîõîæèìè ğóññêèìè è íàîáîğîò.
 * 
 *	 
 * ----------------------------------------------------
 * | Áèáëèîòåêà: Dune                                  |
 * | Ôàéë: UserName.php                                |
 * | Â áèáëèîòåêå: Dune/Data/Container/UserName.ph     |
 * | Àâòîğ: Àíäğåé Ğûæîâ (Dune) <dune@rznlf.ru>        |
 * | Âåğñèÿ: 1.00                                      |
 * | Ñàéò: www.rznlf.ru                                |
 * ----------------------------------------------------
 * 
 */

class Dune_Data_Container_UserName implements ArrayAccess
{
  private $array = array();
    
  // Ìàññèâ ğóññêèõ áóêâ
  private $rus = array("À", "à", "Â", "Å", "å", "Ê", "Ì", "Í", "Î", "î", "Ğ",
                       "ğ", "Ñ", "ñ", "Ò", "Õ", "õ");
  // Ìàññèâ àíãëèéñêèõ áóêâ
  private $eng = array("A", "a", "B", "E", "e", "K", "M", "H", "O", "o", "P",
                       "p", "C", "c", "T", "X", "x");
                       
  public function __construct($name)
  {
      $this->array['original'] = $name;
      $this->array['russian'] = str_replace($this->eng, $this->rus, $name);
      $this->array['english'] =  str_replace($this->rus, $this->eng, $name);
  }
  

////////////////////////////////////////////////////////////////
///////////////////////////////     Ìåòîäû èíòåğôåéñà ArrayAccess
    public function offsetExists($key)
    {
        return key_exists($key,$this->array);
    }
    public function offsetGet($key)
    {
        if (!key_exists($key,$this->array))
          throw new Dune_Exception_Base('Îøèáêà ÷òåíèÿ ïåğåìåííîé: êëş÷à '.$key.' íå ñóùåñòâóåò. Ñóùåñòâóşò: original, russian, english');
          //return false;
        return $this->array[$key];
    }
    
    public function offsetSet($key, $value)
    {
        throw new Dune_Exception_Base('Çàğåùåíî ìåíÿòü çíà÷åíèå ïåğåìåííûõ');
    }
    public function offsetUnset($key)
    {
        throw new Dune_Exception_Base('Çàğåùåíî ìåíÿòü çíà÷åíèå ïåğåìåííûõ');
    }

/////////////////////////////
////////////////////////////////////////////////////////////////
  
  
////////////////////////////////////////////////////////////////
///////////////////////////////     Ìàãè÷åñêèå ìåòîäû

    public function __set($key, $val)
    {
        throw new Dune_Exception_Base('Çàğåùåíî ìåíÿòü çíà÷åíèå ïåğåìåííûõ');
    }
    public function __get($key)
    {
        if (!key_exists($key,$this->array))
            throw new Dune_Exception_Base('Îøèáêà ÷òåíèÿ ïåğåìåííîé: '.$key.' íå ñóùåñòâóåò. Ñóùåñòâóşò: original, russian, english');
        return $this->array[$key];
    }
    
}