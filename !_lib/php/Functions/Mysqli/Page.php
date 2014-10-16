<?php
/**
 * Репозиторий функция для работы с таблицами статей в БД
 *  
 * Используются классы:
 *    Dune_MysqliSystem
 *    Dune_Data_Container_UserFriendlyUrl
 * 
 */

abstract class Functions_Mysqli_Page
{
    /**
     * Имя таблицы статей.
     * 
     * @var string
     */
    public static $tableName = 'dune_page';
    
    /**
     * Имя таблицы разделов статей.
     * 
     * @var string
     */
    public static $tableNameSection = 'dune_page_section';

    /**
     * Имя таблицы соответствия статей разделам.
     * 
     * @var string
     */
    public static $tableNameCorrespondence = 'dune_page_section_corr';

    /**
     * Указатель на объект - соединения с базой данных.
     * 
     * @var string
     * @access private
     */
    protected static $_DB = null;
    
    /**
     * Массив для сохранения в базе
     * 
     * @var array
     * @access private
     */
    protected static $_arrayToSave = array();

    /**
     * Массив дозволенных ключей в массиве для сохранения.
     * 
     * @var array
     * @access private
     */
    protected static $_alloyArrayToSave = array('name', 'url', 'activity', 'time', 'notice', 'array_body', 'id', 'order');
    
    /**
     * Строка SET для запроса
     * 
     * @var string
     * @access private
     */
    protected static $_querySetString = '';
    
    protected static $_limitString = '';
    
    
    protected static $unserializationBody = false;
    protected static $unserializationNotice = false;
    
    
////////////////////////////////////////////////////////////////////////////////////////
/////////////////       Открытые методы    
///////////////////////////////////////////////////////////////////////////////////////
    /**
     * Возвращает одну строку из таблицы статей. Использует в качестве ключа id.
     *
     * @param inreger $id
     * @return mixed массив при успехе, false при провале 
     */
    public static function getOne($id)
    {
        $result = false;
        self::_getDB();
        $query = 'SELECT name, url, activity, time, notice, array_body, `order` FROM `' . self::$tableName . '`
                  WHERE id = ? LIMIT 1';
        
        $stmt = self::$_DB->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
        $stmt->store_result();
        if($stmt->num_rows > 0) 
        {
            $stmt->bind_result($name, $url, $activity, $time, $notice, $array_body, $order);
            $stmt->fetch();
            $result['id'] = $id;
            $result['name'] = $name;
            $result['url'] = $url;
            $result['activity'] = $activity;
            $result['time'] = $time;
            $result['order'] = $order;

            if (self::$unserializationNotice)
            {
                $result['notice'] = @unserialize($notice);
                if (!is_array($result['notice']))
                {
                    $result['notice'] = $notice;
                }
            }            
            else 
            {
                $result['notice'] = $notice;
            }
            
            if (self::$unserializationBody)
            {
                $result['array_body'] = @unserialize($array_body);
                if (!is_array($result['array_body']))
                {
                    $result['array_body'] = array();
                }
            }
            else 
            {
                $result['array_body'] = $array_body;
            }
        }
        $stmt->close();
        return $result;
    }

    public static function setUnserializeBody($bool = true)
    {
        self::$unserializationBody = $bool;
    }
    public static function setUnserializeNotice($bool = true)
    {
        self::$unserializationNotice = $bool;
    }

