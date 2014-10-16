<?php
/**
*	Класс для инициилизации и фильтрования управляющих входных параметров
*	Анализирует массивы $_GET, $_POST, $_COOKIE
* 
* ----------------------------------------------------
* | Библиотека: Dune                                  |
* | Файл: Request.php                                 |
* | В библиотеке: Dune/Request.php                    |
* | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>       |
* | Версия: 1.00                                      |
* | Сайт: www.rznlf.ru                                |
* ----------------------------------------------------
* 
*/

class Dune_Filter_Request extends Dune_Filter_Parent_Request
{

public function __construct($name,$def = 0,$filter = 'd',$prioritet = 'pg')
{
    parent::__construct($name,$def,$filter,$prioritet);
}

}