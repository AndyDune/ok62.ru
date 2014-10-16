<?php
 /**
 *  ���������� ������������� ������� ������������ � ������� �����
 *
 * 
 * ������ ������ ������������ ��������� ������� ��� ��������� �������� ������
 *    $massage_code = array() - ���� ���������
 *    $massage_text = array() - ������ ����� ���������
 *    $results = array() - ����������
 * 
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: SubFolder.php                               |
 * | � ����������: Dune/Include/Operation.php          |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.03                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * ������� ������:
 * -----------------
 * 
 * 1.03 (2008 ������� 24)
 * ��� ����� ������������ �������� ��� ������� - ��������� ����������.
 *
 * ����� ������������� ������ ����������� � �������� ������� getOutput � getResult ��� ���������� ������������� ���������.
 * 
 * 1.00 -> 1.01
 * ���������� ������ ���������� � ��������.
 * ���������� parameters ���������� � ��������.
 * 
 */

class Dune_Include_Operation extends Dune_Include_Parent_Command
{

    

    /**
     * ������ ���� � ����� ������
     *
     * @var string
     * @access private
     */
    protected $folderPath = '';

    
    static $operationsFolder = '';
    static $mainFile = 'index.php';
    
/////////////////////////////////////////////////////////////////////////
    
    /**
     * ����������� ������ ���������� ������
     *
     * @param string $current_folder ������� �����, �� ������� ���������� ��������
     */
    public function __construct($operation, $current_folder, $parameters = false)
    {
        // ���� ���������, ������������ �� ������
        $this->messageCode = array();
        // ������ ��������� ������������ �� ������
        $this->messageText = array();
        // ���������� ���������� �������
        $this->results = array();
        
        $this->____parameters = $parameters;
        
        $this->folderPath = $current_folder;
        
        if (self::$operationsFolder)
	        $this->folderPath .= '/' . self::$operationsFolder;
        
        $this->fullPath = $this->folderPath . '/' . $operation .'/' . self::$mainFile;
                                
         if (file_exists($this->fullPath))
         {
             $this->existence = true;
         }
//         else 
         	//throw new Dune_Exeption_Base('��� ������������� �����: ' . $this->folderFullPath);
    }
 
    
}

