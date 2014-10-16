<?
/**
 * �����-��������� ���������� ��������.
 * 
 * ������������ ������:
 *	Dune_Filter_Request_Format_NoFilter 
 *  Dune_Filter_Get_UrlCommand
 *  Dune_Data_Collector_Commands
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Command.php                                 |
 * | � ����������: Dune/Data/Container/Command.ph      |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.07                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * ������� ������:
 * -----------------
 * 
 * 1.07 (2009 ���� 02)
 * ��������� ������ ��������� � �������� ������� ���� � ����� ��������
 * 
 * 1.06 (2009 ������ 29)
 *  ����������� ������� �������.
 * 
 * 1.05 (2008 ������� 03)
 *  ������� � ������ check() �������������� ������� ��������� Dune_Data_Collector_Commands.
 * 
 * 1.03 -> 1.04
 * !!! �������������� ��������� ��������� ����� ������� ��������.
 * ������������� ����������� ��� �����. ���� ��� �������� �� ��������� � ������ �����.
 * 
 * 1.02 -> 1.03
 * �������� ������� ������� ������ �� url. ������������� �� ���������� ������
 * 
 * 1.01 -> 1.02
 * ������� ����������� ���������� ������ �������� - ������� ��� ����� � ����� ������
 * 
 * 1.00 -> 1.01
 * ������� ���������� $commandFolder - �����(������ ������) ������� ������ ������
 * ������: getCommandFolder(), setCommandFolder()
 * 
 */

class Dune_Data_Container_Command
{
    /**
     * �������
     *
     * @var string
     * @access private
     */
    protected $_command;

    /**
     * ����� ��������
     *
     * @var string
     * @access private
     */
    protected $_commandRealFolder;
    /**
     * ������ ��������
     *
     * @var string
     * @access private
     */
    protected $_commandStatus;
    
    /**
     * ������� �� ���������.
     * ��������������� ���� ���������� ��� � ������ ����������
     *
     * @var string
     * @access private
     */
    protected $_commandDefault;
    
    /**
     * ���� ����������� ������� �� ���������
     * 
     * @var boolean
     * @access private
     */
    protected $_commandDefaultRegistered = false;
    
    /**
     * ���������� �������
     * ��������� ����� ������� � �������� ��� �������� (� ������������ ���������� $exact
     *
     * @var string
     * @access private
     */
    protected $_commandExact;
    
    /**
     * ������ ���������� �������
     *
     * @var array
     * @access private
     */
    protected $_alloyCommands = array();  

    /**
     * ������ �������� ���������� �������
     *
     * @var array
     * @access private
     */
    protected $_alloyCommandsStatus = array();
    
    /**
     * ���� ����������� ���������� ������
     * 
     * @var boolean
     * @access private
     */
    protected $_alloyCommandRegistered = false;
    
    /**
     * ������ �������������� ���������� �������
     *
     * @var array
     * @access private
     */
    protected $____parameters = array();

    /**
     * ���� � ����� ����� � �������� ����� ������.
     * ���������� ������ ������� � ������� ��������.
     *
     * @var string
     * @access private
     */
    protected $commandFolder = 'default';
    
    
    protected $_commandFolderFull = '';

//////////////////////////////////////////////////////////////////////////
///////////         �������� ��������
    /**
     * ������� ���������� ������ � ���������������� �������
     */
    const STATUS_ADMIN = 'admin';

    /**
     * ������� ���� ����������� �� ���������
     */
    const STATUS_DEFAULT = 'default';
    
    
    /**
     * ��������� ������� ������ � �������� ������� ��������
     * �������� ���������� ��
     *
     * @param string $command ��� ������� ��������
     * @param string $exact 
     */
    public function __construct($command, $exact = 'default')
    {
        $this->_command = $command;
        $this->_commandExact = $exact;
    }

    /**
     * ����������� ������� - ���������� � ������ �����������
     *
     * @param string $command ��� �������
     */
    public function registerCommand($command, $folder = false, $status = 'free')
    {
        if (!$folder or is_null($folder))
            $folder = $command;
        $this->_alloyCommandRegistered = true;
        if (is_array($command))
        {
            foreach ($command as $run)
            {
                $this->_alloyCommands[$run] = $run;
                $this->_alloyCommandsStatus[$run] = 'free';
            }
        }
        else 
        {
            $this->_alloyCommands[$command]       = $folder;
            $this->_alloyCommandsStatus[$command] = $status;
        }
        return $this;
    }

    /**
     * ����������� ������� �� ���������.
     * ���������� ��� ���������� ���������� ������� � ������� ����������.
     *
     * @param string $command ��� �������
     */
    public function registerDefaultCommand($command)
    {
        $this->_commandDefaultRegistered = true;        
        $this->_commandDefault = (string)$command;
        return $this;
    }

    /**
     * ����������� ��������������� ��������� �������
     *
     * @param mixed $command �������� ���������
     */
    public function registerParameter($parameter)
    {
        $this->____parameters[] = $parameter;
        return $this;
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
        if (!$this->_commandDefaultRegistered or !$this->_alloyCommandRegistered)
            throw new Dune_Exception_Base('�� ��������������� ������� �� ��������� � ������ ���������� ������.');
        $key = key_exists($this->_command, $this->_alloyCommands);
        if ($key === false)
        {
            $this->_command           = $this->_commandDefault;
            $this->_commandRealFolder = $this->_commandDefault;
            $this->_commandStatus     = self::STATUS_DEFAULT;
            $this->_commandExact      = 'default';
            $bool = false;
        }
        else 
        {
            $this->_commandStatus     = $this->_alloyCommandsStatus[$this->_command];
            $this->_commandRealFolder = $this->_alloyCommands[$this->_command];
            $bool = true;
        }
//        Dune_Data_Collector_Commands::addCommand($this->_command);
        return $bool;
    }
    
    /**
     * ���������� �������
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->_command;
    }

    /**
     * ���������� ����� �������.
     *
     * @return string
     */
    public function getCommandRealFolder()
    {
        return $this->_commandRealFolder;
    }
    
    /**
     * ���������� ������ ��������
     *
     * @return string
     */
    public function getCommandStatus()
    {
        return $this->_commandStatus;
    }
    
    /**
     * ���������� ���������� �������
     *
     * @return string
     */
    public function getCommandExact()
    {
        return $this->_commandExact;
    }
    
    /**
     * ���������� ������ ����������
     *
     * @return array
     */
    public function getCommandParameters()
    {
        return $this->____parameters;
    }

    /**
     * ���������� ������� ����� �������
     *
     * @return string
     */
    public function getCommandFolder()
    {
        return $this->_commandFolder;
    }
    
    /**
     * ������������� ������� ����� �������.
     * �� ��������� ����� default.
     *
     * @return string
     */
    public function setCommandFolder($string)
    {
        $this->_commandFolder = $string;
        return $this;
    }

    /**
     * ������������� ������ ���� � ����� �������.
     *
     * @return string
     */
    public function setCommandFolderFull($string)
    {
        $this->_commandFolderFull = $string;
        return $this;
    }
    
    /**
     * ���������� ������ ���� � �������.
     *
     * @return string
     */
    public function getCommandFolderFull()
    {
        if ($this->_commandFolderFull)
            return $this->_commandFolderFull . '/' . $this->_commandRealFolder;
        return Dune_Parameters::$commandPath . '/' . $this->_commandFolder . '/' . $this->_commandRealFolder;
    }
    
    
    
}