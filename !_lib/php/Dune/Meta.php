<?php
/**
 * ����������� �����
 * ���������� � ���� ������ ��� ������������ ����� ����-�����
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Meta.php                                    |
 * | � ����������: Dune/Meta.php                       |
 * | �����: ������ ����� (Dune) <dune@rznlf.ru>        |
 * | ������: 1.01                                      |
 * | ����: www.rznlf.ru                                |
 * ----------------------------------------------------
 * 
 *  ����� ������������ � ��� ����������
 * 
 * ������� ������:
 * -----------------
 * ������ 1.00 -> 1.01
 * ���������� �������� ������: getrobotsArray() -> getRobotsArray()
 */

class Dune_Meta
{
//////////////////////////////////////////////////////////////////////////////////
////////////////////////////        ��������� ����������, ������ - ������ ��������
    /**
     * ������ ���������� �������� ���� ���� control-cache
     * @var array
     */
    static private $cacheControlArray = array(1=>'public','private','no-cache','no-store','no-transform','must-revalidate','proxy-revalidate');
    
    /**
     * ����� ���������� ������ ���������� �������� ���� control-cache
     *
     * @return array
     */
    static public function getCacheControlArray()
    {
        return $cacheControlArray;
    }
    /**
     * ������ ���������� �������� ���� ���� robots
     * @var array
     */
    static private $robotsArray = array(1=>'index','follow','all','noindex','nofollow','none');
    
    /**
     * ����� ���������� ������ ���������� �������� ���� robots
     *
     * @return array
     */
    static public function getRobotsArray()
    {
        return $robotsArray;
    }
    
////////////////////////////        ��������� ����������, ������ - ����� ��������    
/////////////////////////////////////////////////////////////////////////////////    

    /**
     * ���������� ������ c ���������� refresh
     * ��������:
     *  $time - ����� � ��������, ����� ������� ������� ���������� ������������� ��������
     *  $url - ����� �������� � ������� ������������, ���� �� ��������, ������������� �� ����
     * 
     * @param integer $time
     * @param string $url
     * @return string
     */
    static public function refresh($time = 5,$url = '')
    {
        if ($url != '')
            $add = '; url='.$url;
        else 
            $add = '';
        return '<meta http-equiv="refresh" content="'.$time.$add.'">';
    }
    /**
     * �������������
     *
     * @param string $url
     * @return string
     */
    static public function location($url = '')
    {
        return '<meta http-equiv="location" content="'.$url.'">';
    }
    /**
     * ������ ����������� �� ��������� HTTP 1.0
     *
     * @return string
     */
    static public function pragma()
    {
        return '<meta http-equiv="pragma" content="no-cache">';
    }
    
    /**
     * ���������� ������������ � ��������� HTTP 1.1
     *
     * <meta http-equiv="cache-control" content="��������">
     * 
     * �������� ���������:
     * 1. public   - ��������� ����������� �� ���� ����� ����
     * 2. private  - ���� �����, ���� ��� ����� ����� ������������ ������ ������ ����� �������������� �������������. ��� ���� ������ ����������� ���������
     * 3. no-cache - ������ �����������, ��� �� �� �� ����;
     * 4. no-store - ����������� ������ ��������� �����������
     * 5. no-transform - ������ ������������� ������������ ������
     * 6. must-revalidate - ��� ������� ������ ��������� ������ ������ ��������� ��������� � ��������� ������� ��� ������ ������
     * 7. proxy-revalidate - ���� ��� � must-revalidate, �� ������ ��� ������-��������
     * 8. max-age - ��������� �������� ����� ������ � ����
     * 
     * 
     * @param string $text �������� ���������
     * @return string ������ ���� ����
     */
    static public function cacheControl($text = 'public')
    {
        // ���� ��������� ����� ����� - ����-��� ����������� �� ����������������� �������� �������� �� ������� � ������ ����
        if (is_int($text))
        {
            // ���� �������� ����� ������ 7 ��� ��������� � ������������� �������� max-age
            if ($text > 7)
            {
                $text = 1;
                $text = $cacheControlArray[$text];
            }
            else 
            {
                $text = 'max-age='.$text;
            }
        }
        return '<meta http-equiv="cache-control" content="'.$text.'">';
    }
    
    
    /**
     * ���������� ������ �������� content-type
     * 
     * <meta http-equiv="content-type" content="MINE-���; charset=������� ��������">
     * 
     * @param string $charset ���������, �� ��������� windows-1251
     * @param string $content MINE-���,  �� ��������� text/html
     * @return string ������ ���� ����
     */
    static public function contentType($charset = 'windows-1251',$content = 'text/html')
    {
        return '<meta http-equiv="content-type" content="'.$content.'; charset='.$charset.'">';
    }

   /**
    * ���������� ������ �������� description
    * 
    * <meta name="description" content="����� ��������">
    * 
    * @param string $text ��������
    * @return string
    */
    static public function description($text = '')
    {
        return '<meta name="description" content="'.$text.'">';
    }
    
   /**
    * ���������� ������ �������� keywords
    *
    * <meta name="keywords" content="�������� �����">
    * 
    * @param string $text ������ �������� ���� ����� �������
    * @return string
    */
    static public function keywords($text = '')
    {
        return '<meta name="keywords" content="'.$text.'">';
    }
    
    
/**
 * ���������� ������ ����-���� Robots
 * ���������� ����������� �����
 * ����������� ��������
 * 1. index - �� ���������
 * 2. follow - ��������� �� ������� � ������ ��������
 * 3. all - ��������� 2-� ���������� ������ index � follow
 * 4. noindex - ��������� ����������
 * 5. nofollow - ��������� ������� �� ������� � ������ ��������
 * 6. none - ��������� 2-� ���������� ������ noindex � nofollow
 *
 * <meta name="robots" content="���� �� ���� ������������� ����">
 * 
 * @param mixed $text
 * @return string
 */
    static public function robots($text = 'none')
    {
        // ���� ��������� ����� ����� - ����-��� ����������� �� ����������������� �������� �������� �� ������� � ������ ����
        if (is_int($text))
        {
            // ���� �������� ����� ������ 7 ��� ��������� � ������������� �������� max-age
            if ($text > 6)
            {
                $text = 6;
                $text = $robotsArray[$text];
            }
        }
        
        return '<meta name="robots" content="'.$text.'">';
    }
}