<?
/**
 * ����� - ����������� ������� �������� ����-���� � �������� ���� ������ Mysql
 * 
 *
 * ��������� ������:
 * Dune_MysqliSystem
 *  
 *	 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Check.php                                   |
 * | � ����������: Dune/Mysqli/Check.php               |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.01                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * ������:
 * 
 * 1.01 (2008 ������ 07)
 *  �� ������������ ����������� �������������� ������.
 * 
 */

abstract class Dune_Mysqli_Check
{
    static protected $DB = null;
    
    /**
     * �������� ������������� ����� ������������� � �������
     *
     * @param Dune_Data_Container_UserName $object ������-��������� ����� ������������
     * @param string $tableName ��� �������
     * @param string $fieldName ��� ���� �������, ��� ����������� ��� ������������
     * @return boolean
     */
    static public function existenceUserName(Dune_Data_Container_UserName $object, $tableName, $fieldName = 'name')
    {
        $result = false;
        
        // ���� ��������� �� ������ ���������� � �� ��� �� �������� - ���������
        if (self::$DB == null)
            self::$DB = Dune_MysqliSystem::getInstance();
            
        // ��������� ���������� ������
        $query = 'SELECT count(*) FROM `'.$tableName.'`
                  WHERE `' . $fieldName . '` LIKE ?
                         OR
                        `' . $fieldName . '` LIKE ?
                         OR
                        `' . $fieldName . '` LIKE ?
                         LIMIT 1';

        
        // ���� ���-�� ������� - ��� ������������ �� ���������
        if(self::$DB->query($query, array($object['original'], $object['english'], $object['russian']), Dune_MysqliSystem::RESULT_EL) > 0) 
        {
            $result = true;
        }

        return $result;     
        
        
        
        
        
        
        
        
    }
}