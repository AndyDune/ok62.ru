<?php
/**
 *
 * Класс для навигации по страницам
 * 
 * Используются стили по умолчанию:
 * 
 * class = "navigator-inactive" - класс для span в котором неходится
 * class = "navigator-total-pages-display"
 * class = "navigator"
 * class = "navigator-to-edge" - класс для span, в котором находится смиволы, между основным списком и номерами 1-й и последней страниц
 * 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Page.php                                    |
 * | В библиотеке: Dune/Navigate/Page.php              |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.03                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * 1.03 (2009 январь 23)
 * Для set-методов реализована возможность построения "цепочек";
 * 
 * Версия: 1.01 -> 1.02
 * --------------------
 * Отдельный параметр в конструкторе для колличества записей на странице.
 * 
 * За основу был взят класс PageNavigator, описанный в книге:
 * Питера Ловейна "PHP5 объектно-ориентированое программирование"
 *
 */

class Dune_Navigate_Page
{
  // Строка до номера страны в ссылке
  protected $beforePageNumber;
  
  // Строка после номера страны в ссылке
  protected $afterPageNumber = '';
  
  // Всего страниц
  protected $totalPages;
  
  // Число записей на странице
  protected $recordsPerPage = 10;
  
  // Максимально числло ссылок на другие страницы
  protected $maxPagesShown = 7;
  
  // Цифра с которой начинается отсчёт  смещений страниц в урл (отображение всегда с 1)
  protected $beginOffset = 0;
  // Маскимально возможное смещение страницы
  protected $maxOffset;

  // Текущее смещение относительно $pageOffsetBegin
  protected $currentOffset;  
  
  protected $currentStartPage;
  protected $currentEndPage;
  protected $currentStartOffset;
  protected $currentEndOffset;
  protected $currentPage;
  protected $pageOffset;
  
 
  
  //следующая и предыдущая неактивны
  protected $spanNextInactive;
  protected $spanPreviousInactive;
  
  //первая и последняя неактивны
  protected $firstInactiveSpan;
  protected $lastInactiveSpan;  
  
  //css class names
  protected $inactiveSpanName = 'navigator-inactive';
  protected $pageDisplayDivName = 'navigator-total-pages-display';
  protected $divWrapPerName = 'navigator';
  protected $exPagesDisplayName = 'navigator-to-edge';
  
  
  
  
  //text for navigation
  protected $strFirst = '|&lt;';
  protected $strNext = 'следующая';
  protected $strPrevious = 'предыдущая';
  protected $strLast = '&gt;|';
  
  // отображение номера последней странице в списке
  protected $exPagesDisplay = false;
  // строка перед номером последней страны
  protected $stringBeforeLastPageNumber = ' .....';
  protected $stringAfterFirstPageNumber = '..... ';
  