    public static function setLimit($shift = 0, $limit = 10)
    {
        self::$_limitString = ' LIMIT ' . $shift . ', ' . $limit;
    }

    
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
    public static function getList($section = 0, $activity = 2, $order = 'ASC')
    {
        $order = strtoupper($order);
        if (($order != 'ASC') and ($order != 'DESC'))
            throw new Dune_Exception_Base('Передано неверное: '. $order .' значение направления сортировки выборки');
        $result = false;
        self::_getDB();
        if ($section)
        {
            $query = 'SELECT article.id,
                             article.name,
                             article.url,
                             article.activity,
                             article.time,
                             article.notice,
                             article.array_body,
                             article.order,
                             corr.order
                      FROM    ' . self::$tableName . ' AS article, 
                              ' . self::$tableNameCorrespondence .' AS corr
                      WHERE 
                          corr.section_id = ? AND
                          corr.article_id  = article.id';
            if ($activity == 0)
            {
                $query .= ' AND article.activity = 0';
            }
            else if ($activity == 1)
            {
                $query .= ' AND article.activity = 1';
            }
        }
        else 
        {
            $query = 'SELECT article.id,
                             article.name,
                             article.url,
                             article.activity,
                             article.time,
                             article.notice,
                             article.array_body,
                             article.order
                      FROM ' . self::$tableName . ' AS article';
            if ($activity == 0)
            {
                $query .= ' WHERE article.activity = 0';
            }
            else if ($activity == 1)
            {
                $query .= ' WHERE article.activity = 1';
            }
            
        }
        
//        $query .= ' ORDER BY article.order '. $order .', article.id '. $order .' LIMIT ?, ?';

        if ($section)
        {
            $query .= ' ORDER BY corr.order '. $order .', article.id '. $order . self::$_limitString;
        }
        else 
        {
            $query .= ' ORDER BY article.order '. $order .', article.id '. $order .self::$_limitString;
        }
        
        
        $stmt = self::$_DB->prepare($query);
        
        if ($section)
        {
            $stmt->bind_param('i', $section);
        }
            
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
        $stmt->store_result();
        if($stmt->num_rows > 0) 
        {
            $order_section = false;
            if ($section)
            {
                $stmt->bind_result($id, $name, $url, $activity, $time, $notice, $order, $order_section);                
            }
            else 
            {
                $stmt->bind_result($id, $name, $url, $activity, $time, $notice, $order);
            }
            
            while ($stmt->fetch())
            {
                $run['id'] = $id;
                $run['name'] = $name;
                $run['url'] = $url;
                $run['activity'] = $activity;
                $run['time'] = $time;
                $run['order'] = $order;
                $run['order_section'] = $order_section;

                if (self::$unserializationNotice)
                {
                    $run['notice'] = @unserialize($notice);
                    if (!is_array($run['notice']))
                    {
                        $run['notice'] = $notice;
                    }
                }
                else 
                {
                    $run['notice'] = $notice;
                }
                
                if (self::$unserializationBody)
                {

                    $run['array_body'] = @unserialize($array_body);
                    if (!is_array($run['array_body']))
                    {
                        $run['array_body'] = array();
                    }
                }
                else 
                {
                    $run['array_body'] = $array_body;
                }
                
                $result[] = $run;
            }
        }
        $stmt->close();
        return $result;
    }
    
    /**
     * Выборка списка статей без основного содержания (поле array). Выбираются все поля, кроме hash16.
     *
     * Статус статей определяется параметром $activity
     * 0 - неактивных
     * 1 - активных
     * любое другое число - всех

     * 
     * @param integer $section код раздела. Ноль, если не учитывать.
     * @param integer $activity 0, 1 или любое если не учитывать активность
     * @param string $order порядок сортировки: ASC или DESC (иначе исключение)
     * @return mixed 
     */
    public static function getListBriefly($section = 0, $activity = 2, $order = 'asc')
    {
        $order = strtoupper($order);
        if (($order != 'ASC') and ($order != 'DESC'))
            throw new Dune_Exception_Base('Передано неверное: '. $order .' значение направления сортировки выборки');
        $result = false;
        self::_getDB();
        if ($section)
        {
            $query = 'SELECT article.id,
                             article.name,
                             article.url,
                             article.activity,
                             article.time,
                             article.notice,
                             article.order,
                             corr.order
                      FROM    ' . self::$tableName . ' AS article, 
                              ' . self::$tableNameCorrespondence .' AS corr
                      WHERE 
                          corr.section_id = ? AND
                          corr.article_id  = article.id';
            if ($activity == 0)
            {
                $query .= ' AND article.activity = 0';
            }
            else if ($activity == 1)
            {
                $query .= ' AND article.activity = 1';
            }
        }
        else 
        {
            $query = 'SELECT article.id,
                             article.name,
                             article.url,
                             article.activity,
                             article.time,
                             article.notice,
                             article.order
                      FROM ' . self::$tableName . ' AS article';
            if ($activity == 0)
            {
                $query .= ' WHERE article.activity = 0';
            }
            else if ($activity == 1)
            {
                $query .= ' WHERE article.activity = 1';
            }
            
        }
        
        if ($section)
        {
            $query .= ' ORDER BY corr.order '. $order .', article.id '. $order . self::$_limitString;
        }
        else 
        {
            $query .= ' ORDER BY article.order '. $order .', article.id '. $order . self::$_limitString;
        }
        
        
        $stmt = self::$_DB->prepare($query);
        
        if ($section)
            $stmt->bind_param('i', $section);
            
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
        $stmt->store_result();
        if($stmt->num_rows > 0) 
        {
            $order_section = false;
            if ($section)
            {
                $stmt->bind_result($id, $name, $url, $activity, $time, $notice, $order, $order_section);                
            }
            else 
            {
                $stmt->bind_result($id, $name, $url, $activity, $time, $notice, $order);
            }
            
            while ($stmt->fetch())
            {
                $run['id'] = $id;
                $run['name'] = $name;
                $run['url'] = $url;
                $run['activity'] = $activity;
                $run['time'] = $time;
                $run['order'] = $order;
                $run['order_section'] = $order_section;
                
                if (self::$unserializationNotice)
                {
                    $run['notice'] = @unserialize($notice);
                    if (!is_array($run['notice']))
                    {
                        $run['notice'] = $notice;
                    }
                }
                else 
                {
                    $run['notice'] = $notice;
                }
                
                $result[] = $run;
            }
        }
        $stmt->close();
        return $result;
    }    
    
