<?php
 /**
 *  Класс для подключения файлов с анализом и выполнением подкомманд
 *
 * 
 * Модуль должен использовать следующие массивы для генерации выходных данных
 *    $massage_code = array() - коды сообщений
 *    $massage_text = array() - тексты кодов сообщений
 *    $results = array() - информация
 * 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: SubCommand.php                              |
 * | В библиотеке: Dune/Include/SubCommand.php         |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.05                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 * 
 * История версий:
 * -----------------
 * 
 * 1.04 -> 1.05
 * Вывод подключаемого модуля сохраняется и доступен методом getOutput и getResult при отсутствии передаваемого параметра.
 *
 * 1.03 -> 1.04
 * Перенесено часть переменных, констант, методов в родительский класс
 * 
 * 1.02 -> 1.03
 * Изменение в методе getResult. По умолчанию не происходит прерывания если нет ключа для выдачи.
 * ТОгда возвращается falses.
 * 
 * 1.01 -> 1.02
 * В текст включаемого файла передаётся переменная $_folder - полное имя папки с включаемым файлом
 * 
 * 1.00 -> 1.01
 * Введено использование стаичной переменной из класса Dune_Data_Container_SubCommand
 * 
 */

class Dune_Include_SubCommand extends Dune_Include_Parent_Command
{
    
    /**
     * Полный путь к файлу команд
     *
     * @var string
     * @access private
     */
    protected $commandFullPath = '';

    /**
     * Полный путь к папке команды
     *
     * @var string
     * @access private
     */
    protected $commandPath = '';
    
    

/////////////////////////////////////////////////////////////////////////
    
    /**
     * Конструктор класса выполнения команд
     *
     * @param Dune_Data_Container_SubCommand $command
     */
    public function __construct(Dune_Data_Container_SubCommand $command, $access = 0)
    {
        // Коды сообщений, возвращаемых из модуля
        $message_code = array();
        // Тексты сообщений возвращаемых из модуля
        $message_text = array();
        // Результаты выполнения команды
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
             //  throw new Dune_Exception_Base('Нет указанного модуля');
                
             $this->parameters = $command->getCommandParameters();
             $_folder = $this->commandPath;
             
             ob_start();
             include($this->commandFullPath);
             $this->buffer = ob_get_clean();
                 
         }
    }
    
	/**
	 * В отличие от метода родителя возвращает флаг существование подключаемого кода. Больше ничего не делает.
	 *
	 * @return boolean true - если файл существует, false - иначе
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