  protected $strNavigator = null;
  
  
////////////////////////////////////////////////////////////////////
//  Конструктор
////////////////////////////////////////////////////////////////////
//  public function __construct($pagename, $totalrecords, $recordsperpage, $recordoffset, $maxpagesshown = 7, $params = ''){
  public function __construct($beforePageNumber, $totalRecords, $currentOffset = 0, $records_per_page = 10, $array = array())
  {      
    $this->beforePageNumber = $beforePageNumber;
    if (key_exists('after_page_number',$array))
        $this->afterPageNumber = $array['after_page_number'];
    if (key_exists('max_pages_shown',$array))
        $this->maxPagesShown = $array['max_pages_shown'];
    $this->recordsPerPage = $records_per_page;
    if (key_exists('begin_offset',$array))
    {
        if ($array['begin_offset'] > 1)
            throw new Exception('Ошибка передачи параметра. Недопустимое значение. Возможно 0 или 1.');
        $this->beginOffset = $array['begin_offset'];
    }
    $this->setTotalPages($totalRecords, $this->recordsPerPage);        
    $this->setCurrentOffset($currentOffset);
        
     
    $this->createInactiveSpans();
    
    $this->calculateCurrentStartPage();
    $this->calculateCurrentEndPage();
  }
////////////////////////////////////////////////////////////////////
//public methods
////////////////////////////////////////////////////////////////////
/**
 * Очищает буферир вывода списка страниц
 * Можно сформировать в другом виде
 *
 * @param boolean $bool
 */
  public function clearBuffer()
  {
    $this->strNavigator = null;
  }

/**
 * Задать имя класса (CSS) для неактивной страницы (текущей. Кликнуть нельзя)
 *
 * @param string $name
 */
  public function setInactiveSpanName($name)
  {
    $this->inactiveSpanName = $name;
    //call function to rename span
    $this->createInactiveSpans();  
    return $this;
  }
/**
 * Узнать имя класса (CSS) для неактивной страницы (текущей. Кликнуть нельзя)
 *
 * @return string
 */
  public function getInactiveSpanName()
  {
    return $this->inactiveSpanName;
  }
/**
 * Задать имя объекта (CSS) для блока информации о страницах
 *
 * @param string $name
 */
  public function setPageDisplayDivName($name)
  {
    $this->pageDisplayDivName = $name;   
    return $this; 
  }
  
/**
 * Узнать имя объекта (CSS) для блока информации о страницах
 *
 * @return string
 */
  public function getPageDisplayDivName()
  {
    return $this->pageDisplayDivName;
  }
  
/**
 * Задать имя объекта (CSS) для блока списка страниц
 *
 * @param string $name
 */
  public function setDivWrapperName($name)
  {
    $this->divWrapPerName = $name; 
    return $this;   
  }
  
/**
 * Узнать имя объекта (CSS) для блока списка страниц
 *
 * @return  string
 */
  public function getDivWrapperName()
  {
    return $this->divWrapPerName;
  }
  
/**
 * Задать строку подсоединяемую к URL после номера страницы
 * 
 * @param string $name
 */
  public function setAfterPageNumber($name)
  {
    $this->afterPageNumber = $name;  
    return $this;  
  }
  
/**
 * Узнать строку подсоединяемую к URL после номера страницы
 * 
 * @return string
 */
  public function getAfterPageNumber()
  {
    return $this->afterPageNumber;
  }
  
/**
 * Задать колличество номеров страниц, отображаемых по обе стороны от текущей
 * Цифра определяет число с каждой стороны
 * 
 * @param integer $name
 */
  public function setMaxPagesShown($num)
  {
    $this->maxPagesShown = $num;   
    return $this; 
  }
  
/**
 * Узнать колличество номеров страниц, отображаемых по обе стороны от текущей
 * 
 * @return integer $name
 */
  public function getMaxPagesShown()
  {
    return $this->maxPagesShown;
  }
  
////////////////////////////////////////////////////////////////////

/**
 * Возвращает ссылку на предыдущую страницу (если нужно отделить от общего блока)
 * По умолчанию отображается строка: предыдущая
 * 
 * @return string
 */
    public function getPreviousButton()
    {
        if($this->currentOffset == $this->beginOffset)
        {
            $text = $this->spanPreviousInactive;
        }
        else
        {
            $text = $this->createLink($this->currentOffset-1, $this->strPrevious);
        }
      return $text;
    }
    
/**
 * Возвращает ссылку на следующую страницу (если нужно отделить от общего блока)
 * По умолчанию отображается строка: следующая
 *
 * @return string
 */
    public function getNextButton()
    {
        if($this->currentPage == $this->totalPages)
        {
            $text = $this->spanNextInactive;
        }
        else
        {
            $text = $this->createLink($this->currentOffset + 1, $this->strNext);
        }
        return $text;
    }

    public function setStrNext($name)
    {
        $this->strNext = $name;
        return $this;
    }
    public function setStrPrevious($name)
    {
        $this->strPrevious = $name;
        return $this;
    }
    
    
/**
 * Возвращает ссылку на первую страницу (если нужно отделить от общего блока)
 * По умолчанию отображается строка: &lt;|
 * 
 * @return string
 */
    public function getFirstButton()
    {
        if($this->currentOffset == $this->beginOffset)
        {
            $text = $this->firstInactiveSpan;
        }
        else
        {
            $text = $this->createLink($this->beginOffset, $this->strFirst);
        }
        return $text;
    }
    
/**
 * Возвращает ссылку на последнюю страницу (если нужно отделить от общего блока)
 * По умолчанию отображается строка: &gt;|
 * Отображение задаётся методом
 * 
 * @return string
 */
    public function getLastButton()
    {
        if($this->currentPage == $this->totalPages)
        {
            $text = $this->lastInactiveSpan;
        }
        else
        {
            $text = $this->createLink($this->maxOffset, $this->strLast);
        }
        return $text;
    }
    
    
  /**
  * Возвращает текст: страница <номер> из <общее число страниц>
  * Блок для вставки на страницу
  *
  * @return string
  */
  public function getPageNumberDisplay()
  {
    $str = '<div class="'.$this->pageDisplayDivName.'">Страница ';
    $str .= $this->currentPage;
    $str .= ' из '.$this->totalPages;
    $str .= '</div>';
    return $str;
  }
    
