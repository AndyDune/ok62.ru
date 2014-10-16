<?php
 /**
 * Абстрактный класс. Системные методы и переменные для осблуживания основного кода, определяемого в дочернем классе.
 * В дочернем классе определяется только рабочий код в методе code().
 *
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Display.php                                 |
 * | В библиотеке: Dune/Include/Abstract/Display.php   |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.02                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * История версий:
 * -----------------
 * 
 * 1.02 (2008 июнь 25)
 * Метод assign() принимает массивы.
 * Инициилизация стилей и криптов и массивов после отработки шаблона.
 * Возможность указыть приоритет в массиве $______styles.
 *
 * 1.01 (2008 июнь 20)
 * Статичная переменная self::$viewfiles - путь к папке с файлами видов.
 *
 * 1.00 (2008 июнь 18)
 * Применен.
 * Новый метд render() - аналог make()
 * Обозначение используемых таблиц стилей и скриптов.
 * 
 * 0.99 (2008 апрель 29)
 * Внедрение. Не проверено.
 * 
 */

abstract class Dune_Include_Abstract_Display
{
    /**
     * Гененерировать ли исключение при отсутствии запрашиваемого результата.
     * True - генерить (по умолчанию)
     *
     * @var boolean
     */
    public static $isExeption = true;
    
    public static $viewfiles = '';

    /**
     * Массив кодов сообщений
     *
     * @var array
     * @access private
     */
    protected $messageCode = array();
    
    /**
     * Массив расшифровок кодов сообщений
     *
     * @var array
     * @access private
     */
    protected $messageText = array();
    

    /**
     * Массив результатов работы модуля новый
     *
     * @var array
     * @access private
     */
    protected $____results = array();
    
    
    /**
     * Текст буфера вывода информации из команды
     *
     * @var string
     * @access private
     */
    protected $____buffer = '';
    
    
    /**
     * Массив вхлдных параметрогв модуля.
     *
     * @var array
     * @access private
     */
    protected $____parameters = array();
    
    
    /**
     * Массив переменных для вида. Статический.
     *
     * @var array
     * @access private
     */
    protected static $_____parametersSsSsS_ = array();
    
    /**
     * Ключ к доступу глобальных переменных из вида.
     *
     * @var array
     * @access private
     */
    protected $_____useParametersSsSsS_ = false;
    
    
    
    /**
     * Используемые стили
     *
     * @var array
     * @access private
     */
    protected $______styles = array(
                                   );
    
                                   
    /**
     * Используемые скрипты
     *
     * @var array
     */
    protected $______scripts = array(
                                   );

    
    public function __construct($parameters = array())
    {
    	$this->____parameters = $parameters;
    }
    
    
    /**
     * Иницилизация статической переменной для вида.
     *
     * @param string $spec
     * @param mixed $value
     */
    public function assignGlobal($spec, $value = null)
    {
        if (key_exists($spec, self::$______parametersSsSsS_))
        {
            throw new Dune_Exception_Base('Повторная инициилизация глобальной переменной');
        }
        self::$_____parametersSsSsS_[$spec] = $value;
    }
    
    /**
     * Разрешение/запрет использования глобальных(статичных) переменных.
     *
     * @param unknown_type $value
     */
    protected function useGlobal($value = false)
    {
        $this->_____useParametersSsSsS_ = $value;
    }
    
    /**
     * Возврат глобальной переменной.
     *
     * @return mixed
     */
    protected function getGlobal($key)
    {
        if (isset(self::$_parametersSsSsS_[$key]))
            return self::$_____parametersSsSsS_[$key];
        return null;
    }
    
    
    /**
     * Prevent E_NOTICE for nonexistent values
     *
     * If {@link strictVars()} is on, raises a notice.
     *
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
        if ($this->_____useParametersSsSsS_)
        {
             if (isset(self::$_____parametersSsSsS_[$key]))
                return self::$_____parametersSsSsS_[$key];
            return null;
        }
        else
        {
        	if (isset($this->____parameters[$key]))
        		return $this->____parameters[$key];
            return null;
        }
    }
    
    /**
     * Инициилизировать переменную.
     *
     * @param string $spec
     * @param mixed $value
     * @return Dune_View
     */
    public function assign($spec, $value = null)
    {
        if (is_array($spec))
        {
            foreach ($spec as $key => $val)
            {
                $this->__set($key, $val);
            }
        }
        else 
            $this->__set($spec, $value);
        return $this;
    }
    
    
    /**
     * Запуск дисплея. Возврат результата. Аналог render()
     *
     * @return string
     */
    public function make()
    {
      return $this->render();
    }

    /**
     * Запуск дисплея. Возврат результата.
     *
     * @return string
     */
    public function render()
    {
      ob_start();
      
      if (!self::$viewfiles)
          self::$viewfiles = '/viewfiles/' . Dune_Parameters::$templateSpace . '/' . Dune_Parameters::$templateRealization . '/';

      foreach ($this->______styles as $value)
      {
          if (is_array($value))
          { 
              Dune_Static_StylesList::add($value[0], $value[1]);
          }
          else 
          { 
              Dune_Static_StylesList::add($value);
          }
      }
      foreach ($this->______scripts as $value)
      {
          Dune_Static_JavaScriptsList::add($value);
      }
      
      $this->code(); 
      return $this->____buffer = ob_get_clean();
    }
    
    
    protected function code()
    {
        // Основной рабочий код класса. Определяется в дочернем.
        
        
    }
    
    /**
     * Функция для установки результатов работы модуля.
     * !!! Очень желательно применять этот метод.
     * Старый подвержен ошибкам.
     *
     * @param unknown_type $name
     * @param unknown_type $value
     */
    protected function setResult($name, $value)
    {
        $this->____results[$name] = $value;
        return $this;
    }
    

    /**
     * Выбрать содержимое буфера результатов вывода команды
     *
     * @return string
     */
    public function getOutput()
    {
        return $this->____buffer;
    }
   
     /**
     * Возвращает результат с указанныи номером.
     * Генерит исключение при отсутствии ключа.
     *
     * @param mixed $key ключ для возврата, устанавливается в подкомманде. Если не указан - возврат вывода команды.
     * @return string
     */
    public function getResult($key)
    {
        if (key_exists($key, $this->____results))
            return $this->____results[$key];
        if (self::$isExeption)
           throw new Dune_Exception_Base('Нет запрашиваемого результата.');
        return null;
    }

     /**
     * Возвращает весть массив результатов.
     *
     * @return string
     */
    public function getResults()
    {
        return $this->____results;
    }
    
    
     /**
     * Возвращает текстовый блок помощи.
     * или false если блока помощи нет.
     *
     * @return string
     */
    public function help()
    {
         return true;
    }
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы
    public function __set($name, $value)
    {
    	$this->____parameters[$name] = $value;
    }
    
    public function __toString()
    {
        return $this->____buffer;
    }
    
    
/////////////////////////////
////////////////////////////////////////////////////////////////
    
    
}