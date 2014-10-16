<?php
/**
 * Простой класс для работы с голосованиями
 * 
 * Перед созданием объекта соединение с базой уже должно быть
 * Должны быть созданы баблицы. Их дамп:
 *
 * CREATE TABLE `voting_variant` (
 *     `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
 *    `question_id` INT UNSIGNED DEFAULT '0' NOT NULL ,
 *    `name` TEXT NOT NULL ,
 *    `num` INT UNSIGNED DEFAULT '0' NOT NULL ,
 *    `order` mediumint(8) unsigned NOT NULL default '100',
 *     PRIMARY KEY ( `id` ) ,
 *     INDEX ( `question_id` )
 *     );
 *
 * CREATE TABLE `voting_question` (
 *      `id` int(10) unsigned NOT NULL auto_increment,
 *      `name` text NOT NULL,
 *      `active` tinyint(3) unsigned NOT NULL default '0',
 *      `time_begin` datetime NOT NULL default '0000-00-00 00:00:00',
 *      `time_end` datetime NOT NULL default '0000-00-00 00:00:00',
 *       PRIMARY KEY  (`id`),
 *       KEY `active` (`active`,`time_begin`,`time_end`)
 *     ) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;
 *
 *
 */
class Dune_Voting_SimpleMysql
{
private $questionId = 0;
private $numAllQuestion = -1;
private $numActiveQuestion  = -1;
private $numActiveQuestionInTime  = -1;
/**
 * Массив голосований со всей информацией
 *
 */
private $votingArray = array();
/**
 * Хранит код обрабатываемого голосования
 *
 * @var unknown_type
 */
//private $questionCode;

public function __construct($testTables = true)
{
   	if ($testTables)
   	{
        try
	    {
		    if (!mysql_query("SELECT 1 FROM `voting_variant` WHERE 0")) throw new Exception('В базе данных нет таблицы "voting_variant"');
		    if (!mysql_query("SELECT 1 FROM `voting_question` WHERE 0")) throw new Exception('В базе данных нет таблицы "voting_question"');
	    }
	    catch(Exception $e)
	    {
		    echo 'Исключение: '.$e->getMessage().'<br />';
		    echo 'Класс: '.__CLASS__.'<br />';
		    echo 'Строка : '.$e->getLine().'<br />';
		    exit();
	    }
   	}
}
/**
 * Задать id для вопроса голосования, текущего
 *
 * @param unknown_type $id
 */
public function setQuestion($id)
{
    $this->questionId = $id;
}

/**
 * Активация опроса
 *
 * @param unknown_type $array
 */
public function active($active = 1)
{
    $this->test_question();
    $q = 'UPDATE `voting_question`
          SET   `active`='.(int)$active.'
          WHERE `id`='.$this->questionId.' LIMIT 1';
    if (!mysql_query($q))
        throw new Exception('Ошибка в запросе на обновление данных о вопросе для голосования. Метод класса: '.__METHOD__);
     return true;
    
}


public function getCountAllQuestion()
{
    if ($this->numAllQuestion >= 0)
        return $this->numAllQuestion;
    $q = 'SELECT COUNT(*) as "num" FROM `voting_question`';
    $res = mysql_query($q);
    if (!$res)
        throw new Exception('Ошибка в запросе. Метод класса: '.__METHOD__);
    $t = mysql_fetch_assoc($res);
    return $this->numAllQuestion = $t['num'];
}
public function getCountActiveQuestion()
{
    if ($this->numActiveQuestion >= 0)
        return $this->numActiveQuestion;
    $q = 'SELECT COUNT(*) as "num" FROM `voting_question` WHERE `active` > 0';
    $res = mysql_query($q);
    if (!$res)
        throw new Exception('Ошибка в запросе. Метод класса: '.__METHOD__);
    $t = mysql_fetch_assoc($res);        
    return $this->numActiveQuestion = $t['num'];
    
}
/**
 * Возвращает число активных опросов во временном интервале
 *
 * @return целое число
 */
public function getCountActiveQuestionInTime()
{
    if ($this->numActiveQuestionInTime >= 0)
        return $this->numActiveQuestionInTime;
    $q = 'SELECT COUNT(*) as "num" FROM `voting_question`
          WHERE `active` > 0
            AND `time_begin` < NOW()
            AND `time_end` > NOW()
            ';
    $res = mysql_query($q);
    if (!$res)
        throw new Exception('Ошибка в запросе. Метод класса: '.__METHOD__);
    $t = mysql_fetch_assoc($res);
    return $this->numActiveQuestionInTime = $t['num'];
}


private function test_question()
{
    if (!$this->questionId)
        throw new Exception('ID опроса не задан. Метод класса: '.__METHOD__);
}

/**
 * Создаёт новую запись в таблице голосований
 * ключи массива:
 * "name" - строка вопроса голосования (имя)
 * "time_begin" - начало голосования
 * "time_end" - время конца голосования
 * "active" - активность голосования 0 - нет, не 0 - да
 * @param unknown_type $array
 */
public function addQuestion()
{
    $q = 'INSERT INTO `voting_question` VALUES (NULL,"",0,NOW(),"2013-01-01")';
    if (!mysql_query($q))
        throw new Exception('Ошибка добавления записи. Метод класса: '.__METHOD__);
     return true;
}
public function updateQuestion($array)
{
    $this->test_question();
        
    if (!is_array($array))
        throw new Exception('Функция ожидает приёма массива. Метод класса: '.__METHOD__);
    if (!count($array))
        throw new Exception('Массив должен быть непустой');

    if (empty($array['name']))
        $array['name'] = '';
    if (empty($array['time_begin']))
        $array['time_begin'] = date('Y-m-d');
    if (empty($array['time_end']))
        $array['time_end'] = '2013-01-01';
        
    $q = 'UPDATE `voting_question`
          SET   `name`="'.mysql_real_escape_string($array['name']).'",
                `time_begin`="'.mysql_real_escape_string($array['time_begin']).'",
                `time_end`="'.mysql_real_escape_string($array['time_end']).'"
          WHERE `id`='.$this->questionId.' LIMIT 1';
    if (!mysql_query($q))
        throw new Exception('Ошибка в запросе на обновление данных о вопросе для голосования. Метод класса: '.__METHOD__);
     return true;
}
public function deleteQuestion()
{
    $this->test_question();
        
    $q = 'DELETE FROM `voting_variant` WHERE `question_id`='.$this->questionId;
    if (!mysql_query($q))
       throw new Exception('Ошибка удаления соответствующих вариантов. Метод класса: '.__METHOD__);
    $q = 'DELETE FROM `voting_question` WHERE `id`='.$this->questionId.' LIMIT 1';
    if (!mysql_query($q))
       throw new Exception('Ошибка удаления вопроса для горлосования. Метод класса: '.__METHOD__);
    return true;
}


public function addVariant()
{
    $this->test_question();

    $q = 'INSERT INTO `voting_variant` VALUES (NULL,'.$this->questionId.',"",0,100)';
    if (!mysql_query($q))
        throw new Exception('Ошибка добавления записи. Метод класса: '.__METHOD__);
     return true;
    
}
public function updateVariant($array)
{
    $this->test_question();
        
    if (!is_array($array))
        throw new Exception('Функция ожидает приёма массива. Метод класса: '.__METHOD__);
    if (!count($array))
        throw new Exception('Массив должен быть непустой');

    if (empty($array['id']))
        throw new Exception('Не задан ID варианта. Метод класса: '.__METHOD__);
        
    if (empty($array['name']))
        $array['name'] = '';
    if (empty($array['num']))
        $array['num'] = 0;
    if (empty($array['order']))
        $array['order'] = 100;
        
    $q = 'UPDATE `voting_variant`
          SET   `name`="'.mysql_real_escape_string($array['name']).'",
                `num`='.(int)$array['num'].',
                `order`='.(int)$array['order'].'
          WHERE `id`='.$array['id'].' LIMIT 1';
    if (!mysql_query($q))
        throw new Exception('Ошибка в запросе на обновление данных о варианте голосования. Метод класса: '.__METHOD__);
     return true;
    
}
public function deleteVariant($id)
{
    $q = 'DELETE FROM `voting_variant` WHERE `id`='.$id.' LIMIT 1';
    if (!mysql_query($q))
       throw new Exception('Ошибка удаления варианта ответа. Метод класса: '.__METHOD__);
    
}
public function getVariants()
{
    $this->test_question();
    $q = 'SELECT * FROM `voting_variant` WHERE `question_id`='.$this->questionId.' ORDER BY `num` DESC';
    $res = mysql_query($q);
    if (!mysql_query($q))
       throw new Exception('Ошибка получения списка вариантов ответов. Метод класса: '.__METHOD__);
    if (!mysql_num_rows($res))
        return 0;
    while ($row = mysql_fetch_assoc($res))    
        $array[] = $row;
    return $array;
}

public function getQuestions()
{
    $q = 'SELECT * FROM `voting_question` WHERE `active` > 0 ORDER BY `id` DESC';
    $res = mysql_query($q);
    if (!mysql_query($q))
       throw new Exception('Ошибка получения списка вариантов ответов. Метод класса: '.__METHOD__);
    if (!mysql_num_rows($res))
        return 0;
    while ($row = mysql_fetch_assoc($res))    
        $array[] = $row;
    return $array;
}

/**
 * Сделано голосование
 * Увеличивает на 1 один вариант ответа
 * Принимает код варианта:
 * ID вопроса доложен быть уже задан
 * 
  * @param unknown_type $num
 */
public function vote($num)
{
    $this->test_question();
    $q = 'UPDATE `voting_variant`
          SET   `num`=`num` + 1
          WHERE `id`='.(int)$num.' LIMIT 1';
    if (!mysql_query($q))
        throw new Exception('Ошибка. Метод класса: '.__METHOD__);
     return true;
}

public function getQuestion($str = '')
{
    if (trim($str))
        $str = 'AND `id` NOT IN ('.$str.')';
        
    $q = 'SELECT COUNT(*) as "num" FROM `voting_question`
          WHERE `active` > 0
            AND `time_begin` < NOW()
            AND `time_end` > NOW()
            '.$str;
    $res = mysql_query($q);
    $t = mysql_fetch_assoc($res);
    if ($t['num'])
    {
        $q = 'SELECT `id`,`name` FROM `voting_question`
            WHERE `active` > 0
                AND `time_begin` < NOW()
                AND `time_end` > NOW()
                '.$str.'
                ORDER BY `id` DESC
                LIMIT 1
                ';
        $res = mysql_query($q);
        if (!$res)
            throw new Exception('Ошибка в запросе. Метод класса: '.__METHOD__);
        $t2 = mysql_fetch_assoc($res);
        $this->setQuestion($t2['id']);
        $t2['vote'] = true;
        return $t2;
    }
    else
    {
        $q = 'SELECT `id`,`name` FROM `voting_question`
              WHERE `active` > 0
                AND `time_begin` < NOW()
                ORDER BY `id` DESC
                LIMIT 1
                ';
        $res = mysql_query($q);
        if (!$res)
            throw new Exception('Ошибка в запросе. Метод класса: '.__METHOD__);
        
        if (mysql_num_rows($res))  
        {
            $t2 = mysql_fetch_assoc($res);
            $this->setQuestion($t2['id']);
            $t2['vote'] = false;
        }
        else 
            $t2 = false;
        return $t2;
    }
}


}