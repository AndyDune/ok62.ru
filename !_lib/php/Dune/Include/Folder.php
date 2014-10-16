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
 * | Файл: SubFolder.php                               |
 * | В библиотеке: Dune/Include/SubFolder.php          |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.12                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * История версий:
 * -----------------
 * 
 *  1.12 (2008 октябрь 24)
 *  Для пущей стабильности изменено имя массива - хранителя параметров.
 * 
 *  1.10 -> 1.11
 *  Вывод подключаемого модуля сохраняется и доступен методом getOutput и getResult при отсутствии передаваемого параметра.
 * 
 *  1.02 -> 1.10
 *  Изменена работа с передаваемыми переменными в подключаемом файле.
 * 
 *  1.01 -> 1.02
 *  Переменная с путем к выполняемому файлу перенесена в родительски класс.
 * 
 * 
 * 1.01 -> 1.02
 * Перенесено часть переменных, констант, методов в родительский класс
 * 
 * 1.00 -> 1.01
 * Изменение в методе getResult. По умолчанию не происходит прерывания если нет ключа для выдачи.
 * ТОгда возвращается falses.
 * 
 */

class Dune_Include_Folder extends Dune_Include_Parent_Command
{

    
    /**
     * Полный путь к файлу команд
     *
     * @var string
     * @access private
     */
    protected $folderPath = '';
    
    
/////////////////////////////////////////////////////////////////////////
    
    /**
     * Конструктор класса выполнения команд. Выполнение подключаемого кода при создании объекта.
     * make() не использовать.
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
	 * В отличие от метода родителя возвращает флаг существование подключаемого кода. Больше ничего не делает.
	 *
	 * @return boolean true - если файл существует, false - иначе
	 */
    public function make()
    {
        return $this->existence;
    }
    
    
}