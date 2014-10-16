<?php
/**
 * ����������� �����. ������ - ������� ��� ������ �������.
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Factory.php                                 |
 * | � ����������: Dune/Factory.php                    |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.01                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 */
class Dune_Factory
{
    static $moduleClassFolder = 'default';
    
    /**
     * 
     *
     * @param string $name
     * @return Dune_Include_Abstract_Code
     */
    static function getModule($name)
    {
        return new $name;
    }
    
    
    
    
/////////////////////
////////////////////            ���������� �� �����  - � ������� - �������.
////////////////////    
    /**
     * ������ �������� ��������� �� ��������� �������� �������.
     * ����� - ����� �������. 
     * ����� �������������� ����������� - ��� �������� ���������� ����������� ������ ������
     *
     * @var array
     */
    static $objectArray = array();
    /**
     * ����� ���������� ��������� �� �����.
     * �������� ������ ����������� � ������ ���������
     * 
     * ���� ����� ������ ���������� ������ ��� ������ - ����������� ��� ��������� (������ �� ��������)
     * 
     * ��������� ��������� ���������� ������������ ������������ �������
     * ������������ ���� ���������� - 6 (������� ��� ������)
     * 
     * � �������� 1-�� ��������� ����� ���� ������� ������, ������ ������� �������� (���� 0) - ��� ������
     *                                                      ������ (���� 1) - ����������� ����� � ������� $objectArray
     * ��� ��������� ������� ��������� �������� � ������������ �� ����� ����������
     * 
     * @return ��������� �� ������
     */
    static function singleObjectConstruct()
    {
        $numargs = func_num_args();
        if (!$numargs OR ($numargs > 6))
            throw new Exception('������� �������� ����� ����������. ���������� �� ����� 6-�� � �� ����� 1-��');
        $args  = func_get_args();
        // ���� ������� ������ - �������� �������� ���������� ������� ��� ���������� ������ � ������������� ���������
        // ����������� - ������, ������������ � ����� ������
        if (is_array($args[0]))
        {
            $className = $args[0][0];
            $classKey = $args[0][0].$args[0][1];
        }
        else 
        {
            $className = $classKey = $args[0];
        }
        if (key_exists($classKey,self::$objectArray))
            return self::$objectArray[$classKey];
        // ������� ������ ����� ���������� - ����� �� ������ ������ - ����������
        switch ($numargs)
        {
            case 1:
                $object = new $className();
            break;
            case 2:
                $object = new $className($args[1]);
            break;
            case 3:
                $object = new $className($args[1],$args[2]);
            break;
            case 4:
                $object = new $className($args[1],$args[2],$args[3]);
            break;
            case 5:
                $object = new $className($args[1],$args[2],$args[3],$args[4]);
            break;                                                
            case 6:
                $object = new $className($args[1],$args[2],$args[3],$args[4],$args[5]);
            break;                                                
        }
        self::$objectArray[$classKey] = $object;
        return self::$objectArray[$classKey];
    }
    
    static function singleObjectDestruct()
    {
        $numargs = func_num_args();
        if (!$numargs OR ($numargs > 2))
            throw new Exception('������� �������� ����� ����������. ���������� �� ����� 2-� � �� ����� 1-��');
        $args  = func_get_args();
        // ���� ������� ������ - �������� �������� ���������� ������� ��� ���������� ������ � ������������� ���������
        // ����������� - ������, ������������ � ����� ������
        if (is_array($args[0]))
        {
            $className = $args[0][0];
            $classKey = $args[0][0].$args[0][1];
        }
        else 
        {
            $className = $classKey = $args[0];
        }
        if (key_exists($classKey,self::$objectArray))
        {
            self::$objectArray[$classKey]->__destruct();
            unset(self::$objectArray[$classKey]);
            return true;
        }
        else 
        {
            if ($numargs > 1)
            {
                throw new Exception('���������� ��������� ������. ��� ������: '.$className.', ��� ����� ��� ������: '.$classKey);
            }
            else 
            {
                return false;
            }
        }
    }
}