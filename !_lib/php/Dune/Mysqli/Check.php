<?
/**
 * Класс - репозиторий функций проверок чего-либо в таблицах базы данных Mysql
 * 
 *
 * Исползует классы:
 * Dune_MysqliSystem
 *  
 *	 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Check.php                                   |
 * | В библиотеке: Dune/Mysqli/Check.php               |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.01                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * Версии:
 * 
 * 1.01 (2008 Ноябрь 07)
 *  Не используется стандартный подготовленный запрос.
 * 
 */

abstract class Dune_Mysqli_Check
{
    static protected $DB = null;
    
    /**
     * Проверка существования имени ипользователя в таблице
     *
     * @param Dune_Data_Container_UserName $object объект-контейнер имени пользователя
     * @param string $tableName имя таблицы
     * @param string $fieldName имя поля таблицы, где сохраняется имя пользователя
     * @return boolean
     */
    static public function existenceUserName(Dune_Data_Container_UserName $object, $tableName, $fieldName = 'name')
    {
        $result = false;
        
        // Если указатель на объект соединения с БД еще не сохранен - сохраняем
        if (self::$DB == null)
            self::$DB = Dune_MysqliSystem::getInstance();
            
        // Формируем отложенный запрос
        $query = 'SELECT count(*) FROM `'.$tableName.'`
                  WHERE `' . $fieldName . '` LIKE ?
                         OR
                        `' . $fieldName . '` LIKE ?
                         OR
                        `' . $fieldName . '` LIKE ?
                         LIMIT 1';

        
        // Если что-то выбрали - имя пользователя не уникально
        if(self::$DB->query($query, array($object['original'], $object['english'], $object['russian']), Dune_MysqliSystem::RESULT_EL) > 0) 
        {
            $result = true;
        }

        return $result;     
        
        
        
        
        
        
        
        
    }
}