<?php
/**
 * ����������� ������� ��� ������ � ��������� ������ � ��
 *  
 * ������������ ������:
 *    Dune_MysqliSystem
 *    Dune_Data_Container_UserFriendlyUrl
 * 
 */

abstract class Functions_Mysqli_Page
{
    /**
     * ��� ������� ������.
     * 
     * @var string
     */
    public static $tableName = 'dune_page';
    
    /**
     * ��� ������� �������� ������.
     * 
     * @var string
     */
    public static $tableNameSection = 'dune_page_section';

    /**
     * ��� ������� ������������ ������ ��������.
     * 
     * @var string
     */
    public static $tableNameCorrespondence = 'dune_page_section_corr';

    /**
     * ��������� �� ������ - ���������� � ����� ������.
     * 
     * @var string
     * @access private
     */
    protected static $_DB = null;
    
    /**
     * ������ ��� ���������� � ����
     * 
     * @var array
     * @access private
     */
    protected static $_arrayToSave = array();

    /**
     * ������ ����������� ������ � ������� ��� ����������.
     * 
     * @var array
     * @access private
     */
    protected static $_alloyArrayToSave = array('name', 'url', 'activity', 'time', 'notice', 'array_body', 'id', 'order');
    
    /**
     * ������ SET ��� �������
     * 
     * @var string
     * @access private
     */
    protected static $_querySetString = '';
    