    public function setStrBeforeLastPageNumber($string)
    {
        $this->stringBeforeLastPageNumber = $string;
        return $this;
    }
    public function setStrAfterFirstPageNumber($string)
    {
        $this->stringAfterFirstPageNumber = $string;
        return $this;
    }
    
    /**
     * Определяем имя класса для строки между ссылкой на первую/последнюю страницы и основным блоком ссылок
     * По умолчанию: navigator-to-edge
     * 
     * @param string $name
     */
    public function setExPagesDisplayName($name)
    {
        $this->exPagesDisplayName = $name;
        return $this;
    }
  
  /**
   * Возвращает текст навигатора для печати на странице
   * Первый парметр - режим отображение блочного смещения:
   * yandex - как в яндексе (многоточие - ссылка на следующий блок)
   * original - как в изменённом классе (по краям строки с номерами ссылки на крайний блок и на следующую страницу)
   * special - ссылка на первую и последнюю страницу с указанием номеров
   * specialr - ссылка только на последнюю страницу с указанием номера
   * 
   * Если ни одно из перечисленных - вид дополнит ссылок определяется 2-мя следующими параметрами
   *
   * @param string $displayMode
   * @param boolean $showNextPreviousButtons управление выводом кнопок предыдущий/следующий (false - выключить)
   * @param boolean $showFirstLastButtons управление выводом кнопок перехода к первой/последней стнице (false - выключить)
   * @return string
   */
  public function getNavigator($displayMode = 'yandex', $showNextPreviousButtons = false, $showFirstLastButtons = false)
  {
    //Если ничего в буфере нет - создаём список
    if ($this->strNavigator == null)
    {
        $strnavigator = '<div class="'.$this->divWrapPerName.'">';
    
        // Выводим дополнительные навиг. ссылки
        switch ($displayMode)
        {
            case 'yandex':
                if ($this->currentStartOffset > $this->beginOffset)
                {
                    $strnavigator .= $this->createLink($this->currentStartOffset - 1, '...');
                }
            break;
            case 'original':
                $strnavigator .= $this->getFirstButton();
                $strnavigator .= $this->getPreviousButton();
            break;
            case 'special':
                if ($this->currentStartOffset > $this->beginOffset)
                {
                    $strnavigator .= $this->createLink($this->beginOffset, '1');
                    $strnavigator .= '<span class="' . $this->exPagesDisplayName . '">'
                                  . $this->stringAfterFirstPageNumber . '</span>';
                }
            break;
        
            default:
                //output movefirst button    
                if ($showFirstLastButtons)
                    $strnavigator .= $this->getFirstButton();
    
                //output moveprevious button
                if ($showNextPreviousButtons) 
                    $strnavigator .= $this->getPreviousButton();
        }
       
        $offset = $this->currentStartOffset;
        // Выводиим ряд страниц
        for($x = $this->currentStartPage; $x <= $this->currentEndPage; $x++)
        {
            //make current page inactive
            if($x == $this->currentPage)
            {
                $strnavigator .= '<span class="'.$this->inactiveSpanName.'">';
                $strnavigator .= $x;
                $strnavigator .= '</span>';
            }
            else
            {
                $strnavigator .= $this->createLink($offset, $x);
            }
            $offset++;
        }
    
        // Выводим дополнительные навиг. ссылки
        switch ($displayMode)
        {
            case 'yandex':
                if ($this->currentEndOffset < $this->maxOffset)
                {
                    $strnavigator .= $this->createLink($this->currentEndOffset + 1, '...');
                }
            break;
            case 'original':
                $strnavigator .= $this->getNextButton();
                $strnavigator .= $this->getLastButton();
            break;
            case ('special'):
                if ($this->currentEndOffset < $this->maxOffset)
                {
                    $strnavigator .= '<span class="' . $this->exPagesDisplayName . '">' 
                                  . $this->stringBeforeLastPageNumber . '</span>';
                    $strnavigator .= $this->createLink($this->maxOffset, $this->totalPages);
                }
            break;
            case ('specialr'):
                if ($this->currentEndOffset < $this->maxOffset)
                {
                    $strnavigator .= '<span class="' . $this->exPagesDisplayName . '">' 
                                  . $this->stringBeforeLastPageNumber . '</span>';
                    $strnavigator .= $this->createLink($this->maxOffset, $this->totalPages);
                }
            break;
        
            default:
                // Выводим кнопку "следующая страница"
                if ($showNextPreviousButtons) 
                    $strnavigator .= $this->getNextButton();
        
                //move last button
                if ($showFirstLastButtons)
                    $strnavigator .= $this->getLastButton();
        }
    
        $strnavigator .=  '</div>';
        $this->strNavigator = $strnavigator;
    }
    return $this->strNavigator;
  }
////////////////////////////////////////////////////////////////////
//protected methods
////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////
  protected function setCurrentOffset($currentOffset)
  {
    if ($currentOffset > $this->totalPages)
        $this->currentOffset = $this->maxOffset;
    else if ($currentOffset < $this->beginOffset)
        $this->currentOffset = $this->beginOffset;
    else 
        $this->currentOffset = $currentOffset;
        
    if ($this->beginOffset)
        $this->currentPage = $this->currentOffset;
    else 
        $this->currentPage = $this->currentOffset + 1;
  }
////////////////////////////////////////////////////////////////////
  protected function setTotalPages($totalRecords, $recordsPerPage)
  {
    $this->totalPages = ceil($totalRecords/$recordsPerPage);
    if ($this->beginOffset)
        $this->maxOffset = $this->totalPages;
    else 
        $this->maxOffset = $this->totalPages - 1;
  }

  
  
////////////////////////////////////////////////////////////////////
// Находим начальную странцу по номеру текущей
////////////////////////////////////////////////////////////////////
  protected function calculateCurrentStartPage()
  {
    $this->currentStartPage = 1;
    $this->currentStartOffset = $this->beginOffset;
      
    if ($this->maxPagesShown < $this->currentPage)
    {
        $this->currentStartPage = $this->currentPage - $this->maxPagesShown;
        $this->currentStartOffset = $this->currentOffset - $this->maxPagesShown;
    }
  }
////////////////////////////////////////////////////////////////////
  protected function calculateCurrentEndPage()
  {
    $this->currentEndPage = $this->currentPage + $this->maxPagesShown;
    $this->currentEndOffset = $this->currentOffset + $this->maxPagesShown;
    if($this->currentEndPage > $this->totalPages)
    {
      $this->currentEndPage = $this->totalPages;
      $this->currentEndOffset = $this->maxOffset;
    }
  }
  
 ////////////////////////////////////////////////////////////////////  
  protected function createLink($offset, $strdisplay)
  {
    $strtemp = '<a href="' . $this->beforePageNumber . $offset;

    $strtemp .= $this->afterPageNumber . '">'.$strdisplay.'</a>';
    return $strtemp;
  }
  
////////////////////////////////////////////////////////////////////
// not always needed but create anyway
////////////////////////////////////////////////////////////////////
  protected function createInactiveSpans()
  {
    $this->spanNextInactive = '<span class="'.
      $this->inactiveSpanName. '">' . $this->strNext . '</span>';
    $this->lastInactiveSpan = '<span class="'.
      $this->inactiveSpanName . '">' . $this->strLast . '</span>';
    $this->spanPreviousInactive = '<span class="'.
      $this->inactiveSpanName . '">' . $this->strPrevious . '</span>';
    $this->firstInactiveSpan = '<span class="'.
      $this->inactiveSpanName . '">' . $this->strFirst . '</span>';
  }
}
//end class
////////////////////////////////////////////////////////////////////