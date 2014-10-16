<?php
/**
 * Репозиторий функция для работы с таблицами статей в БД
 *  
 * Используются классы:
 *    Dune_MysqliSystem
 *    Dune_Data_Container_UserFriendlyUrl
 * 
 */

abstract class Functions_Mysqli_Article
{
    /**
     * Имя таблицы статей.
     * 
     * @var string
     */
    public static $tableNameArticle = 'dune_article_body';
    
    /**
     * Имя таблицы разделов статей.
     * 
     * @var string
     */
    public static $tableNameSection = 'dune_article_section';

    /**
     * Имя таблицы соответствия статей разделам.
     * 
     * @var string
     */
    public static $tableNameCorrespondence = 'dune_article_section_corr';

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
    protected static $_alloyArrayToSave = array('name', 'url', 'activity', 'time', 'notice', 'array_body', 'id');
    
    /**
     * Строка SET для запроса
     * 
     * @var string
     * @access private
     */
    protected static $_querySetString = '';
    
    protected $unserializationBody = false;
    protected $unserializationNotice = false;
    
    
////////////////////////////////////////////////////////////////////////////////////////
/////////////////       Открытые методы    
///////////////////////////////////////////////////////////////////////////////////////
    /**
     * Возвращает одну строку из таблицы статей. Использует в качестве ключа id.
     *
     * @param inreger $id
     * @param boolean $unserialization_body флаг десериализации содержимого страницы
     * @param boolean $unserialization_notice флаг десериализации короткого описания страницы
     * @return mixed массив при успехе, false при провале 
     */
    public static function getOneArticle($id, $unserialization_body = true, $unserialization_notice = true)
    {
        $result = false;
        self::_getDB();
        $query = 'SELECT name, url, activity, time, notice, array_body FROM ' . self::$tableNameArticle . '
                  WHERE id = ? LIMIT 1';
        
        $stmt = self::$_DB->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
        $stmt->store_result();
        if($stmt->num_rows > 0) 
        {
            $stmt->bind_result($name, $url, $activity, $time, $notice, $array_body);
            $stmt->fetch();
            $result['id'] = $id;
            $result['name'] = $name;
            $result['url'] = $url;
            $result['activity'] = $activity;
            $result['time'] = $time;

            if ($this->unserializationNotice)
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
            
            if ($this->unserializationBody)
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

    public function setUnserializeBody($bool = true)
    {
        $this->unserializationBody = $bool;
    }
    public function setUnserializeNotice($bool = true)
    {
        $this->unserializationNotice = $bool;
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
    public static function getArticleList($section = 0, $activity = 2, $shift = 0, $limit = 10, $order = 'asc')
    {
        $order = strtoupper($order);
        if (($order != 'ASC') or ($order != 'DESC'))
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
                             article.array_body
                      FROM    ' . self::$tableNameArticle . ' AS article, 
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
                             article.array_body
                      FROM ' . self::$tableNameArticle . ' AS article';
            if ($activity == 0)
            {
                $query .= ' WHERE article.activity = 0';
            }
            else if ($activity == 1)
            {
                $query .= ' WHERE article.activity = 1';
            }
            
        }
        
        $query .= ' ORDER BY article.time '. $order .', article.id '. $order .' LIMIT ?, ?';
        
        $stmt = self::$_DB->prepare($query);
        
        if ($section)
            $stmt->bind_param('iii', $section, $shift, $limit);
        else 
            $stmt->bind_param('ii', $shift, $limit);
            
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
        $stmt->store_result();
        if($stmt->num_rows > 0) 
        {
            $stmt->bind_result($id, $name, $url, $activity, $time, $notice, $array_body);
            while ($stmt->fetch())
            {
                $run['id'] = $id;
                $run['name'] = $name;
                $run['url'] = $url;
                $run['activity'] = $activity;
                $run['time'] = $time;

                if ($this->unserializationNotice)
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
                
                if ($this->unserializationBody)
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
     * @param integer $shift сдвиг в выборке
     * @param integer $limit лимит строк для выборки
     * @param string $order порядок сортировки: ASC или DESC (иначе исключение)
     * @return mixed 
     */
    public static function getArticleListBriefly($section = 0, $activity = 2, $shift = 0, $limit = 10, $order = 'asc')
    {
        $order = strtoupper($order);
        if (($order != 'ASC') or ($order != 'DESC'))
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
                             article.notice
                      FROM    ' . self::$tableNameArticle . ' AS article, 
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
                             article.notice
                      FROM ' . self::$tableNameArticle . ' AS article';
            if ($activity == 0)
            {
                $query .= ' WHERE article.activity = 0';
            }
            else if ($activity == 1)
            {
                $query .= ' WHERE article.activity = 1';
            }
            
        }
        
        $query .= ' ORDER BY article.time '. $order .', article.id '. $order .' LIMIT ?, ?';
        
        $stmt = self::$_DB->prepare($query);
        
        if ($section)
            $stmt->bind_param('iii', $section, $shift, $limit);
        else 
            $stmt->bind_param('ii', $shift, $limit);
            
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("Ошибка в отложенном запросе: ".$stmt->error);
        $stmt->store_result();
        if($stmt->num_rows > 0) 
        {
            $stmt->bind_result($id, $name, $url, $activity, $time, $notice);
            while ($stmt->fetch())
            {
                $run['id'] = $id;
                $run['name'] = $name;
                $run['url'] = $url;
                $run['activity'] = $activity;
                $run['time'] = $time;
                
                if ($this->unserializationNotice)
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
    public static function addArticle($array = array())
    {
        self::_getDB();
        self::$_arrayToSave = $array;
        self::_makeSetArticleString();
        $query = 'INSERT INTO ' . self::$tableNameArticle . self::$_querySetString;
        return self::$_DB->query($query);
        //return true;
    }
    
    /**
     * Сохраняет изменения для статьи.
     * Сохраняет в ряде с указанным ключем id в массиве
     * 
     *
     * @param array $array массив значений
     * @return boolean true при успешном добавлении.
     */
    public static function saveArticle($array = array())
    {
        if (!isset($array['id']))
            throw new Dune_Exception_Base('Отсутствует обязательный ключ в массиве для сохранения статьи: id');
        $id = (integer)$array['id'];
        self::_getDB();
        self::$_arrayToSave = $array;
        self::_makeSetArticleString();
        $query = 'UPDATE ' . self::$tableNameArticle . self::$_querySetString . ' WHERE id = ' . $id;
        return self::$_DB->query($query);
        //return true;
    }
    
    /**
     * Сохранение соотношений статьи разделам.
     * При пустом значении параметра $array удаляются все соответствия для статьи.
     *
     * @param integer $id идентификатор статьи
     * @param array $array массив идентификаторов разделов с которыми соотносим статью
     */
    public static function saveCorrespondenceToSection($id, $array = array())
    {
        $id = (integer)$id;
        self::_getDB();
        $query = 'DELETE FROM' . self::$tableNameCorrespondence . ' WHERE article_id = ' . $id;
        self::$_DB->query($query);
        if (count($array))
        {
           	$str = '';
           	$x = 0;
           	foreach ($array as $r_rey => $contents)
           	{
           		if ($x == 0)
           			$str.= ' ("' . $id . '", "' . (integer)$contents . '")';
           		else
           			$str.= ', ("' . $id . '", "' . (integer)$contents . '")';
           		$x++;
           	}
            $query = 'INSERT IGNORE INTO ' . self::$tableNameCorrespondence . ' (article_id, section_id)
                      VALUES' . $str;
            self::$_DB->query($query);
        }
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
    public static function countArticles($activity = 2)
    {
        $result = false;
        self::_getDB();
        if ($activity == 1)
        {
            $query = 'SELECT count(id) FROM ' . self::$tableNameArticle . '
                      WHERE activity = 1';
        }
        else if ($activity == 0) 
        {
            $query = 'SELECT count(id) FROM ' . self::$tableNameArticle . '
                      WHERE activity = 0';
            	
        }
        else 
        {
            $query = 'SELECT count(id) FROM ' . self::$tableNameArticle;
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
    public static function countArticlesInSection($section, $activity = 2)
    {
        $result = false;
        self::_getDB();
        $query = 'SELECT count(article.id) FROM ' . self::$tableNameArticle . ' AS article, 
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

    /**
     * Возвращает число подразделов у раздела
     * каких, в зависимости от параметра $activity
     * 0 - неактивных
     * 1 - активных
     * любое другое число - всех
     *
     * @param integer $section номер раздела
     * @param integer $activity
     * @return mixed число статей
     */
    public static function countSectionsInSection($section, $activity = 2)
    {
        $result = false;
        self::_getDB();
        $query = 'SELECT count(id) FROM ' . self::$tableNameSection . ', 
                  WHERE 
                      parent  = ?';
        
        if ($activity == 0)
        {
            $query .= ' AND activity = 0';
        }
        else if ($activity == 1)
        {
            $query .= ' AND activity = 1';
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
    protected static function _makeSetArticleString()
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
       	            throw new Dune_Exception_Base('В массиве для сохранения значений ряда таблицы ' . self::$tableNameArticle . ' может быть только 2 массива.');
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
       			$set_str.= ' SET `'.$r_rey.'`="'.mysql_real_escape_string($contents).'"';
       		else
       			$set_str.= ', `'.$r_rey.'`="'.mysql_real_escape_string($contents).'"';
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