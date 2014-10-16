<?php

class Module_Display_Banners_Special extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    $url_base = 'data/banners/special';

    $array_result = array();
    
    $path = $_SERVER['DOCUMENT_ROOT'] . '/' . $url_base;
    if (is_dir($path))
    {
        $dir = new DirectoryIterator($path);
        foreach ($dir as $value)
        {
            if ($value->isDir() and !$value->isDot())
            {
                $url = $path. '/' . $value . '/text.php';
                if (is_file($url))
                {
                    $text = file_get_contents($url);
                    $path_pic = $path . '/' . $value . '/img';
                    if (is_dir($path_pic))
                    {
                        $dir_pic = new DirectoryIterator($path_pic);
                        foreach ($dir_pic as $value_1)
                        {
                            if ($value_1->isFile())
                            {
                                $url_pic = '/' . $url_base  . '/' . $value . '/img/' . $value_1;
                                $text = str_replace('{pic}', $url_pic, $text);
                                break;
                            }                    
                        }
                    }
                    $array_result[$value->getFilename()] = $text;
                }
            }
        }
    }
    ksort($array_result);
    if (count($array_result))
    {
        Dune_Static_StylesList::add('banners');
        echo '<div id="banners-special">';
        foreach ($array_result as $value)
        {
            echo '<div>';
            echo $value;
            echo '</div>';
        }
        echo '</div>';
    }
    
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    