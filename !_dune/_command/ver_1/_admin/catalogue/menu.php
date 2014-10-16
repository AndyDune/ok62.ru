<?php

$menu_left[0] = array(
					'name' => 'Главное',
					'command' => '',
					'access' 	=> 500,
					'items' => array(
								0 => array(
											'name' 		=> 'Адреса',
											'command'	=> 'adress',
											'access' 	=> 500
										  ),
									)
					  );
					  
$menu_left[1] = array(
					'name' => 'Объекты от адреса',
					'command' => '',
					'access' 	=> 500,
					'items' => array(
								0 => array(
											'name' 		=> 'Объекты, все',
											'command'	=> 'object',
											'access' 	=> 500
										  ),
								1 => array(
											'name' 		=> 'Объекты в городе',
											'command'	=> 'object/list/district/1',
											'access' 	=> 500
										  ),
										  
									)
					  );					  