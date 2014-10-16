<?php
function __autoloadSpecial($className)
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

