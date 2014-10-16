<?php
/**
 * Dune Framework
 * 
 * ����������� �����.
 * ������� �������������� ������ �� ������ misqli
 * 
 * --------------------------------------------------------
 * | ����������: Dune                                      |
 * | ����: Connect.php                                     |
 * | � ����������: Dune/Mysqli/Abstract/Connect.php        |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>             |
 * | ������: 0.91                                          |
 * | ����: www.rznw.ru                                     |
 * --------------------------------------------------------
 *
 * ������� ������:
 * 
 * ������ 0.91 (2008 ������ 08)
 *  ������� ��������������.
 * 
 */
abstract class Dune_Mysqli_Abstract_Connect
{
    /**
     * ��������� �� �����
     *
     * @var Dune_MysqliSystem
     * @access private
     */
    protected $_DB = null;
    
    /**
     * ������������� ��������� �� ������ mysqli
     *
     * @access private
     * @return Dune_MysqliSystem
     */
    final protected function _initDB()
    {
        if ($this->_DB == null)
            $this->_DB = Dune_MysqliSystem::getInstance();
        return $this;
    }
    


}