    /**
     * Добавляется новый ряд в таблицу статей.
     * Добавлятся может с начальными значениями полей.
     * 
     * 
     *
     * @param array $array массив значений с которыми добавляется (необязателен)
     * @return boolean true при успешном добавлении.
     */
    public static function add($array = array())
    {
        $result = false;
        self::_getDB();
        self::$_arrayToSave = $array;
        self::_makeSetString();
        $query = 'INSERT INTO ' . self::$tableName . self::$_querySetString;
        if (self::$_DB->query($query))
        {
            $result = self::$_DB->insert_id;
        }
        
        return $result;
    }
    
    public static function delete($id)
    {
        self::_getDB();
        
        $query = 'DELETE FROM ' . self::$tableName . ' WHERE id = ?';
        $stmt = self::$_DB->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
        $stmt->close();
        
        $query = 'DELETE FROM ' . self::$tableNameCorrespondence . ' WHERE article_id = ?';
        $stmt = self::$_DB->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
        $stmt->close();
        return true;
    }
    
    
    /**
     * Сохраняет изменения для статьи.
     * Сохраняет в ряде с указанным ключем id в массиве
     * 
     *
     * @param array $array массив значений
     * @return boolean true при успешном добавлении.
     */
    public static function save($array = array())
    {
        if (!isset($array['id']))
            throw new Dune_Exception_Base('Отсутствует обязательный ключ в массиве для сохранения статьи: id');
        $id = (integer)$array['id'];
        self::_getDB();
        self::$_arrayToSave = $array;
        self::_makeSetString();
        $query = 'UPDATE ' . self::$tableName . self::$_querySetString . ' WHERE id = ' . $id;
        
        return self::$_DB->query($query);
        //return true;
    }
    
    

    
    /**
     * Возвращает число статей
     * каких, в зависимости от параметра $activity
     * 0 - неактивных
     * 1 - активных
     * любое другое число - всех
     *
     * @param integer $activity
     * @return mixed число статей
     */
    public static function count($activity = 2)
    {
        $result = false;
        self::_getDB();
        if ($activity == 1)
        {
            $query = 'SELECT count(id) FROM ' . self::$tableName . '
                      WHERE activity = 1';
        }
        else if ($activity == 0) 
        {
            $query = 'SELECT count(id) FROM ' . self::$tableName . '
                      WHERE activity = 0';
            	
        }
        else 
        {
            $query = 'SELECT count(id) FROM ' . self::$tableName;
        }
        
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


    /**
     * Возвращает число статей в разделе
     * каких, в зависимости от параметра $activity
     * 0 - неактивных
     * 1 - активных
     * любое другое число - всех
     *
     * @param integer $section номер раздела
     * @param integer $activity
     * @return mixed число статей
     */
    public static function countInSection($section, $activity = 2)
    {
        $result = false;
        self::_getDB();
        $query = 'SELECT count(article.id) FROM ' . self::$tableName . ' AS article, 
                                        ' . self::$tableNameCorrespondence .' AS corr
                  WHERE 
                      corr.section_id = ? AND
                      corr.article_id  = article.id';
        
        if ($activity == 0)
        {
            $query .= ' AND article.activity = 0';
        }
        else if ($activity == 1)
        {
            $query .= ' AND article.activity = 1';
        }
        
        $stmt = self::$_DB->prepare($query);
        $stmt->bind_param('i', $section);
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

    public static function getSectionList()
    {
        $result = false;
        self::_getDB();
        $query = 'SELECT `id`, `name`, `order` 
                  FROM `' . self::$tableNameSection .'`
                  ORDER BY `order` ASC';
        $stmt = self::$_DB->prepare($query);
        if (!$stmt instanceof mysqli_stmt)
            throw new Dune_Exception_Base('Ошибка в создании подготовленного запроса: <strong>' . $query . '</strong>');
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0) 
        {
            $stmt->bind_result($id, $name, $order);
            while ($stmt->fetch())
            {
                $run['id'] = $id;
                $run['name'] = $name;
                $run['order'] = $order;
                $result[] = $run;
            }
        }
        $stmt->close();
        return $result;
    }

    public static function getSectionCorrList($id)
    {
        $result = false;
        self::_getDB();
        $query = 'SELECT `section_id` 
                  FROM `' . self::$tableNameCorrespondence .'`
                  WHERE `article_id` = ?';
        $stmt = self::$_DB->prepare($query);
        $stmt->bind_param('i', $id);
        if (!$stmt instanceof mysqli_stmt)
            throw new Dune_Exception_Base('Ошибка в создании подготовленного запроса: <strong>' . $query . '</strong>');
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0) 
        {
            $stmt->bind_result($s_id);
            while ($stmt->fetch())
            {
                $result[] = $s_id;
            }
        }
        $stmt->close();
        return $result;
    }
    
