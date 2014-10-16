<?
/**
 * ������ � ������ ������������ �������.
 * 
 *
 * ��������� ������:
 * Dune_MysqliSystem
 *  
 *	 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Table.php                                   |
 * | � ����������: Dune/Mysqli/Table.php               |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 0.92                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * ������:
 * 
 * 0.92 (2008 ������ 17)
 * ����� ����� useKey($key, $value)
 * 
 * 0.90 (2008 ������ 16)
 * ��������� ������:
 * getData(), delete(), add(), save()
 * 
 * 0.90 (2008 ������ 08)
 *  �������� �������. �������� � �������� ���������� ����� ������ ������������� � ���������������.
 * 
 * 0.91 (2008 ������ 16)
 * 
 */

class Dune_Mysqli_Table extends Dune_Mysqli_Abstract_SetDataControl
{
    protected $_table;
    
    protected $_id = null;
    protected $_have = false;
    protected $_data = array();    
    
    public function __construct($table)
    {
        $this->_initDB();
        $this->_table = $table;
        $this->_parseStructure($table);
    }
    
    
    public function useId($value)
    {
        switch ($this->_keyFieldType)
        {
            case 'i':
                $this->_id = (int)$value;
            break;
            case 'f':
                $this->_id = (float)$value;
            break;
            default:
                $this->_id = '"' . $this->_DB->real_escape_string($value) . '"';
        }
        $this->_id = $value;
        $this->_fromDb();
        return $this;
    }

    /**
     * ��� ������� � ������ ������������ ��������� ���� � ��� ��������.
     *
     * @param string $key
     * @param mixed $value
     * @return Dune_Mysqli_Table
     */
    public function useKey($key, $value)
    {
        if (!key_exists($key, $this->_allowFields))
            throw new Dune_Exception_Base('��� ����� � �������');
        switch ($this->_allowFields[$key][0])
        {
            case 'i':
                $value = (int)$value;
            break;
            case 'f':
                $value = (float)$value;
            break;
            default:
                $value = '"' . $this->_DB->real_escape_string($value) . '"';
        }
        $this->_fromDbKey($key, $value);
        return $this;
    }
    
    
    public function getData($container = false)
    {
        if (count($this->_data))
        {
            if ($container)
                return new Dune_Array_Container($this->_data);
            else 
                return $this->_data;
        }
        return false;
    }
    
    public function delete()
    {
        if (is_null($this->_id))
        {
            throw new Dune_Exception_Base('�� ���������� ���� ��� ������� � ����� ������ ��� ��������');
        }
        $q = 'DELETE FROM `' . $this->_table .  '` WHERE ' . $this->_keyField .' = ' . $this->_id . ' LIMIT 1';
        return $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_AR);
    }

    
    public function add()
    {
        $set = $this->_collectDataToSave();
        if ($set)
            $set = ' SET ' . $set;
         
        $q = 'INSERT INTO `' . $this->_table .  '` ' . $set;
        return $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_ID);
    }
    
    public function save()
    {
        if (is_null($this->_id))
        {
            throw new Dune_Exception_Base('�� ���������� ���� ��� ������� � ����� ������ ��� ��������������');
        }
        $set = $this->_collectDataToSave();
        if (!$set)
            return false;
        $q = 'UPDATE `' . $this->_table . '` SET ' . $set . ' WHERE ' . $this->_keyField . ' = ' . $this->_id . ' LIMIT 1';
        return $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_AR);
    }
    
    protected function _fromDb()
    {
        $q = 'SELECT * FROM `' . $this->_table . '` WHERE ' . $this->_keyField . ' = ' . $this->_id . ' LIMIT 1';
        $data = $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_ROWASSOC);
        if ($data and count($data) > 0)
        {
            $this->_have = true;
            $this->_data = $data;
            //$this->_data = $this->_dataToSave = $data;
            //unset($this->_dataToSave[$this->_keyField]);
        }
        else 
            $this->_have = false;
    }

    protected function _fromDbKey($key, $value)
    {
        $q = 'SELECT * FROM `' . $this->_table . '` WHERE ' . $key . ' = ' . $value . ' LIMIT 1';
        $data = $this->_DB->query($q, null, Dune_MysqliSystem::RESULT_ROWASSOC);
        if ($data and count($data) > 0)
        {
            $this->_have = true;
            $this->_data = $data;
            //$this->_data = $this->_dataToSave = $data;
            //unset($this->_dataToSave[$this->_keyField]);
        }
        else 
            $this->_have = false;
    }
    
    
}