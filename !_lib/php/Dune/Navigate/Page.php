<?php
/**
 *
 * ����� ��� ��������� �� ���������
 * 
 * ������������ ����� �� ���������:
 * 
 * class = "navigator-inactive" - ����� ��� span � ������� ���������
 * class = "navigator-total-pages-display"
 * class = "navigator"
 * class = "navigator-to-edge" - ����� ��� span, � ������� ��������� �������, ����� �������� ������� � �������� 1-� � ��������� �������
 * 
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Page.php                                    |
 * | � ����������: Dune/Navigate/Page.php              |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.03                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * 1.03 (2009 ������ 23)
 * ��� set-������� ����������� ����������� ���������� "�������";
 * 
 * ������: 1.01 -> 1.02
 * --------------------
 * ��������� �������� � ������������ ��� ����������� ������� �� ��������.
 * 
 * �� ������ ��� ���� ����� PageNavigator, ��������� � �����:
 * ������ ������� "PHP5 ��������-�������������� ����������������"
 *
 */

class Dune_Navigate_Page
{
  // ������ �� ������ ������ � ������
  protected $beforePageNumber;
  
  // ������ ����� ������ ������ � ������
  protected $afterPageNumber = '';
  
  // ����� �������
  protected $totalPages;
  
  // ����� ������� �� ��������
  protected $recordsPerPage = 10;
  
  // ����������� ������ ������ �� ������ ��������
  protected $maxPagesShown = 7;
  
  // ����� � ������� ���������� ������  �������� ������� � ��� (����������� ������ � 1)
  protected $beginOffset = 0;
  // ����������� ��������� �������� ��������
  protected $maxOffset;

  // ������� �������� ������������ $pageOffsetBegin
  protected $currentOffset;  
  
  protected $currentStartPage;
  protected $currentEndPage;
  protected $currentStartOffset;
  protected $currentEndOffset;
  protected $currentPage;
  protected $pageOffset;
  
 
  
  //��������� � ���������� ���������
  protected $spanNextInactive;
  protected $spanPreviousInactive;
  
  //������ � ��������� ���������
  protected $firstInactiveSpan;
  protected $lastInactiveSpan;  
  
  //css class names
  protected $inactiveSpanName = 'navigator-inactive';
  protected $pageDisplayDivName = 'navigator-total-pages-display';
  protected $divWrapPerName = 'navigator';
  protected $exPagesDisplayName = 'navigator-to-edge';
  
  
  
  
  //text for navigation
  protected $strFirst = '|&lt;';
  protected $strNext = '���������';
  protected $strPrevious = '����������';
  protected $strLast = '&gt;|';
  
  // ����������� ������ ��������� �������� � ������
  protected $exPagesDisplay = false;
  // ������ ����� ������� ��������� ������
  protected $stringBeforeLastPageNumber = ' .....';
  protected $stringAfterFirstPageNumber = '..... ';
  
