<?php
/**
 * 
 * Данные о добавляемом объекте.
 * 
 */
class Special_Vtor_Object_Query_DataSingleton extends Special_Vtor_Object_Query_Abstract_Data
{
    
   /**
    * Иниц. при первом вызове стат. метода и возвращается при последующих
    *
    * @var Special_Vtor_Object_Query_DataSingleton
    * @access private
    */
    static private $instance = NULL;
    
  /**
   * Создаёт реализацию класса при первом вызове
   * Возвращает сохранённый указатель объекта при последующих вызовах
   *
   * Вызывает указаталь на объект с системными параметрами
   * 
   * @return Special_Vtor_Object_Query_DataSingleton
   */
    static public function getInstance($id = 0)
    {
        if (self::$instance == NULL)
        {
            self::$instance = new Special_Vtor_Object_Query_DataSingleton($id);
        }
        return self::$instance;
    }

}