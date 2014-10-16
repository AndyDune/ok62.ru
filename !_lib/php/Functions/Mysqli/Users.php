<?php
/**
 * Репозиторий функция для работы с таблицей пользователей
 *  
 * Используются классы:
 *    Dune_MysqliSystem
 * 
 */

abstract class Functions_Mysqli_Users
{
    
    /**
     * Указатель на объект - соединения с базой данных.
     * 
     * @var string
     * @access private
     */
    protected static $_DB = null;
    
    /**
     * Имя таблицы пользователей.
     * 
     * @var string
     */
    public static $tableNameUsers = 'dune_auth_user_active';

    /**
     * Имя таблицы временных меток.
     * 
     * @var string
     */
    public static $tableTimeUsers = 'dune_auth_events_in_time';

    
    /**
     * Имя таблицы последнего входа пользователей.
     * 
     * @var string
     */
    public static $tableNameUsersLastTime = 'dune_auth_user_last_time';
    
    
    protected static $_alloyArrayToSaveUser = array('name', 'status', 'array', 'id');
    
    /**
     * Массив для сохранения в базе
     * 
     * @var array
     * @access private
     */
    protected static $_arrayToSave = array();
    
    
    /**
     * Строка SET для запроса
     * 
     * @var string
     * @access private
     */
    protected static $_querySetString = '';
    
    
    protected static $_orderString = '';
    protected static $_limitString = '';
    protected static $_whereString = '';
    
////////////////////////////////////////////////////////////////////////////////////////
/////////////////       Открытые методы    
///////////////////////////////////////////////////////////////////////////////////////



    public static function setOrder($name = 'id', $order = 'ASC')
    {
        $order = strtoupper($order);
        if (($order != 'ASC') and ($order != 'DESC'))
            throw new Dune_Exception_Base('Передано неверное: '. $order .' значение направления сортировки выборки');
        if (!self::$_orderString)
        {
            self::$_orderString = ' ORDER BY ' . $name . ' ' . $order;
        }
        else 
        {
            self::$_orderString .= ', ' . $name . ' ' . $order;
        }
    }
    public static function clearOrder()
    {
        self::$_orderString = '';
    }
    
    public static function setLimit($shift = 0, $limit = 10)
    {
        self::$_limitString = ' LIMIT ' . $shift . ', ' . $limit;
    }
    
    public static function setWhereNameFirstLetter($letter = 'a', $mode = 'AND')
    {
        $mode = strtoupper($order);
        if (($mode != 'AND') and ($mode != 'OR'))
            throw new Dune_Exception_Base('Передано неверное: '. $mode .' значение режима объединения условий');
        if (!self::$_whereString)
        {
            self::$_whereString = ' WHERE name LIKE "' . mysql_real_escape_string($letter) . '%"';
        }
        else 
        {
            self::$_whereString = ' ' . $mode . ' name LIKE "' . mysql_real_escape_string($letter) . '%"';
        }
    }

    public static function setWhereMailFirstLetter($letter = 'a', $mode = 'AND')
    {
        $mode = strtoupper($order);
        if (($mode != 'AND') and ($mode != 'OR'))
            throw new Dune_Exception_Base('Передано неверное: '. $mode .' значение режима объединения условий');
        if (!self::$_whereString)
        {
            self::$_whereString = ' WHERE mail LIKE "' . mysql_real_escape_string($letter) . '%"';
        }
        else 
        {
            self::$_whereString = ' ' . $mode . ' mail LIKE "' . mysql_real_escape_string($letter) . '%"';
        }
    }

    public static function setWhereStatus($status = 0, $ratio = '=', $mode = 'AND')
    {
        $mode = strtoupper($order);
        if (($mode != 'AND') and ($mode != 'OR'))
            throw new Dune_Exception_Base('Передано неверное: '. $mode .' значение режима объединения условий');
        if (($ratio != '=') and ($ratio != '>') and ($ratio != '<'))
            throw new Dune_Exception_Base('Передано неверное: '. $ratio .' значение соотношения числу');
            
        if (!self::$_whereString)
        {
            self::$_whereString = ' WHERE status' . $ratio . $status;
        }
        else 
        {
            self::$_whereString = ' ' . $mode . ' status' . $ratio . $status;            
            
        }
    }

    public static function setWhereTimeInteval($timeBegin = '0000-00-00', $timeEnd = '2020-00-00', $mode = 'AND')
    {
        $mode = strtoupper($order);
        if (($mode != 'AND') and ($mode != 'OR'))
            throw new Dune_Exception_Base('Передано неверное: '. $mode .' значение режима объединения условий');
        if (!self::$_whereString)
        {
            self::$_whereString = ' WHERE (time > "' . $timeBegin . '" AND time < "' . $TimeEnd . '")';
        }
        else 
        {
            self::$_whereString = ' ' . $mode . ' (time > "' . $timeBegin . '" AND time < "' . $TimeEnd . '")';
            
        }
    }
    