    protected static $_limitString = '';
    
    
    protected static $unserializationBody = false;
    protected static $unserializationNotice = false;
    
    
////////////////////////////////////////////////////////////////////////////////////////
/////////////////       �������� ������    
///////////////////////////////////////////////////////////////////////////////////////
    /**
     * ���������� ���� ������ �� ������� ������. ���������� � �������� ����� id.
     *
     * @param inreger $id
     * @return mixed ������ ��� ������, false ��� ������� 
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
            throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
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
     * ������� ������ ������. ���������� ��� ����, ����� hash16.
     *
     * ������ ������ ������������ ���������� $activity
     * 0 - ����������
     * 1 - ��������
     * ����� ������ ����� - ����

     * 
     * @param integer $section ��� �������. ����, ���� �� ���������.
     * @param integer $activity 0, 1 ��� ����� ���� �� ��������� ����������
     * @param integer $shift ����� � �������
     * @param integer $limit ����� ����� ��� �������
     * @param string $order ������� ����������: ASC ��� DESC (����� ����������)
     * @return mixed 
     */
    public static function getList($section = 0, $activity = 2, $order = 'ASC')
    {
        $order = strtoupper($order);
        if (($order != 'ASC') and ($order != 'DESC'))
            throw new Dune_Exception_Base('�������� ��������: '. $order .' �������� ����������� ���������� �������');
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
            throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
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
     * ������� ������ ������ ��� ��������� ���������� (���� array). ���������� ��� ����, ����� hash16.
     *
     * ������ ������ ������������ ���������� $activity
     * 0 - ����������
     * 1 - ��������
     * ����� ������ ����� - ����

     * 
     * @param integer $section ��� �������. ����, ���� �� ���������.
     * @param integer $activity 0, 1 ��� ����� ���� �� ��������� ����������
     * @param string $order ������� ����������: ASC ��� DESC (����� ����������)
     * @return mixed 
     */
    public static function getListBriefly($section = 0, $activity = 2, $order = 'asc')
    {
        $order = strtoupper($order);
        if (($order != 'ASC') and ($order != 'DESC'))
            throw new Dune_Exception_Base('�������� ��������: '. $order .' �������� ����������� ���������� �������');
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
            throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
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
     * ����������� ����� ��� � ������� ������.
     * ���������� ����� � ���������� ���������� �����.
     * 
     * 
     *
     * @param array $array ������ �������� � �������� ����������� (������������)
     * @return boolean true ��� �������� ����������.
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
            throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
        $stmt->close();
        
        $query = 'DELETE FROM ' . self::$tableNameCorrespondence . ' WHERE article_id = ?';
        $stmt = self::$_DB->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
        $stmt->close();
        return true;
    }
    
    
    /**
     * ��������� ��������� ��� ������.
     * ��������� � ���� � ��������� ������ id � �������
     * 
     *
     * @param array $array ������ ��������
     * @return boolean true ��� �������� ����������.
     */
    public static function save($array = array())
    {
        if (!isset($array['id']))
            throw new Dune_Exception_Base('����������� ������������ ���� � ������� ��� ���������� ������: id');
        $id = (integer)$array['id'];
        self::_getDB();
        self::$_arrayToSave = $array;
        self::_makeSetString();
        $query = 'UPDATE ' . self::$tableName . self::$_querySetString . ' WHERE id = ' . $id;
        
        return self::$_DB->query($query);
        //return true;
    }
    
    

    
    /**
     * ���������� ����� ������
     * �����, � ����������� �� ��������� $activity
     * 0 - ����������
     * 1 - ��������
     * ����� ������ ����� - ����
     *
     * @param integer $activity
     * @return mixed ����� ������
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
            throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
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
     * ���������� ����� ������ � �������
     * �����, � ����������� �� ��������� $activity
     * 0 - ����������
     * 1 - ��������
     * ����� ������ ����� - ����
     *
     * @param integer $section ����� �������
     * @param integer $activity
     * @return mixed ����� ������
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
            throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
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
            throw new Dune_Exception_Base('������ � �������� ��������������� �������: <strong>' . $query . '</strong>');
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
            throw new Dune_Exception_Base('������ � �������� ��������������� �������: <strong>' . $query . '</strong>');
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
            throw new Dune_Exception_Base('������ � �������� ��������������� �������: <strong>' . $query . '</strong>');
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
            throw new Dune_Exception_Base('������ � �������� ��������������� �������: <strong>' . $query . '</strong>');
        foreach ($array as $run)
        {
            $stmt->bind_param('ii', $run['article_id'], $run['section_id']);            
            $stmt->execute();
        }
        $stmt->close();
        return $result;
    }
    
    
    
////////////////////////////////////////////////////////////////////////////////////////
/////////////////       �������� ������    
///////////////////////////////////////////////////////////////////////////////////////

    /**
     * �������� ������ ��� ���������� � ����.
     * ��� �� ������� hash16 ������� ���� id �� �������.
     * ����������� ���������. ������� ������ ���� ������ ����.
     * 
     * @access private
     */
    protected static function _makeSetString()
    {
        // ���� �� ����� url � ����� name
        if ((!key_exists('url', self::$_arrayToSave) or (self::$_arrayToSave['url'] == '')) and
            (key_exists('name', self::$_arrayToSave)))
        {
            // ������� name ��� ��������� url � hash16
            $object = new Dune_Data_Container_UserFriendlyUrl(self::$_arrayToSave['name']);
            // ���� ������� ������������
            if ($object->getUrl() != '')
            {
                self::$_arrayToSave['url'] = $object->getUrl();
            }
        }
        // ���� ����� url
        else if (key_exists('url', self::$_arrayToSave) and (self::$_arrayToSave['url'] != ''))
        {
            $object = new Dune_Data_Container_UserFriendlyUrl();
            $object->useUrl(strtolower(self::$_arrayToSave['url']));
            self::$_arrayToSave['url'] = $object->getUrl();
            
        }
        else 
        {
            // hash16 �� ���������
            self::$_arrayToSave['url'] = 'article';
        }
        // �������� ���� - ����� �� �����
        unset(self::$_arrayToSave['id']);
        
       	$find_one = 0;
       	// ��� �������� � ���������� ������� ����� ���� �������� - �� �����������
       	// ����������� ����� ��� ������ 2 - ����� ����������
       	foreach (self::$_arrayToSave as $r_rey => $contents)
       	{
       	    if (!in_array($r_rey, self::$_alloyArrayToSave))
       	    {
                throw new Dune_Exception_Base('������������ ���� � ������� ��� ���������� ������: ' . $r_rey);
       	        
       	    }
       	        
       	    if (is_array($contents))
       	    {
       	        if ($find_one == 2)
       	        {
       	            throw new Dune_Exception_Base('� ������� ��� ���������� �������� ���� ������� ' . self::$tableName . ' ����� ���� ������ 2 �������.');
       	        }
       	        self::$_arrayToSave[$r_rey] = serialize(self::$_arrayToSave[$r_rey]);
       	        $find_one += 1;
       	    }
       	}       
       	// ������ ������ SET
       	// ����� url ���� � ����� ������	
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
     * �������� ��������� �� ������ - ���������� � ����� ������.
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