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
 * | ����: SubCommand.php                              |
 * | � ����������: Dune/Include/SubCommand.php         |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 1.05                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 * 
 * ������� ������:
 * -----------------
 * 
 * 1.04 -> 1.05
 * ����� ������������� ������ ����������� � �������� ������� getOutput � getResult ��� ���������� ������������� ���������.
 *
 * 1.03 -> 1.04
 * ���������� ����� ����������, ��������, ������� � ������������ �����
 * 
 * 1.02 -> 1.03
 * ��������� � ������ getResult. �� ��������� �� ���������� ���������� ���� ��� ����� ��� ������.
 * ����� ������������ falses.
 * 
 * 1.01 -> 1.02
 * � ����� ����������� ����� ��������� ���������� $_folder - ������ ��� ����� � ���������� ������
 * 
 * 1.00 -> 1.01
 * ������� ������������� �������� ���������� �� ������ Dune_Data_Container_SubCommand
 * 
 */

class Dune_Include_SubCommand extends Dune_Include_Parent_Command
{
    
    /**
     * ������ ���� � ����� ������
     *
     * @var string
     * @access private
     */
    protected $commandFullPath = '';

    /**
     * ������ ���� � ����� �������
     *
     * @var string
     * @access private
     */
    protected $commandPath = '';
    
    

/////////////////////////////////////////////////////////////////////////
    
    /**
     * ����������� ������ ���������� ������
     *
     * @param Dune_Data_Container_SubCommand $command
     */
    public function __construct(Dune_Data_Container_SubCommand $command, $access = 0)
    {
        // ���� ���������, ������������ �� ������
        $message_code = array();
        // ������ ��������� ������������ �� ������
        $message_text = array();
        // ���������� ���������� �������
        $results = array();

        
        $this->commandPath = Dune_Parameters::$subCommandPath . '/' 
        				   . Dune_Data_Container_SubCommand::$commandSpace . '/' 
        				   . $command->getCommandFolder() . '/' 
        				   . $command->getCommand();
        
        $this->commandFullPath = $this->commandPath . '/subcommand.php';
                                
         if ($command->getCommandAccessLevel() > $access)
         {
             $this->status = self::STATUS_NOACCESS;
         }
         else if (file_exists($this->commandFullPath))
         {
             $this->existence = true;
             //if (self::$isExeption)
             //  throw new Dune_Exception_Base('��� ���������� ������');
                
             $this->parameters = $command->getCommandParameters();
             $_folder = $this->commandPath;
             
             ob_start();
             include($this->commandFullPath);
             $this->buffer = ob_get_clean();
                 
         }
    }
    
	/**
	 * � ������� �� ������ �������� ���������� ���� ������������� ������������� ����. ������ ������ �� ������.
	 *
	 * @return boolean true - ���� ���� ����������, false - �����
	 */
    public function make()
    {
    	if ($this->existence = true)
    	{
			return true;    		
    	}
    	else 
    		return false;
    }
    
    
}