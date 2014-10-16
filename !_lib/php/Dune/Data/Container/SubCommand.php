<?
/**
 * �����-��������� ���������� �����������.
 * ������������ � ����� ����� ������� ��� ������������ �������.
 * 
 *	 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: SubCommand.php                              |
 * | � ����������: Dune/Data/Container/SubCommand.php  |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 1.01                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 * 
 * ������� ������:
 * -----------------
 * 
 * 1.00 -> 1.01
 * ������� ������� ������������ ������� - ��������� ����������, �������� ���� � ������ ����������.
 * ����� �������� ��� ������������ ����� ����������������
 * 
 */

class Dune_Data_Container_SubCommand
{
    /**
     * �������
     *
     * @var string
     * @access private
     */
    protected $command;

    /**
     * ������ ��������
     *
     * @var string
     * @access private
     */
    protected $commandStatus;
    
    /**
     * ������� �� ���������.
     * ��������������� ���� ���������� ��� � ������ ����������
     *
     * @var string
     * @access private
     */
    protected $commandDefault;
    
    /**
     * ������ ������� �� ���������.
     * ��������������� ���� ���������� ��� � ������ ����������
     *
     * @var integer
     * @access private
     */
    protected $commandDefaultStatus;
    /**
     * ���� ����������� ������� �� ���������
     * 
     * @var boolean
     * @access private
     */
    protected $commandDefaultRegistered = false;
    
    
    /**
     * ������ ���������� �������
     *
     * @var array
     * @access private
     */
    protected $alloyCommands = array();  

    /**
     * ������ �������� ���������� �������
     *
     * @var array
     * @access private
     */
    protected $alloyCommandsStatus = array();
    
    /**
     * ���� ����������� ���������� ������
     * 
     * @var boolean
     * @access private
     */
    protected $alloyCommandRegistered = false;
    
    /**
     * ������ �������������� ���������� �������
     *
     * @var array
     * @access private
     */
    protected $parameters = array();

    /**
     * ���� � ����� ����� � �������� ����� ������.
     * ���������� ������ ������� � ������� ��������.
     *
     * @var string
     * @access private
     */
    protected $commandFolder = 'default';

    /**
     * ���������� ������������ �������
     *
     * @var string
     */
    static public $commandSpace = 'galaxy';
    
    
//////////////////////////////////////////////////////////////////////////
///////////         �������� ��������
    
    
    /**
     * ��������� ������� ������ � �������� ������� ��������
     *
     * @param string $command ��� ������� ��������
     */
    public function __construct($command)
    {
        $this->command = $command;
    }

    /**
     * ����������� ������� - ���������� � ������ �����������.
     * ���� ��������� ����� ������� ��� ��������.
     *
     * @param string $command ��� �������
     * @param integer $access ������� ������� ��� �������
     */
    public function registerCommand($command, $access = 0)
    {
        $this->alloyCommandRegistered = true;
        if (is_array($command))
        {
            foreach ($command as $run)
            {
                $this->alloyCommands[] = $run;
                $this->alloyCommandsStatus[] = 0;
            }
        }
        else 
        {
            $this->alloyCommands[] = (string)$command;
            $this->alloyCommandsStatus[] = $access;
        }
    }

    /**
     * ����������� ������� �� ���������.
     * ���������� ��� ���������� ���������� ������� � ������� ����������.
     *
     * @param string $command ��� �������
     * @param integer $access ������� ��� ������� � �������
     */
    public function registerDefaultCommand($command, $access = 0)
    {
        $this->commandDefaultRegistered = true;        
        $this->commandDefault = (string)$command;
        $this->commandDefaultStatus = $access;
    }

    /**
     * ����������� ��������������� ��������� �������.
     * ��������� ��� ������ ����������� ����������� � ��������������� �������. $this->parameters[] = $parameter;
     *
     * @param mixed $command �������� ���������
     */
    public function registerParameter($parameter)
    {
        $this->parameters[] = $parameter;
    }
    
    /**
     * ��������� ������� �� ������������.
     * ������ ���������� ������ ����� �������:
     *      registerDefaultCommand($command)
     *      registerCommand($command)
     *      ����� ����������.
     *
     * @return boolean ���� ������������ ��������� �������
     */
    public function check()
    {
        if (!$this->commandDefaultRegistered or !$this->alloyCommandRegistered)
            throw new Dune_Exception_Base('�� ��������������� ������� �� ��������� � ������ ���������� ������.');
        $bool = true;
        $key = array_search($this->command, $this->alloyCommands);
        if ($key === false)
        {
            $this->command = $this->commandDefault;
            $this->commandStatus = $this->commandDefaultStatus;
            $bool = false;
        }
        else 
        {
            $this->commandStatus = $this->alloyCommandsStatus[$key];
        }
        return $bool;
    }
    
    /**
     * ���������� �������
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * ���������� ������ ��������
     *
     * @return string
     */
    public function getCommandAccessLevel()
    {
        return $this->commandStatus;
    }
    
    
    /**
     * ���������� ������ ����������
     *
     * @return array
     */
    public function getCommandParameters()
    {
        return $this->parameters;
    }

    /**
     * ���������� ������� ����� �������
     *
     * @return string
     */
    public function getCommandFolder()
    {
        return $this->commandFolder;
    }
    
    /**
     * ������������� ������� ����� �������.
     * �� ��������� ����� default.
     *
     * @return string
     */
    public function setCommandFolder($string)
    {
        $this->commandFolder = $string;
    }
    
    
}