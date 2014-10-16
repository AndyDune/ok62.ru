<?php
/**
 * Dune Framework
 * 
 * Ğàçáèåíèå ñòğîêè ñåïàğàòîğàìè ñ ñîçäàíèåì ìàññèâà.
 * Îá¸ğòêà ê ôóíêöèè explode()
 * 
 * ----------------------------------------------------
 * | Áèáëèîòåêà: Dune                                  |
 * | Ôàéë: Explode.php                                 |
 * | Â áèáëèîòåêå: Dune/String/Explode.php             |
 * | Àâòîğ: Àíäğåé Ğûæîâ (Dune) <dune@rznw.ru>         |
 * | Âåğñèÿ: 1.07                                      |
 * | Ñàéò: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * Èñòîğèÿ âåğñèé:
 * 
 * Âåğñèÿ 1.07  (2009 ìàé 14)
 * Ñòğîêîâûå ôóíêöèè èç êîíòåéíåğà. Êëàññ ãîòîâ ê UTF.
 * 
 * Âåğñèÿ 1.05  (2009 ÿíâàğü 22)
 * Èñïğàâëåíà îøèáêà ïğèíÿòèÿ 0(íóëÿ) çà îòñóòñòâèå çíà÷åíèÿ.
 * 
 * Âåğñèÿ 1.05  (2009 ÿíâàğü 21)
 * Äîáàâëåíà ğåàëèçàöèÿ èíòåğôåéñà Countable.
 * 
 * Âåğñèÿ 1.04  (2008 äåêàáğü 04)
 * Äîáàâëåí ìåòîä getResultArray() âîçâğàò âñåãî ìààññèâà.
 * 
 * 
 * Âåğñèÿ 1.03  (2008 îêòÿáğü 23)
 * Äîáàâëåí ìåòîä getInteger() äëÿ äîñòóïà ê êëş÷àì ğàçáèòîãî ìàññèâà.
 * Äîáàâëåíà âîçìîæíîñòü ìåíÿòü íà÷àëî îòñ÷åòà êëş÷åé ìàññèâà.
 * 
 * Âåğñèÿ 1.02
 * Ğåàëèçîâàí èòåğàòîğ.
 * 
 * Âåğñèÿ 1.00 -> 1.01
 * Ğàçáèåíèå ñòğîêè â ìàññèâ ïğè âûçîâå êîíñòğóêòîğà, åñëè ïåğåäàí ïàğìåòğ $separator.
 * Ìîæíî ïîâòîğèòü ğàçáèâêó (åñëè ñìåíèëè ñåïàğàòîğ) ïğè âûçîâå make()
 */

class Dune_String_Explode implements ArrayAccess, Iterator, Countable
{
	protected $_string;
	protected $_separator;
	protected $_array = array();
	protected $_count = 0;
	protected $_empty = false;
	
	
	public function __construct($string, $separator = '', $key_begin = 0)
	{
	    $str = Dune_String_Factory::getStringContainer($string);
	    $this->_string = $str->trim(' '.$separator);
//		$this->_string = trim($string, ' '.$separator);
		$this->_separator = $separator;
		if ($this->_separator)
			$this->make($key_begin);
		
	}
	
	public function setSeparator($separator)
	{
		$this->_separator = $separator;
	}
	
	public function count()
	{
		return $this->_count;
	}
	
	public function leaveEmpty($bool = true)
	{
		$this->_empty = $bool;
	}

	public function getInteger($key = 0, $default = null)
	{
        if (isset($this->_array[$key]))
            return (int)$this->_array[$key];
        else 
           return $default;
	}
	
	/**
	 * Ïğåîáğàçóåò ñòîêó â ìàññèâ ïî ğàçäåëèòåëş. Óäàëÿåò ïóñòûå.
	 *
	 * @return integer
	 */
    public function make($key_begin = 0)
    {
        $array_result = array();
        if ($this->_string)
        {
            $array_begin = explode($this->_separator, $this->_string);
            foreach ($array_begin as $value)
            {
                $x = trim($value);
                if ($x != '' or $this->_empty)
                {
                    $array_result[$key_begin] = $x;
                    $key_begin++;
                }
            }
        }
        $this->_array = $array_result;
        $this->_count = count($array_result);
        
        return $this->_count;
    }

    /**
     * Âîçâğàò âñåãî ğåçóëüòèğóşùåãî ìàññèâà.
     *
     * @param boolean $in_container
     * @return array
     */
    public function getResultArray($in_container = false)
    {
        if ($in_container)
            return new Dune_Array_Container($this->_array);
        return $this->_array;
    }

    
//////////////////////////////////////////////////////////////////
///////////////////////////////     Ìåòîäû èíòåğôåéñà ArrayAccess
    public function offsetExists($key)
    {
        return isset($this->_array[$key]);
    }
    public function offsetGet($key)
    {
        if (isset($this->_array[$key]))
            return $this->_array[$key];
        else 
           return null;
    }
    
    public function offsetSet($key, $value)
    {
        $this->_array[$key] = $value;
    }
    public function offsetUnset($key)
    {
        unset($this->_array[$key]);
    }    

    ////////////////////////////////////////////////////////////////
///////////////////////////////     Ìåòîäû èíòåğôåéñà Iterator
  // óñòàíàâëèâàåò èòåğåòîğ íà ïåğâûé ıëåìåíò
  public function rewind()
  {
        return reset($this->_array);
  }
  // âîçâğàùàåò òåêóùèé ıëåìåíò
  public function current()
  {
      return current($this->_array);
  }
  // âîçâğàùàåò êëş÷ òåêóùåãî ıëåìåíòà
  public function key()
  {
    return key($this->_array);
  }
  
  // ïåğåõîäèò ê ñëåäóşùåìó ıëåìåíòó
  public function next()
  {
    return next($this->_array);
  }
  // ïğîâåğÿåò, ñóùåñòâóåò ëè òåêóùèé ıëåìåíò ïîñëå âûïîëíåíèÿ ìîòîäà rewind èëè next
  public function valid()
  {
    return isset($this->_array[key($this->_array)]);
  }    
/////////////////////////////
////////////////////////////////////////////////////////////////   
    
    
}

