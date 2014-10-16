<?php
 /**
 *  ����� ��� ����������� ������ � �������� � ����������� ����������
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
 * | � ����������: Dune/Include/SubFolder.php          |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.12                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * ������� ������:
 * -----------------
 * 
 *  1.12 (2008 ������� 24)
 *  ��� ����� ������������ �������� ��� ������� - ��������� ����������.
 * 
 *  1.10 -> 1.11
 *  ����� ������������� ������ ����������� � �������� ������� getOutput � getResult ��� ���������� ������������� ���������.
 * 
 *  1.02 -> 1.10
 *  �������� ������ � ������������� ����������� � ������������ �����.
 * 
 *  1.01 -> 1.02
 *  ���������� � ����� � ������������ ����� ���������� � ����������� �����.
 * 
 * 
 * 1.01 -> 1.02
 * ���������� ����� ����������, ��������, ������� � ������������ �����
 * 
 * 1.00 -> 1.01
 * ��������� � ������ getResult. �� ��������� �� ���������� ���������� ���� ��� ����� ��� ������.
 * ����� ������������ falses.
 * 
 */

class Dune_Include_Folder extends Dune_Include_Parent_Command
{

    
    /**
     * ������ ���� � ����� ������
     *
     * @var string
     * @access private
     */
    protected $folderPath = '';
    
    
/////////////////////////////////////////////////////////////////////////
    
    /**
     * ����������� ������ ���������� ������. ���������� ������������� ���� ��� �������� �������.
     * make() �� ������������.
     *
     * @param Dune_Data_Container_Folder $folder
     */
    public function __construct(Dune_Data_Container_Folder $folder, $access = 0)
    {
        
        $this->folderPath = $folder->getPath() . '/' . $folder->getFolder();
        
        $this->fullPath = $this->folderPath . '/' . $folder->getMainFile();
                                
         if ($folder->getFolderAccessLevel() > $access)
         {
             $this->status = self::STATUS_NOACCESS;
         }
         else 
         {
             if (file_exists($this->fullPath))         	
             {
             	 $this->existence = true;
	             $this->____parameters = $folder->getFolderParameters();
	
	             $_folder = $this->folderPath;
	             
	             ob_start();
	             include($this->fullPath);
	             $this->buffer = ob_get_clean();
             }
         }
    }
    
	/**
	 * � ������� �� ������ �������� ���������� ���� ������������� ������������� ����. ������ ������ �� ������.
	 *
	 * @return boolean true - ���� ���� ����������, false - �����
	 */
    public function make()
    {
        return $this->existence;
    }
    
    
}