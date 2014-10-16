<?php
$post = Dune_Filter_Post_Total::getInstance();
switch ($post->_do_) {
	case 'save_main':
		 $sys_dbm = Dune_AsArray_DbmSingletonSystem::getInstance();
		 $sys_dbm['allow_reg'] = $post->getDigit('allow_reg', 0);	
	break;

	default:
	break;
}
