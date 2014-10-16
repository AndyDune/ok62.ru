<?php
 /**
 *  Выполнение произвольного модуляЮ находящегося в текущей папке
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
 * | Файл: SubFolder.php                               |
 * | В библиотеке: Dune/Include/Operation.php          |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.03                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * История версий:
 * -----------------
 * 
 * 1.03 (2008 октябрь 24)
 * Для пущей стабильности изменено имя массива - хранителя параметров.
 *
 * Вывод подключаемого модуля сохраняется и доступен методом getOutput и getResult при отсутствии передаваемого параметра.
 * 
 * 1.00 -> 1.01
 * магические методы перенесены к родителю.
 * Переменная parameters перенесена к родителю.
 * 
 */

class Dune_Include_Operation extends Dune_Include_Parent_Command
{

    

    /**
     * Полный путь к файлу команд
     *
     * @var string
     * @access private
     */
    protected $folderPath = '';

    
    static $operationsFolder = '';
    static $mainFile = 'index.php';
    
/////////////////////////////////////////////////////////////////////////
    
    /**
     * Конструктор класса выполнения команд
     *
     * @param string $current_folder текущая папка, из которой вызывается операция
     */
    public function __construct($operation, $current_folder, $parameters = false)
    {
        // Коды сообщений, возвращаемых из модуля
        $this->messageCode = array();
        // Тексты сообщений возвращаемых из модуля
        $this->messageText = array();
        // Результаты выполнения команды
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
         	//throw new Dune_Exeption_Base('Нет подключаемого файла: ' . $this->folderFullPath);
    }
 
    
}

