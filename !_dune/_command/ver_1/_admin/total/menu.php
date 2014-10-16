<?php

$menu_left[0] = array(
					'name' => 'Настройки',
					'command' => '',
					'access' 	=> 500,
					'items' => array(
								0 => array(
											'name' 		=> 'Основные',
											'command'	=> 'main',
											'access' 	=> 500
										  ),
									)
					  );
					  
$menu_left[1] = array(
					'name' => 'Системные действия',
					'command' => '',
					'access' 	=> 500,
					'items' => array(
								0 => array(
											'name' 		=> 'База',
											'command'	=> 'db',
											'access' 	=> 500
										  ),
								1 => array(
											'name' 		=> 'Статистика',
											'command'	=> 'statistics',
											'access' 	=> 500
										  ),
								2 => array(
											'name' 		=> 'Кэш',
											'command'	=> 'cache',
											'access' 	=> 500
										  ),
										  
									)
					  );					  