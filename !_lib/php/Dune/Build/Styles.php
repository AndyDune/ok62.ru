<?php
/**
 * ����� �������� ������� ������ � ����� html
 * ��������� ����� -> ���������� ���
 * 
 * �������� ����� __toStrihg() - ��������. !!! ����� ������� ����������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Styles.php                                  |
 * | � ����������: Dune/Build/Styles.php               |
 * | �����: ������ ����� (Dune) <dune@pochta.ru>       |
 * | ������: 1.03                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 *
 * ������� ������:
 * -----------------
 * 
 *  ������ 1.02 -> 1.03
 *  ���� �� ����� ie6.css � ���������� �������������� � �������� ������ ��� ie ������ ����� 7
 * 
 * ������ 1.01 -> 1.02
 * ������������ ����� getStyles -> get
 * ���������� Dune_Exception_Base
 * 
 * ������ 1.00 -> 1.01
 * ������ ������. ����������� ��������� ���� � ����� � ������� css � ����� styles
 * ��������� ����������� �������� �������� �����
 * 
 */

class Dune_Build_Styles
{
    protected $dirName = '';
    protected $fullDirName = '';
    protected $stylesText = '';
    
    protected $stylesRootPath = 'styles';
    
    /**
     * ����������� �������
     * ��������� ���� � ����� styles � ������ css
     *
     * @param string $stylesPath
     */
    public function __construct($stylesPath = '', $stylesRootPath = 'styles')
    {
        if ($stylesPath != '')
        {
            $stylesPath = '/' . $stylesPath;
        }
        $this->stylesRootPath = $stylesRootPath;
        $this->dirName = $this->stylesRootPath . $stylesPath;
        $this->fullDirName = $_SERVER['DOCUMENT_ROOT'].'/'.$this->dirName;
    }
    /**
     * ���������� ������ ��� ��������� � ����� html ��� ��������� ������ ������
     *
     * @return string
     */
    public function get()
    {
        $this->checkDirectory();
        $this->scanDirectory();
        return $this->stylesText;
    }
    
    
/////////////////////////////////////////////////////////////////////
//////////////////////////////      ��������� ������    

    // ��������� ���������� �� ���������� � ������ ������
    protected function checkDirectory()
    {
        if (!is_dir($this->fullDirName))
        {
            throw new Dune_Exception_Base('������� �������� ���������� ��� ����������� ������ ������: '.$this->dirName);
        }
    }
    // ��������� ��������� ����� �� ������� ������
    // ���������� ������ � ������� ��� ������� � �������� html ��� ��������� css
    protected function scanDirectory()
    {
        $find_ie6 = false;
        $this->stylesText = '';
        $arr = scandir($this->fullDirName);
        foreach ($arr as $runArr)
        { 
            if (is_file($this->fullDirName.'/'.$runArr))
            {
                if (basename($runArr, '.css') == 'ie6')
                    $find_ie6 = true;
                else 
                    $this->stylesText .= '<link href="/'.$this->dirName.'/'.$runArr.'" rel="stylesheet" type="text/css" />';
            }
        }
        if ($find_ie6)
            $this->stylesText .= '<!--[if lt IE 7]><link href="/'.$this->dirName.'/ie6.css" rel="stylesheet" type="text/css" /><![endif]-->';
        return $this->stylesText;
    }
////////// ����� �������� ��������� �������
///////////////////////////////////////////////////////////////

    
    
//////////////////////////////////////////////////////////////////
///////////     ��������� ������

    public function __toString()
    {
        $this->checkDirectory();
        $this->scanDirectory();
        return $this->stylesText;
    }

////////// ����� �������� ��������� �������
///////////////////////////////////////////////////////////////
}