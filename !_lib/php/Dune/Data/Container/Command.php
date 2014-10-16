<?
/**
 * Класс-контейнер параметров комманды.
 * 
 * Используемые классы:
 *	Dune_Filter_Request_Format_NoFilter 
 *  Dune_Filter_Get_UrlCommand
 *  Dune_Data_Collector_Commands
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Command.php                                 |
 * | В библиотеке: Dune/Data/Container/Command.ph      |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.07                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * История версий:
 * -----------------
 * 
 * 1.07 (2009 июнь 02)
 * Добавлены методы установки и возврата полного пути к папке комманды
 * 
 * 1.06 (2009 январь 29)
 *  Реализована цепочка методов.
 * 
 * 1.05 (2008 декабрь 03)
 *  Предает в методе check() действительную команду конейтеру Dune_Data_Collector_Commands.
 * 
 * 1.03 -> 1.04
 * !!! Принципиальное изменение механизма ввода входной комманды.
 * Использование псевдонимов для папок. Если имя комманды не совпадает с именем папки.
 * 
 * 1.02 -> 1.03
 * Изменены функции выборки команд из url. Функционально не изменилось ничего
 * 
 * 1.01 -> 1.02
 * Введена возможность обозначать статус комманды - полезно для входа в админ панель
 * 
 * 1.00 -> 1.01
 * Введена переменная $commandFolder - папка(группа команд) текущей группы команд
 * Методы: getCommandFolder(), setCommandFolder()
 * 
 */

class Dune_Data_Container_Command
{
    /**
     * Команда
     *
     * @var string
     * @access private
     */
    protected $_command;

    /**
     * Папка комманды
     *
     * @var string
     * @access private
     */
    protected $_commandRealFolder;
    /**
     * Статус Комманды
     *
     * @var string
     * @access private
     */
    protected $_commandStatus;
    
    /**
     * Команда по умолчанию.
     * Устанавливается если полученной нет в списке допустимых
     *
     * @var string
     * @access private
     */
    protected $_commandDefault;
    
    /**
     * Флаг регистрации команды по умолчанию
     * 
     * @var boolean
     * @access private
     */
    protected $_commandDefaultRegistered = false;
    
    /**
     * Расширение команды
     * Передаётся после запятой в комманде или отдельно (в конструкторе переменная $exact
     *
     * @var string
     * @access private
     */
    protected $_commandExact;
    
    /**
     * Массив допустимых комманд
     *
     * @var array
     * @access private
     */
    protected $_alloyCommands = array();  

    /**
     * Массив статусов допустимых комманд
     *
     * @var array
     * @access private
     */
    protected $_alloyCommandsStatus = array();
    
    /**
     * Флаг регистрации допустимых команд
     * 
     * @var boolean
     * @access private
     */
    protected $_alloyCommandRegistered = false;
    
    /**
     * Массив дополнительных параметров команды
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
    protected $commandFolder = 'default';
    
    
    protected $_commandFolderFull = '';

//////////////////////////////////////////////////////////////////////////
///////////         Описание констант
    /**
     * Команда обозначает работу с административной панелью
     */
    const STATUS_ADMIN = 'admin';

    /**
     * Команда была установлена по умолчанию
     */
    const STATUS_DEFAULT = 'default';
    
    
    /**
     * Обработка входных данных и создание текущей комманды
     * Комманда выбирается из
     *
     * @param string $command имя текущей комманды
     * @param string $exact 
     */
    public function __construct($command, $exact = 'default')
    {
        $this->_command = $command;
        $this->_commandExact = $exact;
    }

    /**
     * Регистрация команды - добавление в массив разрешённых
     *
     * @param string $command имя команды
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
     * Регистрация команды по умолчанию.
     * Необходимо при отсутствии переданной команды в массиве допустимых.
     *
     * @param string $command имя команды
     */
    public function registerDefaultCommand($command)
    {
        $this->_commandDefaultRegistered = true;        
        $this->_commandDefault = (string)$command;
        return $this;
    }

    /**
     * Регистрация дополнительного параметра команды
     *
     * @param mixed $command значение параметра
     */
    public function registerParameter($parameter)
    {
        $this->____parameters[] = $parameter;
        return $this;
    }
    
    /**
     * Проверяет команду на допустимость.
     * Должен вызываться только после методов:
     *      registerDefaultCommand($command)
     *      registerCommand($command)
     *      иначе прерывание.
     *
     * @return boolean флаг допустимости переданой команды
     */
    public function check()
    {
        if (!$this->_commandDefaultRegistered or !$this->_alloyCommandRegistered)
            throw new Dune_Exception_Base('Не зарегистированы команда по умолчанию и список допустимых команд.');
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
     * Возвращает команду
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->_command;
    }

    /**
     * Возвращает папку команды.
     *
     * @return string
     */
    public function getCommandRealFolder()
    {
        return $this->_commandRealFolder;
    }
    
    /**
     * Возвращает статус комманды
     *
     * @return string
     */
    public function getCommandStatus()
    {
        return $this->_commandStatus;
    }
    
    /**
     * Возвращает расширение команды
     *
     * @return string
     */
    public function getCommandExact()
    {
        return $this->_commandExact;
    }
    
    /**
     * Возвращает массив параметров
     *
     * @return array
     */
    public function getCommandParameters()
    {
        return $this->____parameters;
    }

    /**
     * Возвращает текущую папку комманд
     *
     * @return string
     */
    public function getCommandFolder()
    {
        return $this->_commandFolder;
    }
    
    /**
     * Устанавливает текущую папку комманд.
     * По умолчанию стоит default.
     *
     * @return string
     */
    public function setCommandFolder($string)
    {
        $this->_commandFolder = $string;
        return $this;
    }

    /**
     * Устанавливает полный путь к папке комманд.
     *
     * @return string
     */
    public function setCommandFolderFull($string)
    {
        $this->_commandFolderFull = $string;
        return $this;
    }
    
    /**
     * Возвращает полный путь к команде.
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