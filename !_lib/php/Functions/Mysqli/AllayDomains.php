<?php
/**
 * Репозиторий функция для работы с таблицами разрешённых доменов в БД
 *  
 * Используются классы:
 *    Dune_MysqliSystem
 * 
 */

abstract class Functions_Mysqli_AllayDomains
{
    
    /**
     * Указатель на объект - соединения с базой данных.
     * 
     * @var string
     * @access private
     */
    protected static $_DB = null;
    
    /**
     * Имя таблицы доменов.
     * 
     * @var string
     */
    public static $tableNameAllayDomains = 'dune_mail_alloy_domain';
    

////////////////////////////////////////////////////////////////////////////////////////
/////////////////       Открытые методы    
///////////////////////////////////////////////////////////////////////////////////////



    /**
     * Выборка списка статей. Выбираются все поля, кроме hash16.
     *
     * Статус статей определяется параметром $activity
     * 0 - неактивных
     * 1 - активных
     * любое другое число - всех

     * 
     * @param integer $section код раздела. Ноль, если не учитывать.
     * @param integer $activity 0, 1 или любое если не учитывать активность
     * @param integer $shift сдвиг в выборке
     * @param integer $limit лимит строк для выборки
     * @param string $order порядок сортировки: ASC или DESC (иначе исключение)
     * @return mixed 
     */
    public static function getList($order = 'ASC')
    {
        $order = strtoupper($order);
        if (($order != 'ASC') and ($order != 'DESC'))
            throw new Dune_Exception_Base('Передано неверное: '. $order .' значение направления сортировки выборки');
        $result = false;
        self::_getDB();
            $query = 'SELECT id,
                             domain
                      FROM    ' . self::$tableNameAllayDomains . ' 
                      ORDER BY domain '. $order;
        
       
        $stmt = self::$_DB->prepare($query);
            
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
        $stmt->store_result();
        if($stmt->num_rows > 0) 
        {
            $stmt->bind_result($id, $domain);
            while ($stmt->fetch())
            {
                $run['id'] = $id;
                $run['domain'] = $domain;
                $result[] = $run;
            }
        }
        $stmt->close();
        return $result;
    }
    
    
    /**
     * Добавляется новый ряд в таблицу доменов.
     *
     * @param string $domain
     * @return boolean true при успешном добавлении.
     */
    public static function add($domain)
    {
        self::_getDB();

        $query = 'INSERT INTO ' . self::$tableNameAllayDomains . ' SET domain = ?';
        $stmt = self::$_DB->prepare($query);
        $stmt->bind_param('s', $domain);
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
        $stmt->close();
        return true;
    }
    
    /**
     * Удаляем ряд из таблицы доменов.
     *
     * @param integer $id
     * @return boolean true при успешном добавлении.
     */
    public static function delete($id)
    {
        self::_getDB();

        $query = 'DELETE FROM ' . self::$tableNameAllayDomains . ' WHERE id = ?';
        $stmt = self::$_DB->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
        $stmt->close();
        return true;
    }
    
   
    /**
     * Возвращает число доменов
     *
     * @return mixed число статей
     */
    public static function count()
    {
        $result = false;
        self::_getDB();
        $query = 'SELECT count(id) FROM ' . self::$tableNameAllayDomains;
        
        $stmt = self::$_DB->prepare($query);
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
        $stmt->store_result();
        if($stmt->num_rows > 0) 
        {
            $stmt->bind_result($result);
            $stmt->fetch();
        }
        $stmt->close();
        return $result;
    }

    
////////////////////////////////////////////////////////////////////////////////////////
/////////////////       Закрытые методы    
///////////////////////////////////////////////////////////////////////////////////////


    /**
     * Получаем указатель на объект - соединения с базой данных.
     * 
     * @access private
     */
    protected static function _getDB()
    {
        if (self::$_DB == null)
        {
            self::$_DB = Dune_MysqliSystem::getInstance();
        }
    }
    
}