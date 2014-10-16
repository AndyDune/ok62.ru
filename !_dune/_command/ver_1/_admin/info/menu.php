<?php

$menu_left[0] = array(
					'name' => 'Настройки',
					'command' => '',
					'access' 	=> 500,
					'items' => array(
								0 => array(
											'name' 		=> 'Статистика',
											'command'	=> 'main',
											'access' 	=> 500
										  ),
									)
					  );
					  
$menu_left[1] = array(
					'name' => 'Статьи',
					'command' => '',
					'access' 	=> 500,
					'items' => array(
								0 => array(
											'name' 		=> 'Разделы',
											'command'	=> 'article/sections',
											'access' 	=> 500
										  ),
								1 => array(
											'name' 		=> 'Статьи',
											'command'	=> 'article/texts',
											'access' 	=> 500
										  ),
								2 => array(
											'name' 		=> 'Комментарии',
											'command'	=> 'article/comments',
											'access' 	=> 500
										  ),
										  
									)
					  );					  
$menu_left[2] = array(
					'name' => 'Новости',
					'command' => '',
					'access' 	=> 500,
					'items' => array(
								0 => array(
											'name' 		=> 'Разделы',
											'command'	=> 'news/sections',
											'access' 	=> 500
										  ),
								1 => array(
											'name' 		=> 'Статьи',
											'command'	=> 'news/list',
											'access' 	=> 500
										  ),
								2 => array(
											'name' 		=> 'Комментарии',
											'command'	=> 'news/comments',
											'access' 	=> 500
										  ),
										  
									)
					  );					  					  