  protected $strNavigator = null;
  
  
////////////////////////////////////////////////////////////////////
//  �����������
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
            throw new Exception('������ �������� ���������. ������������ ��������. �������� 0 ��� 1.');
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
 * ������� ������� ������ ������ �������
 * ����� ������������ � ������ ����
 *
 * @param boolean $bool
 */
  public function clearBuffer()
  {
    $this->strNavigator = null;
  }

/**
 * ������ ��� ������ (CSS) ��� ���������� �������� (�������. �������� ������)
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
 * ������ ��� ������ (CSS) ��� ���������� �������� (�������. �������� ������)
 *
 * @return string
 */
  public function getInactiveSpanName()
  {
    return $this->inactiveSpanName;
  }
/**
 * ������ ��� ������� (CSS) ��� ����� ���������� � ���������
 *
 * @param string $name
 */
  public function setPageDisplayDivName($name)
  {
    $this->pageDisplayDivName = $name;   
    return $this; 
  }
  
/**
 * ������ ��� ������� (CSS) ��� ����� ���������� � ���������
 *
 * @return string
 */
  public function getPageDisplayDivName()
  {
    return $this->pageDisplayDivName;
  }
  
/**
 * ������ ��� ������� (CSS) ��� ����� ������ �������
 *
 * @param string $name
 */
  public function setDivWrapperName($name)
  {
    $this->divWrapPerName = $name; 
    return $this;   
  }
  
/**
 * ������ ��� ������� (CSS) ��� ����� ������ �������
 *
 * @return  string
 */
  public function getDivWrapperName()
  {
    return $this->divWrapPerName;
  }
  
/**
 * ������ ������ �������������� � URL ����� ������ ��������
 * 
 * @param string $name
 */
  public function setAfterPageNumber($name)
  {
    $this->afterPageNumber = $name;  
    return $this;  
  }
  
/**
 * ������ ������ �������������� � URL ����� ������ ��������
 * 
 * @return string
 */
  public function getAfterPageNumber()
  {
    return $this->afterPageNumber;
  }
  
/**
 * ������ ����������� ������� �������, ������������ �� ��� ������� �� �������
 * ����� ���������� ����� � ������ �������
 * 
 * @param integer $name
 */
  public function setMaxPagesShown($num)
  {
    $this->maxPagesShown = $num;   
    return $this; 
  }
  
/**
 * ������ ����������� ������� �������, ������������ �� ��� ������� �� �������
 * 
 * @return integer $name
 */
  public function getMaxPagesShown()
  {
    return $this->maxPagesShown;
  }
  
////////////////////////////////////////////////////////////////////

/**
 * ���������� ������ �� ���������� �������� (���� ����� �������� �� ������ �����)
 * �� ��������� ������������ ������: ����������
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
 * ���������� ������ �� ��������� �������� (���� ����� �������� �� ������ �����)
 * �� ��������� ������������ ������: ���������
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
 * ���������� ������ �� ������ �������� (���� ����� �������� �� ������ �����)
 * �� ��������� ������������ ������: &lt;|
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
 * ���������� ������ �� ��������� �������� (���� ����� �������� �� ������ �����)
 * �� ��������� ������������ ������: &gt;|
 * ����������� ������� �������
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
  * ���������� �����: �������� <�����> �� <����� ����� �������>
  * ���� ��� ������� �� ��������
  *
  * @return string
  */
  public function getPageNumberDisplay()
  {
    $str = '<div class="'.$this->pageDisplayDivName.'">�������� ';
    $str .= $this->currentPage;
    $str .= ' �� '.$this->totalPages;
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
     * ���������� ��� ������ ��� ������ ����� ������� �� ������/��������� �������� � �������� ������ ������
     * �� ���������: navigator-to-edge
     * 
     * @param string $name
     */
    public function setExPagesDisplayName($name)
    {
        $this->exPagesDisplayName = $name;
        return $this;
    }
  
  /**
   * ���������� ����� ���������� ��� ������ �� ��������
   * ������ ������� - ����� ����������� �������� ��������:
   * yandex - ��� � ������� (���������� - ������ �� ��������� ����)
   * original - ��� � ��������� ������ (�� ����� ������ � �������� ������ �� ������� ���� � �� ��������� ��������)
   * special - ������ �� ������ � ��������� �������� � ��������� �������
   * specialr - ������ ������ �� ��������� �������� � ��������� ������
   * 
   * ���� �� ���� �� ������������� - ��� �������� ������ ������������ 2-�� ���������� �����������
   *
   * @param string $displayMode
   * @param boolean $showNextPreviousButtons ���������� ������� ������ ����������/��������� (false - ���������)
   * @param boolean $showFirstLastButtons ���������� ������� ������ �������� � ������/��������� ������ (false - ���������)
   * @return string
   */
  public function getNavigator($displayMode = 'yandex', $showNextPreviousButtons = false, $showFirstLastButtons = false)
  {
    //���� ������ � ������ ��� - ������ ������
    if ($this->strNavigator == null)
    {
        $strnavigator = '<div class="'.$this->divWrapPerName.'">';
    
        // ������� �������������� �����. ������
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
        // �������� ��� �������
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
    
        // ������� �������������� �����. ������
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
                // ������� ������ "��������� ��������"
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
// ������� ��������� ������� �� ������ �������
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