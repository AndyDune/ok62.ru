<?php
$post = Dune_Filter_Post_Total::getInstance();
    
switch ($post->_do_) {
	case 'clear_cache':
	    $cache = Dune_Zend_Cache::getInstance();
	    $cache->clean();
	break;

	case 'clear_temp_pics':
	    $d = new Dune_Directory_Delete($_SERVER['DOCUMENT_ROOT'] . '/_temp/catalogue');
	    $d->deleteSubFolders();
	    $d = new Dune_Directory_Delete($_SERVER['DOCUMENT_ROOT'] . '/_temp/data');
	    $d->deleteSubFolders();
	break;
	
	
	default:
	break;
}