    public static function clearWhere()
    {
        self::$_whereString = '';
    }
    
    
    /**
     * Выборка списка Пользователей.
     *
     * @return array 
     */
    public static function getList()
    {
        $result = false;
        self::_getDB();
            $query = 'SELECT *
                      FROM    ' . self::$tableNameUsers .
                      self::$_whereString .
                      self::$_orderString .
                      self::$_limitString;
        
       
        $stmt = self::$_DB->prepare($query);
            
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
        $stmt->store_result();
        if($stmt->num_rows > 0) 
        {
            $stmt->bind_result($id, $mail, $name, $code, $time, $password, $status, $array);
            while ($stmt->fetch())
            {
                $run['id'] = $id;
                $run['mail'] = $mail;
                $run['name'] = $name;
                $run['code'] = $code;
                $run['time'] = $time;
                $run['password'] = $password;
                $run['status'] = $status;
                $run['array'] = unserialize($array);
                if (!is_array($run['array']))
                    $run['array'] = array();
                $result[] = $run;
            }
        }
        $stmt->close();
        return $result;
    }

    
    /**
     * Выборка информации об одном пользователе.
     *
     * @return array 
     */
    public static function getOne($id)
    {
        $result = false;
        self::_getDB();
            $query = 'SELECT *
                      FROM  ' . self::$tableNameUsers .
                     ' WHERE id = ?';
       
        $stmt = self::$_DB->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
        $stmt->store_result();
        if($stmt->num_rows > 0) 
        {
            $stmt->bind_result($id, $mail, $name, $code, $time, $password, $status, $array);
            $stmt->fetch();
            $result['id'] = $id;
            $result['mail'] = $mail;
            $result['name'] = $name;
            $result['code'] = $code;
            $result['time'] = $time;
            $result['password'] = $password;
            $result['status'] = $status;
            $result['array'] = unserialize($array);
            if (!is_array($result['array']))
                $result['array'] = array();
        }
        $stmt->close();
        return $result;
    }
    
    /**
     * Сохраняет изменения для статьи.
     * Сохраняет в ряде с указанным ключем id в массиве
     * 
     *
     * @param array $array массив значений
     * @return boolean true при успешном добавлении.
     */
    public static function saveOne($array = array())
    {
        if (!isset($array['id']))
            throw new Dune_Exception_Base('Отсутствует обязательный ключ в массиве для сохранения статьи: id');
        $id = (integer)$array['id'];
        self::_getDB();
        self::$_arrayToSave = $array;
        self::_makeSetString(self::$_alloyArrayToSaveUser, 1);
        $query = 'UPDATE ' . self::$tableNameUsers . self::$_querySetString . ' WHERE id = ' . $id;
        return self::$_DB->query($query);
        //return true;
    }

    
    
    /**
     * Выборка временноёинформации об одном пользователе.
     *
     * @return array 
     */
    public static function getTime($id)
    {
        $result = false;
        self::_getDB();
            $query = 'SELECT *
                      FROM  ' . self::$tableTimeUsers .
                     ' WHERE id = ' . (int)$id;
       
        $res = self::$_DB->query($query);
        if($res->num_rows > 0) 
        {
            $result = $res->fetch_assoc();
        }
        return $result;
    }

    /**
     * Обновление поля времени.
     *
     * @return array 
     */
    public static function setTime($id, $field)
    {
        $result = false;
        self::_getDB();
            $query = 'SELECT `' . $field . '`
                      FROM  ' . self::$tableTimeUsers .
                     ' WHERE id = ' . (int)$id;
       
        $res = self::$_DB->query($query);
        if (!$res)
            throw new Dune_Exception_Base('Ошибка в запросе: ' . $query);
            
        if($res->num_rows < 1) 
        {
            $query = 'REPLACE INTO `' . self::$tableTimeUsers . '`
                      SET `id`   = ?,
                     `' . $field  . '` = NOW()
                     ';
             $stmt_2 = self::$_DB->prepare($query);
             $stmt_2->bind_param('d', $id);
             $stmt_2->execute();
             if ($stmt_2->errno)
                 throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
             $stmt_2->close();
        }
        else 
        {
                    // С момента последнего запроса прошло достаточно времени
                        $query = 'UPDATE `' . self::$tableTimeUsers . '`
                                  SET `' . $field . '` = NOW()
                                  WHERE `id` = ?
                                  LIMIT 1
                                 ';
                        $stmt_2 = self::$_DB->prepare($query);
                        $stmt_2->bind_param('d', $id);
                        $stmt_2->execute();
                        if ($stmt_2->errno)
                            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
                        $stmt_2->close();
            
            
        }
        return $result;
    }
    
    
    
