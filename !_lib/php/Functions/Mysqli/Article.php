<?php
/**
 * ����������� ������� ��� ������ � ��������� ������ � ��
 *  
 * ������������ ������:
 *    Dune_MysqliSystem
 *    Dune_Data_Container_UserFriendlyUrl
 * 
 */

abstract class Functions_Mysqli_Article
{
    /**
     * ��� ������� ������.
     * 
     * @var string
     */
    public static $tableNameArticle = 'dune_article_body';
    
    /**
     * ��� ������� �������� ������.
     * 
     * @var string
     */
    public static $tableNameSection = 'dune_article_section';

    /**
     * ��� ������� ������������ ������ ��������.
     * 
     * @var string
     */
    public static $tableNameCorrespondence = 'dune_article_section_corr';

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
    protected static $_alloyArrayToSave = array('name', 'url', 'activity', 'time', 'notice', 'array_body', 'id');
    
    /**
     * ������ SET ��� �������
     * 
     * @var string
     * @access private
     */
    protected static $_querySetString = '';
    
    protected $unserializationBody = false;
    protected $unserializationNotice = false;
    
    
////////////////////////////////////////////////////////////////////////////////////////
/////////////////       �������� ������    
///////////////////////////////////////////////////////////////////////////////////////
    /**
     * ���������� ���� ������ �� ������� ������. ���������� � �������� ����� id.
     *
     * @param inreger $id
     * @param boolean $unserialization_body ���� �������������� ����������� ��������
     * @param boolean $unserialization_notice ���� �������������� ��������� �������� ��������
     * @return mixed ������ ��� ������, false ��� ������� 
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
            throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
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
    public static function getArticleList($section = 0, $activity = 2, $shift = 0, $limit = 10, $order = 'asc')
    {
        $order = strtoupper($order);
        if (($order != 'ASC') or ($order != 'DESC'))
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
            throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
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
     * ������� ������ ������ ��� ��������� ���������� (���� array). ���������� ��� ����, ����� hash16.
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
    public static function getArticleListBriefly($section = 0, $activity = 2, $shift = 0, $limit = 10, $order = 'asc')
    {
        $order = strtoupper($order);
        if (($order != 'ASC') or ($order != 'DESC'))
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
            throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
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
     * ����������� ����� ��� � ������� ������.
     * ���������� ����� � ���������� ���������� �����.
     * 
     * 
     *
     * @param array $array ������ �������� � �������� ����������� (������������)
     * @return boolean true ��� �������� ����������.
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
     * ��������� ��������� ��� ������.
     * ��������� � ���� � ��������� ������ id � �������
     * 
     *
     * @param array $array ������ ��������
     * @return boolean true ��� �������� ����������.
     */
    public static function saveArticle($array = array())
    {
        if (!isset($array['id']))
            throw new Dune_Exception_Base('����������� ������������ ���� � ������� ��� ���������� ������: id');
        $id = (integer)$array['id'];
        self::_getDB();
        self::$_arrayToSave = $array;
        self::_makeSetArticleString();
        $query = 'UPDATE ' . self::$tableNameArticle . self::$_querySetString . ' WHERE id = ' . $id;
        return self::$_DB->query($query);
        //return true;
    }
    
    /**
     * ���������� ����������� ������ ��������.
     * ��� ������ �������� ��������� $array ��������� ��� ������������ ��� ������.
     *
     * @param integer $id ������������� ������
     * @param array $array ������ ��������������� �������� � �������� ��������� ������
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
     * ���������� ����� ������
     * �����, � ����������� �� ��������� $activity
     * 0 - ����������
     * 1 - ��������
     * ����� ������ ����� - ����
     *
     * @param integer $activity
     * @return mixed ����� ������
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
     * ���������� ����� ����������� � �������
     * �����, � ����������� �� ��������� $activity
     * 0 - ����������
     * 1 - ��������
     * ����� ������ ����� - ����
     *
     * @param integer $section ����� �������
     * @param integer $activity
     * @return mixed ����� ������
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
    protected static function _makeSetArticleString()
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
       	            throw new Dune_Exception_Base('� ������� ��� ���������� �������� ���� ������� ' . self::$tableNameArticle . ' ����� ���� ������ 2 �������.');
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
       			$set_str.= ' SET `'.$r_rey.'`="'.mysql_real_escape_string($contents).'"';
       		else
       			$set_str.= ', `'.$r_rey.'`="'.mysql_real_escape_string($contents).'"';
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