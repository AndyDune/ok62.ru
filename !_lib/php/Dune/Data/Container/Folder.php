<?
/**
 * Класс-контейнер параметров подключаемой подпапки.
 * !!! Под подпапкой подразумеваю команда, находящаяся в папке текущей команды
 * 
 * Используется в любом месте проекта для плодключения комманд.
 * 
 *	 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Folder.php                                  |
 * | В библиотеке: Dune/Data/Container/Folder.php      |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.05                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * История версий:
 * -----------------
 * 
 * 1.05 (2009 январь 30)
 * Доработано ввод параметров.
 * 
 * 1.04 (2009 январь 29)
 * Цепочка функций.
 * 
 * 1.03 (2008 декабрь 03)
 * Предает в методе check() действительную команду конейтеру Dune_Data_Collector_Commands.
 * 
 * 1.02 (2008 октябрь 24)
 * Для пущей стабильности изменено имя массива - хранителя параметров.
 * 
 * 1.01 (2008 октябрь 23)
 * Добавлены магические методы для доступа к параметрам (массив $this->parameters). _set() и _get() 
 * 
 */

class Dune_Data_Container_Folder
{
    /**
     * Принимаемое для обработки имя папки
     *
     * @var string
     * @access private
     */
    protected $folder;

    /**
     * Статус папки для доступа
     *
     * @var string
     * @access private
     */
    protected $folderStatus;
    
    /**
     * Команда по умолчанию.
     * Устанавливается если полученной нет в списке допустимых
     *
     * @var string
     * @access private
     */
    protected $folderDefault;
    
    /**
     * Статус команды по умолчанию.
     * Устанавливается если полученной нет в списке допустимых
     *
     * @var integer
     * @access private
     */
    protected $folderDefaultStatus;
    /**
     * Флаг регистрации команды по умолчанию
     * 
     * @var boolean
     * @access private
     */
    protected $folderDefaultRegistered = false;
    
    
    /**
     * Массив допустимых комманд
     *
     * @var array
     * @access private
     */
    protected $alloyFolders = array();  

    /**
     * Массив статусов допустимых комманд
     *
     * @var array
     * @access private
     */
    protected $alloyFolderStatus = array();
    
    /**
     * Флаг регистрации допустимых команд
     * 
     * @var boolean
     * @access private
     */
    protected $alloyFolderRegistered = false;
    
    /**
     * Массив дополнительных параметров папки
     *
     * @var array
     * @access private
     */
    protected $____parameters = array();

    /**
     * Путь к файлу комад в пределах папки команд.
     * Определяет группу комманд с которой работаем.
     *
     * @var string
     * @access private
     */
    protected $path;

    
    /**
     * Путь к файлу комад в пределах папки команд.
     * Определяет группу комманд с которой работаем.
     *
     * @var string
     * @access private
     */
    protected $mainFile = 'index.php';
    
    
//////////////////////////////////////////////////////////////////////////
///////////         Описание констант
    
    
    /**
     * Обработка входных данных и создание текущей комманды
     *
     * @param string $folder имя текущей комманды
     */
    public function __construct($folder)
    {
        $this->folder = $folder;
    }

    /**
     * Установка пути к набору папок.
     * Без слеша в конце.
     *
     * @param string $path путь к родительской папки подключаемой
     * @return Dune_Data_Container_Folder
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }
    
    /**
     * Устанавливает имя главного файла для подключения
     *
     * @return Dune_Data_Container_Folder
     */
    public function setMainFile($file)
    {
        $this->mainFile = $file;
        return $this;
    }
    
    
    /**
     * Регистрация папки - добавление в массив разрешённых.
     * Плюс установка урвня доступа для папки.
     *
     * @param string $folder имя папки
     * @param integer $access уровень доступа для папки
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
     * Регистрация папки по умолчанию.
     * Необходимо при отсутствии переданной папки в массиве допустимых.
     *
     * @param string $folder имя папки
     * @param integer $access уровень для доступа к команде
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
     * Регистрация дополнительного параметра папки.
     * Параметры при каждой регистрации сохраняются в неассоциятивном массиве. $this->parameters[] = $parameter;
     *
     * @param mixed $folder значение параметра
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
     * Проверяет команду на допустимость.
     * Должен вызываться только после методов:
     *      registerDefaultFolder($folder)
     *      registerFolder($folder)
     *      иначе прерывание.
     *
     * @return boolean флаг допустимости переданой папки
     */
    public function check()
    {
        if (!$this->folderDefaultRegistered or !$this->alloyFolderRegistered)
            throw new Dune_Exception_Base('Не зарегистированы папка по умолчанию и список допустимых папок.');
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
     * Возвращает команду
     *
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * Возвращает статус комманды
     *
     * @return string
     */
    public function getFolderAccessLevel()
    {
        return $this->folderStatus;
    }
    
    
    /**
     * Возвращает массив параметров
     *
     * @return array
     */
    public function getFolderParameters()
    {
        return $this->____parameters;
    }

    /**
     * Возвращает текущую папку комманд
     *
     * @return string без слеша в конце
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Возвращает имя главного файла для подключения
     *
     * @return string
     */
    public function getMainFile()
    {
        return $this->mainFile;
    }
    
    ////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы
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