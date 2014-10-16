<?php ## Главный конфигурационный файл сайта.
// Подключается ко всем сценариям (автоматически или вручную)

if (!defined("PATH_SEPARATOR"))
  define("PATH_SEPARATOR", getenv("COMSPEC")? ";" : ":");
//ini_set("include_path", ini_get("include_path").PATH_SEPARATOR.dirname(__FILE__));

//ini_set("include_path", PATH_SEPARATOR.dirname(__FILE__));

//ini_set("include_path", dirname(__FILE__) . PATH_SEPARATOR . ini_get("include_path"));

//ini_set("include_path", ini_get("include_path").PATH_SEPARATOR.getenv("DOCUMENT_ROOT")."/lib/php");


function __autoload($className)
{
//	$path = str_replace('_','/',$className).'.php';
	$path = dirname(__FILE__) . DIRECTORY_SEPARATOR . str_replace('_','/',$className) . '.php';
	if ($f = @fopen($path, "r", true))
	{
	    fclose($f);
	    include_once($path);
		return true;
	}
	else 
		return false;
}


if(!function_exists('image_type_to_extension'))
{
/*    
   function image_type_to_extension($imagetype)
   {
       if(empty($imagetype)) return false;
       switch($imagetype)
       {
           case IMAGETYPE_GIF    : return 'gif';
           case IMAGETYPE_JPEG    : return 'jpg';
           case IMAGETYPE_PNG    : return 'png';
           case IMAGETYPE_SWF    : return 'swf';
           case IMAGETYPE_PSD    : return 'psd';
           case IMAGETYPE_BMP    : return 'bmp';
           case IMAGETYPE_TIFF_II : return 'tiff';
           case IMAGETYPE_TIFF_MM : return 'tiff';
           case IMAGETYPE_JPC    : return 'jpc';
           case IMAGETYPE_JP2    : return 'jp2';
           case IMAGETYPE_JPX    : return 'jpf';
           case IMAGETYPE_JB2    : return 'jb2';
           case IMAGETYPE_SWC    : return 'swc';
           case IMAGETYPE_IFF    : return 'aiff';
           case IMAGETYPE_WBMP    : return 'wbmp';
           case IMAGETYPE_XBM    : return 'xbm';
           default                : return false;
       }
   }
*/   
    function image_type_to_extension($type, $dot = true)
    {
        $e = array ( 1 => 'gif', 'jpg', 'png', 'swf', 'psd', 'bmp',
            'tiff', 'tiff', 'jpc', 'jp2', 'jpf', 'jb2', 'swc',
            'aiff', 'wbmp', 'xbm');

        // We are expecting an integer.
        $type = (int)$type;
        if (!$type) {
            trigger_error( '...come up with an error here...', E_USER_NOTICE );
            return null;
        }

        if ( !isset($e[$type]) ) {
            trigger_error( '...come up with an error here...', E_USER_NOTICE );
            return null;
        }

        return ($dot ? '.' : '') . $e[$type];
    }
    
   
}