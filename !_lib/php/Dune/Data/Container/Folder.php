<?
/**
 * �����-��������� ���������� ������������ ��������.
 * !!! ��� ��������� ������������ �������, ����������� � ����� ������� �������
 * 
 * ������������ � ����� ����� ������� ��� ������������ �������.
 * 
 *	 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Folder.php                                  |
 * | � ����������: Dune/Data/Container/Folder.php      |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.05                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * ������� ������:
 * -----------------
 * 
 * 1.05 (2009 ������ 30)
 * ���������� ���� ����������.
 * 
 * 1.04 (2009 ������ 29)
 * ������� �������.
 * 
 * 1.03 (2008 ������� 03)
 * ������� � ������ check() �������������� ������� ��������� Dune_Data_Collector_Commands.
 * 
 * 1.02 (2008 ������� 24)
 * ��� ����� ������������ �������� ��� ������� - ��������� ����������.
 * 
 * 1.01 (2008 ������� 23)
 * ��������� ���������� ������ ��� ������� � ���������� (������ $this->parameters). _set() � _get() 
 * 
 */

class Dune_Data_Container_Folder
{
    /**
     * ����������� ��� ��������� ��� �����
     *
     * @var string
     * @access private
     */
    protected $folder;

    /**
     * ������ ����� ��� �������
     *
     * @var string
     * @access private
     */
    protected $folderStatus;
    
    /**
     * ������� �� ���������.
     * ��������������� ���� ���������� ��� � ������ ����������
     *
     * @var string
     * @access private
     */
    protected $folderDefault;
    
    /**
     * ������ ������� �� ���������.
     * ��������������� ���� ���������� ��� � ������ ����������
     *
     * @var integer
     * @access private
     */
    protected $folderDefaultStatus;
    /**
     * ���� ����������� ������� �� ���������
     * 
     * @var boolean
     * @access private
     */
    protected $folderDefaultRegistered = false;
    
    
    /**
     * ������ ���������� �������
     *
     * @var array
     * @access private
     */
    protected $alloyFolders = array();  

    /**
     * ������ �������� ���������� �������
     *
     * @var array
     * @access private
     */
    protected $alloyFolderStatus = array();
    
    /**
     * ���� ����������� ���������� ������
     * 
     * @var boolean
     * @access private
     */
    protected $alloyFolderRegistered = false;
    
    /**
     * ������ �������������� ���������� �����
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
    protected $path;

    
    /**
     * ���� � ����� ����� � �������� ����� ������.
     * ���������� ������ ������� � ������� ��������.
     *
     * @var string
     * @access private
     */
    protected $mainFile = 'index.php';
    
    
//////////////////////////////////////////////////////////////////////////
///////////         �������� ��������
    
    
    /**
     * ��������� ������� ������ � �������� ������� ��������
     *
     * @param string $folder ��� ������� ��������
     */
    public function __construct($folder)
    {
        $this->folder = $folder;
    }

    /**
     * ��������� ���� � ������ �����.
     * ��� ����� � �����.
     *
     * @param string $path ���� � ������������ ����� ������������
     * @return Dune_Data_Container_Folder
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }
    
    /**
     * ������������� ��� �������� ����� ��� �����������
     *
     * @return Dune_Data_Container_Folder
     */
    public function setMainFile($file)
    {
        $this->mainFile = $file;
        return $this;
    }
    
    
    /**
     * ����������� ����� - ���������� � ������ �����������.
     * ���� ��������� ����� ������� ��� �����.
     *
     * @param string $folder ��� �����
     * @param integer $access ������� ������� ��� �����
     * @return Dune_Data_Container_Folder
     */
    public function register($folder, $access = 0)
    {
        $this->alloyFolderRegistered = true;
        if (is_array($folder))
        {
            foreach ($folder as $run)
            {
                $this->alloyFolders[] = $run;
                $this->alloyFolderStatus[] = 0;
            }
        }
        else 
        {
            $this->alloyFolders[] = (string)$folder;
            $this->alloyFolderStatus[] = $access;
        }
        return $this;
    }

    /**
     * ����������� ����� �� ���������.
     * ���������� ��� ���������� ���������� ����� � ������� ����������.
     *
     * @param string $folder ��� �����
     * @param integer $access ������� ��� ������� � �������
     * @return Dune_Data_Container_Folder
     */
    public function registerDefault($folder, $access = 0)
    {
        $this->folderDefaultRegistered = true;        
        $this->folderDefault = (string)$folder;
        $this->folderDefaultStatus = $access;
        return $this;
    }

    /**
     * ����������� ��������������� ��������� �����.
     * ��������� ��� ������ ����������� ����������� � ��������������� �������. $this->parameters[] = $parameter;
     *
     * @param mixed $folder �������� ���������
     * @return Dune_Data_Container_Folder
     */
    public function registerParameter($parameter, $value = null)
    {
        if (is_null($value))
        {
            if (is_array($parameter))
            {
                foreach ($parameter as $key => $val)
                {
                    $this->____parameters[$key] = $val;
                }
            }
            else 
                $this->____parameters[] = $parameter;
        }
        else 
            $this->____parameters[$parameter] = $value;
        return $this;
    }
    
    /**
     * ��������� ������� �� ������������.
     * ������ ���������� ������ ����� �������:
     *      registerDefaultFolder($folder)
     *      registerFolder($folder)
     *      ����� ����������.
     *
     * @return boolean ���� ������������ ��������� �����
     */
    public function check()
    {
        if (!$this->folderDefaultRegistered or !$this->alloyFolderRegistered)
            throw new Dune_Exception_Base('�� ��������������� ����� �� ��������� � ������ ���������� �����.');
        $bool = true;
        $key = array_search($this->folder, $this->alloyFolders);
        
        if ($key === false)
        {
            $this->folder = $this->folderDefault;
            $this->folderStatus = $this->folderDefaultStatus;
            $bool = false;
        }
        else 
        {
            $this->folderStatus = $this->alloyFolderStatus[$key];
        }
        Dune_Data_Collector_Commands::addCommand($this->folder);
        return $bool;
    }
    
    /**
     * ���������� �������
     *
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * ���������� ������ ��������
     *
     * @return string
     */
    public function getFolderAccessLevel()
    {
        return $this->folderStatus;
    }
    
    
    /**
     * ���������� ������ ����������
     *
     * @return array
     */
    public function getFolderParameters()
    {
        return $this->____parameters;
    }

    /**
     * ���������� ������� ����� �������
     *
     * @return string ��� ����� � �����
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * ���������� ��� �������� ����� ��� �����������
     *
     * @return string
     */
    public function getMainFile()
    {
        return $this->mainFile;
    }
    
    ////////////////////////////////////////////////////////////////
///////////////////////////////     ���������� ������
    public function __set($name, $value)
    {
    	$this->____parameters[$name] = $value;
    }
    public function __get($name)
    {
    	if (isset($this->____parameters[$name]))
    		return $this->____parameters[$name];
    	else 
    		return false;
    }
    
    
}