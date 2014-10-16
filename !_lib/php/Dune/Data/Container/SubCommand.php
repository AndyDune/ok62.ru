<?
/**
 * Класс-контейнер параметров подкомманды.
 * Используется в любом месте проекта для плодключения комманд.
 * 
 *	 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: SubCommand.php                              |
 * | В библиотеке: Dune/Data/Container/SubCommand.php  |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.01                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 * 
 * История версий:
 * -----------------
 * 
 * 1.00 -> 1.01
 * Введено понятие пространства комманд - статичная переменная, хранящая путь к папкам субкомманд.
 * Имеет значение при кардинальной смене функциональности
 * 
 */

class Dune_Data_Container_SubCommand
{
    /**
     * Команда
     *
     * @var string
     * @access private
     */
    protected $command;

    /**
     * Статус Комманды
     *
     * @var string
     * @access private
     */
    protected $commandStatus;
    
    /**
     * Команда по умолчанию.
     * Устанавливается если полученной нет в списке допустимых
     *
     * @var string
     * @access private
     */
    protected $commandDefault;
    
    /**
     * Статус команды по умолчанию.
     * Устанавливается если полученной нет в списке допустимых
     *
     * @var integer
     * @access private
     */
    protected $commandDefaultStatus;
    /**
     * Флаг регистрации команды по умолчанию
     * 
     * @var boolean
     * @access private
     */
    protected $commandDefaultRegistered = false;
    
    
    /**
     * Массив допустимых комманд
     *
     * @var array
     * @access private
     */
    protected $alloyCommands = array();  

    /**
     * Массив статусов допустимых комманд
     *
     * @var array
     * @access private
     */
    protected $alloyCommandsStatus = array();
    
    /**
     * Флаг регистрации допустимых команд
     * 
     * @var boolean
     * @access private
     */
    protected $alloyCommandRegistered = false;
    
    /**
     * Массив дополнительных параметров команды
     *
     * @var array
     * @access private
     */
    protected $parameters = array();

    /**
     * Путь к файлу комад в пределах папки команд.
     * Определяет группу комманд с которой работаем.
     *
     * @var string
     * @access private
     */
    protected $commandFolder = 'default';

    /**
     * Определяет пространство комманд
     *
     * @var string
     */
    static public $commandSpace = 'galaxy';
    
    
//////////////////////////////////////////////////////////////////////////
///////////         Описание констант
    
    
    /**
     * Обработка входных данных и создание текущей комманды
     *
     * @param string $command имя текущей комманды
     */
    public function __construct($command)
    {
        $this->command = $command;
    }

    /**
     * Регистрация команды - добавление в массив разрешённых.
     * Плюс установка урвня доступа для комманды.
     *
     * @param string $command имя команды
     * @param integer $access уровень доступа для команды
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
     * Регистрация команды по умолчанию.
     * Необходимо при отсутствии переданной команды в массиве допустимых.
     *
     * @param string $command имя команды
     * @param integer $access уровень для доступа к команде
     */
    public function registerDefaultCommand($command, $access = 0)
    {
        $this->commandDefaultRegistered = true;        
        $this->commandDefault = (string)$command;
        $this->commandDefaultStatus = $access;
    }

    /**
     * Регистрация дополнительного параметра команды.
     * Параметры при каждой регистрации сохраняются в неассоциятивном массиве. $this->parameters[] = $parameter;
     *
     * @param mixed $command значение параметра
     */
    public function registerParameter($parameter)
    {
        $this->parameters[] = $parameter;
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
        if (!$this->commandDefaultRegistered or !$this->alloyCommandRegistered)
            throw new Dune_Exception_Base('Не зарегистированы команда по умолчанию и список допустимых команд.');
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
     * Возвращает команду
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Возвращает статус комманды
     *
     * @return string
     */
    public function getCommandAccessLevel()
    {
        return $this->commandStatus;
    }
    
    
    /**
     * Возвращает массив параметров
     *
     * @return array
     */
    public function getCommandParameters()
    {
        return $this->parameters;
    }

    /**
     * Возвращает текущую папку комманд
     *
     * @return string
     */
    public function getCommandFolder()
    {
        return $this->commandFolder;
    }
    
    /**
     * Устанавливает текущую папку комманд.
     * По умолчанию стоит default.
     *
     * @return string
     */
    public function setCommandFolder($string)
    {
        $this->commandFolder = $string;
    }
    
    
}