    /**
     * Возвращает число пользователей с применением всех условий выборки
     *
     * @return mixed число пользователей
     */
    public static function count()
    {
        $result = false;
        self::_getDB();
        $query = 'SELECT count(id)
                  FROM    ' . self::$tableNameUsers .
                  self::$_whereString;
        
        
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
    
    
    public static function setStatus($id, $status = 0)
    {
        self::_getDB();
        
        $query = 'UPDATE ' . self::$tableNameUsers . '
                  SET status = ?
                  WHERE id = ?
                  LIMIT 1';
        $stmt = self::$_DB->prepare($query);
        $stmt->bind_param('ii', $status, $id);
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
        $stmt->close();
        
    }

    public static function setCode($id)
    {
        self::_getDB();
        
        $code = uniqid();
        
        $query = 'UPDATE ' . self::$tableNameUsers . '
                  SET code = ?
                  WHERE id = ?
                  LIMIT 1';
        $stmt = self::$_DB->prepare($query);
        $stmt->bind_param('si', $code, $id);
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
        $stmt->close();
        return $code;
    }

    public static function setPassword($id, $password)
    {
        self::_getDB();
        
        
        $query = 'UPDATE ' . self::$tableNameUsers . '
                  SET `password` = ?
                  WHERE `id` = ?
                  LIMIT 1';
        $stmt = self::$_DB->prepare($query);
        $stmt->bind_param('si', $password, $id);
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
        $stmt->close();
        return $code;
    }
    
    
    /**
     * Добавляется новый ряд в таблицу пользователей.
     *
     * @param string $domain
     * @return boolean true при успешном добавлении.
     */
    public static function add($domain)
    {
        self::_getDB();

        $query = 'INSERT INTO ' . self::$tableNameUsers . ' SET domain = ?';
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
        
        $query = 'DELETE FROM ' . self::$tableNameUsersLastTime . ' WHERE id = ?';
        $stmt = self::$_DB->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
        $stmt->close();
        
        $query = 'DELETE FROM ' . self::$tableNameUsers . ' WHERE id = ?';
        $stmt = self::$_DB->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
        $stmt->close();
        return true;
    }
    
   
    /**
     * Возвращает общее число пользователей.
     *
     * @return mixed число статей
     */
    public static function countTotal()
    {
        $result = false;
        self::_getDB();
        $query = 'SELECT count(id) FROM ' . self::$tableNameUsers;
        
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
     * Создание строки для сохранения в базе.
     * Сериализует подмассив. Который должен быть только один.
     * 
     * @access private
     */
    protected static function _makeSetString($alloyArray, $arrays = 0, $requireFields = false)
    {
        // Основной ключ - здесь не нужен
        unset(self::$_arrayToSave['id']);
        
        if ($requireFields)
        {
            foreach ($requireFields as $run)
            {
                if (!key_exists($run, self::$_arrayToSave))
                {
                     throw new Dune_Exception_Base('В массиве для сохранение отчутствует необходимы ключ: ' . $run);
                }
            }
        }
        
        
       	$find_one = 0;
       	// Два элемента в переданном массиве может быть массивом - их сериализуем
       	// Подмассивов может быт только 2 - иначе исключение
       	foreach (self::$_arrayToSave as $r_rey => $contents)
       	{
       	    if (!in_array($r_rey, $alloyArray))
       	    {
                throw new Dune_Exception_Base('Недопустимый ключ в массиве для сохранения в базе: ' . $r_rey);
       	        
       	    }
       	        
       	    if (is_array($contents))
       	    {
       	        if ($find_one == $arrays)
       	        {
       	            throw new Dune_Exception_Base('В массиве для сохранения значений ряда таблицы ' . self::$tableNameArticle . ' может быть только ' . $arrays . ' массив(ов).');
       	        }
       	        self::$_arrayToSave[$r_rey] = serialize(self::$_arrayToSave[$r_rey]);
       	        $find_one += 1;
       	    }
       	}       
       	// Создаём строку SET
       	// Здесь url есть в любом случае	
       	$set_str = '';
       	$x = 0;
       	foreach (self::$_arrayToSave as $r_rey => $contents)
       	{
       		if ($x == 0)
       			$set_str.= ' SET `'.$r_rey.'`="' . self::$_DB->real_escape_string($contents) . '"';
       		else
       			$set_str.= ', `'.$r_rey.'`="' . self::$_DB->real_escape_string($contents) . '"';
       		$x++;
       	}
        self::$_querySetString =  $set_str;
    }







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