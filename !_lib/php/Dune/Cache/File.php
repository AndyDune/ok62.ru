<?
/**
 * Класс кеширования данных в файл.
 * 
 * 
 *	 
 * --------------------------------------------------------
 * | Библиотека: Dune                                      |
 * | Файл: File.php                                        |
 * | В библиотеке: Dune/Cache./File.php                    |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>            |
 * | Версия: 0.98                                          |
 * | Сайт: www.rznlf.ru                                    |
 * --------------------------------------------------------
 * 
 */

class Dune_Cache_File
{
    private $parametersObject;
    
    
    public function __construct(Dune_Data_Container_CacheParameters $object)
    {
        $this->parametersObject = $object;
    }
    
    public function load(Dune_Data_Container_CacheKey $object)
    {
        
    }
    
    public function save()
    {
        
    }
    public function begin(Dune_Data_Container_CacheKey $object)
    {
        
    }
    
    public function end()
    {
        
    }
    
    public function remove()
    {
        
    }
    public function clean()
    {
        
    }
    
}