    public static function clearSectionCorr($id)
    {
        $result = false;
        self::_getDB();
        $query = 'DELETE FROM `' . self::$tableNameCorrespondence .'`
                  WHERE `article_id` = ?';
        $stmt = self::$_DB->prepare($query);
        $stmt->bind_param('i', $id);
        if (!($stmt instanceof mysqli_stmt))
            throw new Dune_Exception_Base('Ошибка в создании подготовленного запроса: <strong>' . $query . '</strong>');
        $stmt->execute();
        $stmt->close();
        return $result;
    }
    
    public static function setSectionCorr($array)
    {
        $result = false;
        self::_getDB();
        $query = 'INSERT
                  INTO `' . self::$tableNameCorrespondence .'`
                  SET `article_id` = ?,
                      `section_id` = ?
                  ';
        $stmt = self::$_DB->prepare($query);
        if (!$stmt instanceof mysqli_stmt)
            throw new Dune_Exception_Base('Ошибка в создании подготовленного запроса: <strong>' . $query . '</strong>');
        foreach ($array as $run)
        {
            $stmt->bind_param('ii', $run['article_id'], $run['section_id']);            
            $stmt->execute();
        }
        $stmt->close();
        return $result;
    }
    
    
    
////////////////////////////////////////////////////////////////////////////////////////
/////////////////       Закрытые методы    
///////////////////////////////////////////////////////////////////////////////////////

    /**
     * Создание строки для сохранения в базе.
     * Так же генерит hash16 удаляет ключ id из массива.
     * Сериализует подмассив. Который должен быть только один.
     * 
     * @access private
     */
    protected static function _makeSetString()
    {
        // Если не задан url и задан name
        if ((!key_exists('url', self::$_arrayToSave) or (self::$_arrayToSave['url'] == '')) and
            (key_exists('name', self::$_arrayToSave)))
        {
            // Миксуем name для генерации url и hash16
            $object = new Dune_Data_Container_UserFriendlyUrl(self::$_arrayToSave['name']);
            // Если успешно замикстовали
            if ($object->getUrl() != '')
            {
                self::$_arrayToSave['url'] = $object->getUrl();
            }
        }
        // Если задан url
        else if (key_exists('url', self::$_arrayToSave) and (self::$_arrayToSave['url'] != ''))
        {
            $object = new Dune_Data_Container_UserFriendlyUrl();
            $object->useUrl(strtolower(self::$_arrayToSave['url']));
            self::$_arrayToSave['url'] = $object->getUrl();
            
        }
        else 
        {
            // hash16 по умолчанию
            self::$_arrayToSave['url'] = 'article';
        }
        // Основной ключ - здесь не нужен
        unset(self::$_arrayToSave['id']);
        
       	$find_one = 0;
       	// Два элемента в переданном массиве может быть массивом - их сериализуем
       	// Подмассивов может быт только 2 - иначе исключение
       	foreach (self::$_arrayToSave as $r_rey => $contents)
       	{
       	    if (!in_array($r_rey, self::$_alloyArrayToSave))
       	    {
                throw new Dune_Exception_Base('Недопустимый ключ в массиве для сохранения статьи: ' . $r_rey);
       	        
       	    }
       	        
       	    if (is_array($contents))
       	    {
       	        if ($find_one == 2)
       	        {
       	            throw new Dune_Exception_Base('В массиве для сохранения значений ряда таблицы ' . self::$tableName . ' может быть только 2 массива.');
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
       			$set_str.= ' SET `'.$r_rey.'`="'.self::$_DB->real_escape_string($contents).'"';
       		else
       			$set_str.= ', `'.$r_rey.'`="'.self::$_DB->real_escape_string($contents).'"';
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