<?php
/**
 * «Хлебные крошки» (англ. Breadcrumb) — элемент навигации по сайту, представляющий собой путь по сайту от его «корня» до текущей страницы, на которой находится пользователь.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                    |
 * | Файл: BreadCrumb.php                                |
 * | В библиотеке: Dune/Display/BreadCrumb.php           |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>           |
 * | Версия: 1.03                                        |
 * | Сайт: www.rznw.ru                                   |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * 
 * 1.03(2009 апрель 17)
 * Синглетон теперь псевдо.
 *
 * 1.02(2009 январь 23)
 * Для set-методов реализована возможность построения "цепочек";
 * 
 * 1.01
 * Не выводится ссылка под последней крошкой, даже если была установлена.
 * 
 * 
 */
class Dune_Display_BreadCrumb
{
    
    /**
     * Масив-накопитель "хлебных крошек"
     *
     * @var array
     * @access private
     */
    protected $_array = array();
    protected $_separator = '>';
    protected $_minCount = 0;
    
    /**
     * Регистрация синглетона
     *
     * @var object
     * @access private
     */
    static private $instance = array();   
     
   /**
    * Создаёт реализацию класса при первом вызове
    * Возвращает сохранённый указатель объекта при последующих вызовах
    *
    * @return Dune_Display_BreadCrumb
    */
    static public function getInstance($key = 'default')
    {
        if (!key_exists($key, self::$instance))
        {
            self::$instance[$key] = new Dune_Display_BreadCrumb();
        }
        return self::$instance[$key];
    }
    
    protected function __construct()
    {
        
    }
    
    /**
     * Добавить крошку
     *
     * @param string $name имя крошеи
     * @param string $link ссылка за крошкой - если нет - ссылка не ставится
     */
    public function addCrumb($name, $link = '')
    {
        $this->_array[] = array(
                               'name' => $name,
                               'link' => $link
                              );
        return $this;
    }
    /**
     * Выбрать всь массив с крошками
     *
     * @return array
     */
    public function getArray()
    {
        return $this->_array;
    }

    /**
     * Задать новый сепаратор между крошками
     *
     * @param string $string
     */
    public function setSeparator($string)
    {
        $this->_separator = $string;
        return $this;
    }

    /**
     * Задать минимальное число крошек, меньше которого стрка не выводится
     *
     * @param integer $string
     */
    public function setMinCount($number = 0)
    {
        $this->_minCount = $number;
        return $this;
    }
    
    
    /**
     * Выбрать строку с цепочкой крошек для отображения на сайте.
     * 
     * Возвращает строку ссылок, разделённых сепаратором (обрамляется пробелами).
     * Если для крошки не указана ссылка - имя обёртывается в span (ссылкии нет).
     * 
     * Если не было добавлено ни одной крошки - возврат пустой строки.
     *
     * @param string $befor символы, помещаемые до сгенерированной цепочки крошек
     * @param string $after символы, помещаемые после сгенерированной цепочки крошек
     * @return string
     */
    public function getString($befor = '', $after = '')
    {
        $string = '';
        $count = count($this->_array);
        if (count($this->_array) > $this->_minCount)
        {
            $curr = 1;
            foreach ($this->_array as $value)
            {
                if ($string)
                    $string .= ' ' . $this->_separator . ' ';
                if ($value['link'] and ($curr != $count))
                {
                    $string .= '<a href="' . $value['link'] . '">' . $value['name'] . '</a>';
                }
                else 
                {
                    $string .= '<span>' . $value['name'] . '</span>';
                }
                $curr++;
            }
            $string = $befor . $string . $after;
        }
        return $string;
    }
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы
    
    
    public function __toString()
    {
        return $this->getString();
    }

    
////////////////////////////////////////////////////////////////
///////////////////////////////     Закрытые методы
    
}