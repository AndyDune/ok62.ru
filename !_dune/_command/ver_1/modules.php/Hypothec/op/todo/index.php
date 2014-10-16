<?php

$it = Dune_Filter_Get_NoFilter::getInstance('it');

switch ($it->get()) {
	case 'add_to_compare':
	    $pprogram_id = Dune_Filter_Get_Digit::getInstance('pprogram_id');
	    if ($pprogram_id->have())
	    {
	        $cooc = Dune_Cookie_ArraySingleton::getInstance('compare');
	        Dune_BeforePageOut::registerObject($cooc);
	        if ($cooc->count() < 13)
	           $cooc[$pprogram_id->get()] = $pprogram_id->get();
	    }
		
	break;
	case 'delete_from_compare':
	    $pprogram_id = Dune_Filter_Get_Digit::getInstance('pprogram_id');
	    if ($pprogram_id->have())
	    {
	        $cooc = Dune_Cookie_ArraySingleton::getInstance('compare');
	        Dune_BeforePageOut::registerObject($cooc);
	        unset($cooc[$pprogram_id->get()]);
	    }
		
	break;

	default:
		break;
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

$this->results['exit'] = 'exit';