<?php
/************************************************************************/
/* Модуль ИПОТЕКА ЗАО "Группа компаний "ЕДИНСТВО"           */
/* Copyright (c) 2007 by Romanoff Vlad                                  */
/*                                                                      */
/************************************************************************/
//if (!defined('MODULE_FILE')) {
//    die ("Access Denied!");}


//require_once("mainfile.php");
//include_once('includes/smarty/NukeSmarty.php');
//include_once('includes/lib/HypBank.php');
//include_once('includes/lib/HypCondition.php');

$module_name = basename(dirname(__FILE__));
$pagetitle = "Ипотека Рязань, Ипотечное кредитование, Ипотечные программы, Условия получения ипотеки";
$index=1;
define('INDEX_FILE', true);

define('HYPOTHEC_SHOW_ALL_BANKS', false);


$img_path="http://edinstvo62.ru/modules/Hypothec/images/";

/************************************************************************/
/************************ Показывает меню *******************************/
/************************************************************************/

function Menu($id)  {
     global $pagetitle, $module_name, $bgcolor1, $bgcolor2, $bgcolor3, $textcolor1, $textcolor2, $textcolor3;
     $output = '<a href="/modules.php?name=Hypothec">Ипотека</a> -> &nbsp;&nbsp;&nbsp;&nbsp;';

     if ($id=="ShowNovostroiBanks")       
     { $output .= "<font color=\"$bgcolor3\"><b>Новостройку в ипотеку</b></font>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; }
       else                { $output .= "<a href=\"/modules.php?name=Hypothec&op=ShowNovostroiBanks\">Новостройку в ипотеку</a>      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; }

     if ($id=="ShowVtorBanks")      { $output .= "<font color=\"$bgcolor3\"><b>Готовое жилье в ипотеку</b></font>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; }
       else                { $output .= "<a href=\"/modules.php?name=Hypothec&op=ShowVtorBanks\">Готовое жилье в ипотеку</a>      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; }

     if ($id=="GiveCreditConditions")       { $output .= "<font color=\"$bgcolor3\"><b>Условия выдачи ипотечных кредитов</b></font>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; }
       else                { $output .= "<a href=\"/modules.php?name=Hypothec&op=GiveCreditConditions\">Условия выдачи ипотечных кредитов</a>      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; }

     if ($id=="ShowAllPrograms")     { $output .= "<font color=\"$bgcolor3\"><b>Ипотечные программы</b></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; }
       else                { $output .= "<a href=\"/modules.php?name=Hypothec&op=ShowAllPrograms\">Ипотечные программы</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; }

     $output .= "<br><br><hr>";

     echo "$output";

     switch ($id) {
      case "ShowNovostroiBanks"      : { include("modules/Hypothec/templates/"); break; }
      case "ShowVtorBanks"     : { include("modules/Hypothec/templates/"); break; }
      case "GiveConditions"      : { include("modules/Hypothec/templates/"); break; }
      case "ShowAllPrograms"    : { include("modules/Hypothec/templates/"); break; }
      case "ShowHypothecClub"    : { include("modules/Hypothec/templates/"); break; }
     }

}
 

$vars = Dune_Variables::getInstance();
$vars->pensia_age = 65;
$vars->text_age_to_pensia_near = 'Ипотечный кредит должен быть возвращён до наступления максимально допустимого кредитной программой возраста.
 ';
$vars->text_creditperiod_out = 'Согласно указанному Вами возрасту при подборе программы, Вы не можете получить кредит.';
$vars->text_more_then_age_max = 'Указаный при подборе возраст превышает максимально допустимый.';

$module = new Dune_Include_Module('db:hypothec:glassary.get.list');
$module->make();
$vars->glassary = $module->getResult('array');

/************************************************************************/
/************************* ГЛАВНОЕ МЕНЮ МОДУЛЯ **************************/
/************************************************************************/
    $crumbs = Dune_Display_BreadCrumb::getInstance();
    $crumbs->addCrumb('Главная', '/');
    $crumbs->addCrumb('Ипотека', '/modules.php?name=Hypothec');
    $crumbs->setMinCount(1);

    $get = Dune_Filter_Get_Total::getInstance();
    $value_allow = new Dune_Data_Container_ValueAllow($get->op);
    $value_allow->registerDefault('Main');
    
/********** ФУНКЦИЯ ПОКАЗА СПИСКА БАНКОВ, РАБОТАЮЩИХ С ПЕРВИЧКОЙ ********/    
    $value_allow->register('ShowNovostroiBanks');
    
/********** ФУНКЦИЯ ПОКАЗА СПИСКА БАНКОВ, РАБОТАЮЩИХ СО ВТОРИЧКОЙ ********/    
    $value_allow->register('ShowVtorBanks');
    
/********** ФУНКЦИЯ ПОКАЗА ОБЩИХ УСЛОВИЙ ПРЕДОСТАВЛЕНИЯ КРЕДИТА***********/    
    $value_allow->register('GiveCreditConditions');
    
/******************** ФУНКЦИЯ ПОКАЗА ИПОТЕЧНЫХ ПРОГРАММ*******************/    
    $value_allow->register('ShowAllPrograms');
    
/******************** ФУНКЦИЯ ПОКАЗА ОДНОЙ ИПОТЕЧНОЙ ПРОГРАММЫ************/
    $value_allow->register('ShowFixedProgram');

/******************** ФУНКЦИЯ ПОКАЗА ОДНОЙ ИПОТЕЧНОЙ ПОДПРОГРАММЫ************/
    $value_allow->register('ShowFixedPProgram');
    
    $value_allow->register('ShowFixedProgramTest');
    
/******************** ФУНКЦИЯ ПОКАЗА ОДНОГО БАНКА*******************/    
    $value_allow->register('ShowFixedBank');
    
/******************** ФУНКЦИЯ ПОКАЗА Информации о ипотечном клубе*******************/    
    $value_allow->register('ShowHypothecClub');

    $value_allow->register('ShowFixedBank');
    
    $value_allow->register('ShowProgramsToCompare');
    $value_allow->register('ShowProgramsToCompareFull');

    $value_allow->register('SearchPrograms');
    
    $value_allow->register('ShowSearchPrograms');
    
    $value_allow->register('ShowAllBanks');
    $value_allow->register('Main');
    $value_allow->register('Articles');
    $value_allow->register('ArticleRead');
    $value_allow->register('MasterForProgram');
    $value_allow->register('MasterForProgramList');
    
    $value_allow->register('Calculation');
    $value_allow->register('CalculationList');
    $value_allow->register('CalculationListBegin');
    
    
    if (Dune_Variables::$userStatus > 999)
    {
        $value_allow->register('System');
    }
    
    $value_allow->register('Glossary');
    $value_allow->register('GlossaryOne');

    $value_allow->register('ShowHypothecClub');
    $value_allow->register('Show');

    
/******************** ФУНКЦИЯ ПОКАЗА Льготной ипотеки *******************/        
    $value_allow->register('Privilege');
    $value_allow->register('StroimVmeste');
    
  /******************** Действия без вывода информаии *******************/    
    $value_allow->register('todo');
    $value_allow->register('phpinfo');
    
    Dune_Include_Operation::$operationsFolder = 'op';
    
//    ob_start();
//    if (IsInternet() and ($value_allow->getValue() != 'ShowHypothecClub' and $value_allow->getValue() != 'Show'))
    if (false)
    {
        $operation = new Dune_Include_Operation('no', dirname(__FILE__)); // Раздел закрыт
    }
    else 
        $operation = new Dune_Include_Operation($value_allow->getValue(), dirname(__FILE__));     !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    
    $operation->parent_folder = dirname(__FILE__);
    $operation->img_path = $img_path;
	$operation->make();
	
	if ($operation->getResult('pagetitle'))
	   Dune_Variables::addTitle(trim($operation->getResult('pagetitle'), ' .') . '. ');
	
//	$main_text = ob_get_clean();
	$main_text = $operation->getOutput();

    if ($operation->getResult('exit'))
    {
        throw new Dune_Exception_Control_Goto();
    }
    
	    $operation_results = new Dune_Array_Container($operation->getResults());
	    
        $dvar = Dune_Variables::getInstance();           
        $dvar->no_right_col = 1;

    	Data_Edinstvo_Hypothec::prepare();
    	$menu = new Dune_Include_Module('menu:hypothec.left');
    	$menu->op = $value_allow->getValue();
    	$section = Dune_Filter_Get_HtmlSpecialChars::getInstance('section');
    	$menu->section = $section->get();
    	$menu->data = Data_Edinstvo_Hypothec::$leftMenu;
    	$menu->url = '/modules.php?name=Hypothec';
    	$menu->make();
    
    	$pagetitle = $operation->getResult('pagetitle');
    	$left_menu = $menu->getResult('text');
    	$vars = Dune_Variables::getInstance();
    	$vars->under_left_menu = '
    	
<style type="text/css">
<!--
#under-left-menu-1
{
background-color:#E3E3E3;
padding: 2px 0 6px 0;
margin: 0;
text-align:center;
}
#under-left-menu-1 p
{
padding: 0;
margin: 0;
}

#under-left-menu-1 p input
{
padding: 3px;
text-align:center;
}
#under-left-menu-1 p#sub-one
{
padding: 10px;
}

-->
</style>

<div id="under-left-menu-1">
<p style="font-weight:bold; font-size:16px">Расчет</p>
<p style="padding: 8px 0 3px 0;">Стоимость объекта</p>
<p style=" padding:0; margin:0;"><input name="price" type="text" /></p>
<p style="padding: 8px 0 3px 0;">Возраст заемщика</p>
<p style=" padding:0; margin:0;"><input name="age" type="text" /></p>
<p style="padding: 8px 0 3px 0;">Первоначальный взнос</p>
<p style=" padding:0; margin:0;"><input name="age" type="text" /></p>
<p id="sub-one"><input name="11" type="submit" value="Вперед"/></p>
</div>

';    	
    	
    Dune_Static_StylesList::add('hypothec', 101);
    	
    $view = Dune_Zend_View::getInstance();
    $view->text = $main_text;
    
    $view->more_edit_menu = $left_menu;
    
    echo $view->render('bit/general/container_padding_for_auth');    
    	
