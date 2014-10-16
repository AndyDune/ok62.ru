<?php
/**
 * ����������� ������� ��� ������ � ��������� ����������� ������� � ��
 *  
 * ������������ ������:
 *    Dune_MysqliSystem
 * 
 */

abstract class Functions_Mysqli_AllayDomains
{
    
    /**
     * ��������� �� ������ - ���������� � ����� ������.
     * 
     * @var string
     * @access private
     */
    protected static $_DB = null;
    
    /**
     * ��� ������� �������.
     * 
     * @var string
     */
    public static $tableNameAllayDomains = 'dune_mail_alloy_domain';
    

////////////////////////////////////////////////////////////////////////////////////////
/////////////////       �������� ������    
///////////////////////////////////////////////////////////////////////////////////////



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
    public static function getList($order = 'ASC')
    {
        $order = strtoupper($order);
        if (($order != 'ASC') and ($order != 'DESC'))
            throw new Dune_Exception_Base('�������� ��������: '. $order .' �������� ����������� ���������� �������');
        $result = false;
        self::_getDB();
            $query = 'SELECT id,
                             domain
                      FROM    ' . self::$tableNameAllayDomains . ' 
                      ORDER BY domain '. $order;
        
       
        $stmt = self::$_DB->prepare($query);
            
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
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
     * ����������� ����� ��� � ������� �������.
     *
     * @param string $domain
     * @return boolean true ��� �������� ����������.
     */
    public static function add($domain)
    {
        self::_getDB();

        $query = 'INSERT INTO ' . self::$tableNameAllayDomains . ' SET domain = ?';
        $stmt = self::$_DB->prepare($query);
        $stmt->bind_param('s', $domain);
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
        $stmt->close();
        return true;
    }
    
    /**
     * ������� ��� �� ������� �������.
     *
     * @param integer $id
     * @return boolean true ��� �������� ����������.
     */
    public static function delete($id)
    {
        self::_getDB();

        $query = 'DELETE FROM ' . self::$tableNameAllayDomains . ' WHERE id = ?';
        $stmt = self::$_DB->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        if ($stmt->errno)
            throw new Dune_Exception_Mysqli("������ � ���������� �������: ".$stmt->error);
        $stmt->close();
        return true;
    }
    
   
    /**
     * ���������� ����� �������
     *
     * @return mixed ����� ������
     */
    public static function count()
    {
        $result = false;
        self::_getDB();
        $query = 'SELECT count(id) FROM ' . self::$tableNameAllayDomains;
        
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

    
////////////////////////////////////////////////////////////////////////////////////////
/////////////////       �������� ������    
///////////////////////////////////////////////////////////////////////////////////////


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