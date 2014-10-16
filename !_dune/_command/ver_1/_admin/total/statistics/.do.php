<?php
$post = Dune_Filter_Post_Total::getInstance();
$db = Dune_MysqliSystem::getInstance();
if ($post->time_begin)
    $session->time_begin = $post->time_begin;
if ($post->time_end)
    $session->time_end = $post->time_end;

    $session->status = $post->status;
    $session->edinstvo = $post->edinstvo;
    $session->fiz = $post->fiz;
    $session->user = $post->user;
    
$session->count_in_time = null;
$session->result_array = false;
    
switch ($post->_do_) {
	case 'get_count_total_in_interval':
	    $array = false;
	    if ($session->fiz)
		  $q = 'SELECT count(distinct o.id)
		        FROM unity_catalogue_object as o, dune_auth_user_active as u
		        WHERE o.activity = 1 AND o.time_insert > ? AND o.time_insert < ?
		              AND u.status < 10
		              AND u.id = o.saler_id
		              ';
		else if ($session->edinstvo)
		  $q = 'SELECT count(o.id)
		        FROM unity_catalogue_object as o
		        WHERE o.activity = 1 AND o.time_insert > ? AND o.time_insert < ?
		              AND o.edinstvo = 1
		              ';
		else if ($session->user)
		  $q = 'SELECT count(distinct o.id) as `count`
		        FROM unity_catalogue_object as `o`, dune_auth_user_active as `u`
		        WHERE o.activity = 1 AND o.time_insert > ? AND o.time_insert < ?
		              AND u.id = ' . (int)$session->user . '
		              AND u.id = o.saler_id
		              ';
		  
		else if ($session->status)
		{
		  $q = 'SELECT u.*, count(o.id) as `count`
		        FROM unity_catalogue_object as `o`, dune_auth_user_active as `u`
		        WHERE o.activity = 1 AND o.time_insert > ? AND o.time_insert < ?
		              AND u.status = ' . (int)$session->status . '
		              AND u.id = o.saler_id
		              GROUP BY u.id';
		  $q2 = 'SELECT count(distinct o.id) as `count`
		        FROM unity_catalogue_object as `o`, dune_auth_user_active as `u`
		        WHERE o.activity = 1 AND o.time_insert > ? AND o.time_insert < ?
		              AND u.status = ' . (int)$session->status . '
		              AND u.id = o.saler_id
		              ';
		  
		  $array = true;
		}
		else  
		  $q = 'SELECT count(*)
		        FROM unity_catalogue_object
		        WHERE activity = 1 AND time_insert > ? AND time_insert < ?';
		  
		 if ($array)
		 {
		  $session->result_array = $db->query($q, array($session->time_begin, $session->time_end), Dune_MysqliSystem::RESULT_ASSOC);
		  $session->count_in_time = $db->query($q2, array($session->time_begin, $session->time_end), Dune_MysqliSystem::RESULT_EL);
		 }
		 else 
		  $session->count_in_time = $db->query($q, array($session->time_begin, $session->time_end), Dune_MysqliSystem::RESULT_EL);
	break;

	default:
	break;
}
