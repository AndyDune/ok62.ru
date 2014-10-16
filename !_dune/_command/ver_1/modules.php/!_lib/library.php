<?
/************************************************************************/
/* Библиотека с функциями для работы с БД edinstvo                      */
/* Copyright (c) 2006 by Romanoff Vlad                                  */
/*                                                                      */
/************************************************************************/
//library.php


// *****************************************************************************
function connectToDB($serverName = false){
//переменные
$vars = Dune_Variables::getInstance();
$dbConn = $vars->hypoDBConn;
if (!$dbConn)
{
    $config = Dune_Zend_Config_Ini::getInstance('base');
    $userName = $config->mysql->hypo->username;
    $password = $config->mysql->hypo->passwd;
    $dbName   = $config->mysql->hypo->dbname;
    $dbConn = "";
    
      //соединение с БД
      $vars->hypoDBConn = $dbConn = mysql_connect($serverName, $userName, $password);
      if (!$dbConn){
       print "<h3>Есть проблема с соединением с БД...</h3>\n";
      } // end if
    
      $select = mysql_select_db($dbName);
      if (!$select){
        print mysql_error() . "<br>\n";
      } // end if
      mysql_query("SET NAMES 'cp1251'");
}
  return $dbConn;
} // end connectToDB


/************************************************************************/
/*************** Функция Определения продавца по IP адресу **************/
/************************************************************************/

function DefineSaler()  {
          // определение продавца
          
  $IP = $_SERVER['REMOTE_ADDR'];
  

  switch ($IP) {
   case "192.168.9.14" : { $salerID = 1; Break; }  // Жарикова Наталья
   case "192.168.9.13" : { $salerID = 2; Break; }  // Плоткин Вячеслав
   case "192.168.9.17" : { $salerID = 101; Break; }  // Кукина Рита
//   case "192.168.9.17" : { $salerID = 3; Break; }  // Гориславский Александр
   case "192.168.9.24" : { $salerID = 4; Break; }  // Прохина Елена
   case "192.168.9.6"  : { $salerID = 5; Break; }  // Шевякова Ирина
   case "192.168.9.4"  : { $salerID = 6; Break; }  // Дубовова Оксана
   case "192.168.9.19" : { $salerID = 7; Break; }  // Чекмарева Ирина
   case "192.168.9.8"  : { $salerID = 8; Break; }  // Горина Ольга
   case "192.168.9.77" : { $salerID = 9; Break; }  // Романов Владимир
   case "192.168.9.12" : { $salerID = 10; Break; } // Васильева Светлана
   case "192.168.9.22" : { $salerID = 11; Break; } // Семенкина Елена
   case "127.0.0.1"    : { $salerID = 12; Break; } // server
   case "192.168.9.16" : { $salerID = 13; Break; } // Левин Андрей
   case "192.168.9.5"  : { $salerID = 14; Break; } // Кандаков Илья
   case "192.168.9.18" : { $salerID = 15; Break; } // кто-то из зала переговоров
   default             : { $salerID = $IP; Break; }  // все, кроме наших
  }
  
  Return $salerID;

}



// *****************************************************************************
function IsInternet(){  // определяет, где запущен сайт: в инете или нет.

 if (($_SERVER['HTTP_HOST'] == "www.edinstvo62.ru") or ($_SERVER['HTTP_HOST'] == "edinstvo62.ru")) {
 	Return true;
 }
 else {
 	Return false;
 }

} // end 



// *****************************************************************************
function identByNumber($number){   // функция идентификации типа объекта по его номеру

       	$firstSymbol = substr($number, 0, 1);  // вырезание 1-го символа номера
       	
         switch ($firstSymbol) {
         	case "K": { $type="store"; break; }
         	case "H": { $type="office"; break; }
         	case "A": { $type="garage"; break; }
         	default : { $type="apartment"; break; }
         }

 return $type; // возвращает префикс таблицы  
}
// *****************************************************************************
function identByFileName($filename){   // функция идентификации типа объекта по имени таблицы

      if (!(strpos($filename, "apartment") === false)) {
      	$type = "apartment";
      } 
      else 
      if (!(strpos($filename, "office") === false)) {
      	$type = "office";
      } 
      else 
      if (!(strpos($filename, "garage") === false)) {
      	$type = "garage";
      } 
      else 
      if (!(strpos($filename, "store") === false)) {
      	$type = "store";
      } 
      else {
      	$type = "unknown";
      }
  
	
	
 return $type; // возвращает префикс таблицы  
}

// *****************************************************************************
//Функция для динамического изменения физического размера jpeg - файла.
// img.php?src={картинка}&w={максимальная ширина}&h={максимальная высота}&q={качество jpeg-сжатия*}
// При этом размер картинки будет определён пропорциональным картинке прямоугольником вписаным в заданные максимальные размеры.
// Картинка никуда не сохраняется, генерируется и отображается.

function Image2Preview(
                       $img,   // путь к исходной картинке
                       $w,     // макс. ширина
                       $h      // макс. высота
                       ) {

	$quality = 70;

	list($width, $height) = getimagesize($img);

	$newheight = $h;
	$temp = $height/$newheight;

	$newwidth = $width/$temp;

	if ($newwidth > $w) {
		$newwidth = $w;
		$temp = $width/$newwidth;
		$newheight = $height/$temp;
	}


	$thumb = imagecreatetruecolor($newwidth, $newheight);
	$source = imagecreatefromjpeg($img);

	imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

//  return imagejpeg($thumb, null, $quality);
  return $thumb;
} // end ImagePreview



// *****************************************************************************
// ПЕРЕВОДИТ ДАТУ ИЗ 29.11.2006 в 1) Двадцать девятое ноября две тысячи шестого года
//                                2) 29 ноября 2006 года
function Date2Propis($date, $type) {
   $str="";

// Меняем
   $date = str_replace(' ','',$date);
   $date = str_replace(',','.',$date);
   $date = trim($date);

   $field = explode(".", $date);

   if ($type == "1") {
	   switch ($field[0]) {
	    case "1":      { $str .= "Первое ";     break; }
	    case "01":     { $str .= "Первое ";     break; }
	    case "2":      { $str .= "Второе ";     break; }
	    case "02":     { $str .= "Второе ";     break; }
	    case "3":      { $str .= "Третье ";     break; }
	    case "03":     { $str .= "Третье ";     break; }
	    case "4":      { $str .= "Четвертое ";     break; }
	    case "04":     { $str .= "Четвертое ";     break; }
	    case "5":      { $str .= "Пятое ";     break; }
	    case "05":     { $str .= "Пятое ";     break; }
	    case "6":      { $str .= "Шестое ";     break; }
	    case "06":     { $str .= "Шестое ";     break; }
	    case "7":      { $str .= "Седьмое ";     break; }
	    case "07":     { $str .= "Седьмое ";     break; }
	    case "8":      { $str .= "Восьмое ";     break; }
	    case "08":     { $str .= "Восьмое ";     break; }
	    case "9":      { $str .= "Девятое ";     break; }
	    case "09":     { $str .= "Девятое ";     break; }
	    case "10":     { $str .= "Десятое ";     break; }
	    case "11":     { $str .= "Одиннадцатое ";     break; }
	    case "12":     { $str .= "Двенадцатое ";     break; }
	    case "13":     { $str .= "Тринадцатое ";     break; }
	    case "14":     { $str .= "Четырнадцатое ";     break; }
	    case "15":     { $str .= "Пятнадцатое ";     break; }
	    case "16":     { $str .= "Шестнадцатое ";     break; }
	    case "17":     { $str .= "Семнадцатое ";     break; }
	    case "18":     { $str .= "Восемнадцатое ";     break; }
	    case "19":     { $str .= "Девятнадцатое ";     break; }
	    case "20":     { $str .= "Двадцатое ";     break; }
	    case "21":     { $str .= "Двадцать первое ";     break; }
	    case "22":     { $str .= "Двадцать второе ";     break; }
	    case "23":     { $str .= "Двадцать третье ";     break; }
	    case "24":     { $str .= "Двадцать четвертое ";     break; }
	    case "25":     { $str .= "Двадцать пятое ";     break; }
	    case "26":     { $str .= "Двадцать шестое ";     break; }
	    case "27":     { $str .= "Двадцать седьмое ";     break; }
	    case "28":     { $str .= "Двадцать восьмое ";     break; }
	    case "29":     { $str .= "Двадцать девятое ";     break; }
	    case "30":     { $str .= "Тридцатое ";     break; }
	    case "31":     { $str .= "Тридцать первое ";     break; }
	   }
   }
   else  {
   	 $str .= $field[0]." ";
   }




   switch ($field[1]) {
    case "1":      { $str .= "января ";     break; }
    case "01":     { $str .= "января ";     break; }
    case "2":      { $str .= "февраля ";     break; }
    case "02":     { $str .= "февраля ";     break; }
    case "3":      { $str .= "марта ";     break; }
    case "03":     { $str .= "марта ";     break; }
    case "4":      { $str .= "апреля ";     break; }
    case "04":     { $str .= "апреля ";     break; }
    case "5":      { $str .= "мая ";     break; }
    case "05":     { $str .= "мая ";     break; }
    case "6":      { $str .= "июня ";     break; }
    case "06":     { $str .= "июня ";     break; }
    case "7":      { $str .= "июля ";     break; }
    case "07":     { $str .= "июля ";     break; }
    case "8":      { $str .= "августа ";     break; }
    case "08":     { $str .= "августа ";     break; }
    case "9":      { $str .= "сентября ";     break; }
    case "09":     { $str .= "сентября ";     break; }
    case "10":     { $str .= "октября ";     break; }
    case "11":     { $str .= "ноября ";     break; }
    case "12":     { $str .= "декабря ";     break; }
   }

   if ($type == "1") {
	   switch ($field[2]) {
	    case "2006":     { $str .= "две тысячи шестого года";     break; }
	    case "06":       { $str .= "две тысячи шестого года";     break; }
	    case "2007":     { $str .= "две тысячи седьмого года";     break; }
	    case "07":       { $str .= "две тысячи седьмого года";     break; }
	    case "2008":     { $str .= "две тысячи восьмого года";     break; }
	    case "08":       { $str .= "две тысячи восьмого года";     break; }
	    case "2009":     { $str .= "две тысячи девятого года";     break; }
	    case "09":       { $str .= "две тысячи девятого года";     break; }
	    case "2010":     { $str .= "две тысячи десятого года";     break; }
	    case "10":       { $str .= "две тысячи десятого года";     break; }
	    case "2011":     { $str .= "две тысячи одиннадцатого года";     break; }
	    case "11":       { $str .= "две тысячи одиннадцатого года";     break; }
	    case "2012":     { $str .= "две тысячи двенадцатого года";     break; }
	    case "12":       { $str .= "две тысячи двенадцатого года";     break; }
	    case "2013":     { $str .= "две тысячи тринадцатого года";     break; }
	    case "13":       { $str .= "две тысячи тринадцатого года";     break; }
	    case "2014":     { $str .= "две тысячи четырнадцатого года";     break; }
	    case "14":       { $str .= "две тысячи четырнадцатого года";     break; }
	    case "2015":     { $str .= "две тысячи пятнадцатого года";     break; }
	    case "15":       { $str .= "две тысячи пятнадцатого года";     break; }
	    case "2016":     { $str .= "две тысячи шестнадцатого года";     break; }
	    case "16":       { $str .= "две тысячи шестнадцатого года";     break; }
	    case "2017":     { $str .= "две тысячи семнадцатого года";     break; }
	    case "17":       { $str .= "две тысячи семнадцатого года";     break; }
	   }
   }
   else  {
   	 $str .= $field[2]." года";
   }

    return $str;
}



// *****************************************************************************
//        Сумма прописью

//Функция перевода цифр в сумму прописью. Подаете цифру (разделитель рублей и копеек - точка или запятая, максимальная сумма - миллиард рублей), на выходе у функции - сумма прописью.
//Юрий Денисенко, denik@aport.ru  http://poligraf.h1.ru

function Number($c)
{
$c=str_pad($c,3,"0",STR_PAD_LEFT);
//---------сотни
switch  ($c[0])
{
case 0:
$d[0]="";
break;
case 1:
$d[0]="сто";
break;
case 2:
$d[0]="двести";
break;
case 3:
$d[0]="триста";
break;
case 4:
$d[0]="четыреста";
break;
case 5:
$d[0]="пятьсот";
break;
case 6:
$d[0]="шестьсот";
break;
case 7:
$d[0]="семьсот";
break;
case 8:
$d[0]="восемьсот";
break;
case 9:
$d[0]="девятьсот";
break;
}
//--------------десятки
switch  ($c[1])
{
case 0:
$d[1]="";
break;
case 1:
{
$e=$c[1].$c[2];
switch ($e)
{
case 10:
$d[1]="десять";
break;
case 11:
$d[1]="одиннадцать";
break;
case 12:
$d[1]="двенадцать";
break;
case 13:
$d[1]="тринадцать";
break;
case 14:
$d[1]="четырнадцать";
break;
case 15:
$d[1]="пятнадцать";
break;
case 16:
$d[1]="шестнадцать";
break;
case 17:
$d[1]="семнадцать";
break;
case 18:
$d[1]="восемнадцать";
break;
case 19:
$d[1]="девятнадцать";
break;
};
}
break;
case 2:
$d[1]="двадцать";
break;
case 3:
$d[1]="тридцать";
break;
case 4:
$d[1]="сорок";
break;
case 5:
$d[1]="пятьдесят";
break;
case 6:
$d[1]="шестьдесят";
break;
case 7:
$d[1]="семьдесят";
break;
case 8:
$d[1]="восемьдесят";
break;
case 9:
$d[1]="девяносто";
break;
}
//--------------единицы
$d[2]="";
if ($c[1]!=1):
switch  ($c[2])
{
case 0:
$d[2]="";
break;
case 1:
$d[2]="один";
break;
case 2:
$d[2]="два";
break;
case 3:
$d[2]="три";
break;
case 4:
$d[2]="четыре";
break;
case 5:
$d[2]="пять";
break;
case 6:
$d[2]="шесть";
break;
case 7:
$d[2]="семь";
break;
case 8:
$d[2]="восемь";
break;
case 9:
$d[2]="девять";
break;
}
endif;

return $d[0].' '.$d[1].' '.$d[2];

}


function NumberSotih($c)    // Только для ЦЕЛЫХ и СОТЫХ!!! т.к. "одна" и "две" целые и сотые, а не "один" и "два"
{
$c=str_pad($c,3,"0",STR_PAD_LEFT);
//---------сотни
switch  ($c[0])
{
case 0:
$d[0]="";
break;
case 1:
$d[0]="сто";
break;
case 2:
$d[0]="двести";
break;
case 3:
$d[0]="триста";
break;
case 4:
$d[0]="четыреста";
break;
case 5:
$d[0]="пятьсот";
break;
case 6:
$d[0]="шестьсот";
break;
case 7:
$d[0]="семьсот";
break;
case 8:
$d[0]="восемьсот";
break;
case 9:
$d[0]="девятьсот";
break;
}
//--------------десятки
switch  ($c[1])
{
case 0:
$d[1]="";
break;
case 1:
{
$e=$c[1].$c[2];
switch ($e)
{
case 10:
$d[1]="десять";
break;
case 11:
$d[1]="одиннадцать";
break;
case 12:
$d[1]="двенадцать";
break;
case 13:
$d[1]="тринадцать";
break;
case 14:
$d[1]="четырнадцать";
break;
case 15:
$d[1]="пятнадцать";
break;
case 16:
$d[1]="шестнадцать";
break;
case 17:
$d[1]="семнадцать";
break;
case 18:
$d[1]="восемнадцать";
break;
case 19:
$d[1]="девятнадцать";
break;
};
}
break;
case 2:
$d[1]="двадцать";
break;
case 3:
$d[1]="тридцать";
break;
case 4:
$d[1]="сорок";
break;
case 5:
$d[1]="пятьдесят";
break;
case 6:
$d[1]="шестьдесят";
break;
case 7:
$d[1]="семьдесят";
break;
case 8:
$d[1]="восемьдесят";
break;
case 9:
$d[1]="девяносто";
break;
}
//--------------единицы
$d[2]="";
if ($c[1]!=1):
switch  ($c[2])
{
case 0:
$d[2]="";
break;
case 1:
$d[2]="одна";
break;
case 2:
$d[2]="две";
break;
case 3:
$d[2]="три";
break;
case 4:
$d[2]="четыре";
break;
case 5:
$d[2]="пять";
break;
case 6:
$d[2]="шесть";
break;
case 7:
$d[2]="семь";
break;
case 8:
$d[2]="восемь";
break;
case 9:
$d[2]="девять";
break;
}
endif;

return $d[0].' '.$d[1].' '.$d[2];

}
//--------------------------------------- // пропись суммы (руб. коп.)
function SumProp($sum)
{

// Проверка ввода
            $sum=str_replace(' ','',$sum);
            $sum = trim($sum);
            if ((!(@eregi('^[0-9]*'.'[,\.]'.'[0-9]*$', $sum)||@eregi('^[0-9]+$', $sum)))||($sum=='.')||($sum==',')) :
                return "Это не деньги: $sum";
                endif;
// Меняем запятую, если она есть, на точку
   $sum=str_replace(',','.',$sum);
   if($sum>=1000000000):
   return "Максимальная сумма &#151 один миллиард рублей минус одна копейка";
   endif;
// Обработка копеек
     $rub=floor($sum);
     $kop=100*round($sum-$rub,2);
     $kop.=" коп.";
      if (strlen($kop)==6):
      $kop="0".$kop;
      endif;
// Выясняем написание слова 'рубль'
$one = substr($rub, -1);
$two = substr($rub, -2);
if ($two>9&&$two<21):
 $namerub=") рублей";

elseif ($one==1):
  $namerub=") рубль";

elseif ($one>1&&$one<5):
  $namerub=") рубля";

else:
  $namerub=") рублей";

endif;
if($rub=="0"):
//return "Ноль рублей $kop";
return "Ноль) рублей";
endif;
//----------Сотни
$sotni= substr($rub, -3);
$nums=Number($sotni);
if ($rub<1000):
return ucfirst(trim("$nums$namerub"));
endif;
//----------Тысячи
if ($rub<1000000):
$ticha=substr(str_pad($rub,6,"0",STR_PAD_LEFT),0,3);
else:
$ticha=substr($rub,strlen($rub)-6,3);
endif;
$one = substr($ticha, -1);
$two = substr($ticha, -2);
if ($two>9&&$two<21):

 $name1000=" тысяч";
elseif ($one==1):

  $name1000=" тысяча";
elseif ($one>1&&$one<5):

  $name1000=" тысячи";
else:

  $name1000=" тысяч";
endif;
$numt=Number($ticha);
if ($one==1&&$two!=11):
$numt=str_replace('один','одна',$numt);
endif;
if ($one==2):
$numt=str_replace('два','две',$numt);
$numt=str_replace('двед','двад',$numt);
endif;
if  ($ticha!='000'):
$numt.=$name1000;
endif;
if ($rub<1000000):
return ucfirst(trim("$numt $nums$namerub"));
endif;
//----------Миллионы
$million=substr(str_pad($rub,9,"0",STR_PAD_LEFT),0,3);
$one = substr($million, -1);
$two = substr($million, -2);
if ($two>9&&$two<21):

 $name1000000=" миллионов";
elseif ($one==1):

  $name1000000=" миллион";
elseif ($one>1&&$one<5):

  $name1000000=" миллиона";
else:

  $name1000000=" миллионов";
endif;
$numm=Number($million);
$numm.=$name1000000;

return ucfirst(trim("$numm $numt $nums$namerub"));

}
//--------------------------------------- // Пропись квадратных метров ЦЕЛЫХ
function AreaProp1($sum)
{

// Проверка ввода
            $sum=str_replace(' ','',$sum);
            $sum = trim($sum);
            if ((!(@eregi('^[0-9]*'.'[,\.]'.'[0-9]*$', $sum)||@eregi('^[0-9]+$', $sum)))||($sum=='.')||($sum==',')) :
                return "Это не площадь: $sum";
                endif;
// Меняем запятую, если она есть, на точку
   $sum=str_replace(',','.',$sum);

   if($sum>=1000000000):
     return "Максимальная сумма &#151 один миллиард целых минус одна сотая";
   endif;

     $rub=floor($sum);
     $kop=100*round($sum-$rub,2);

// Обработка сотых



// Выясняем написание слова 'целая'
$one = substr($rub, -1);
$two = substr($rub, -2);

if ($two>9&&$two<21):
 $namerub="целых";

elseif ($one==1):
  $namerub="целая";

elseif ($one>1&&$one<4):
  $namerub="целые";

else:
  $namerub="целых";

endif;

if($rub=="0"):
return "Ноль целых";
endif;


//----------Сотни
$sotni= substr($rub, -3);
$nums=NumberSotih($sotni);
if ($rub<1000):
return trim("$nums $namerub");
endif;
//----------Тысячи
if ($rub<1000000):
$ticha=substr(str_pad($rub,6,"0",STR_PAD_LEFT),0,3);
else:
$ticha=substr($rub,strlen($rub)-6,3);
endif;
$one = substr($ticha, -1);
$two = substr($ticha, -2);
if ($two>9&&$two<21):

 $name1000=" тысяч";
elseif ($one==1):

  $name1000=" тысяча";
elseif ($one>1&&$one<5):

  $name1000=" тысячи";
else:

  $name1000=" тысяч";
endif;
$numt=NumberSotih($ticha);
if ($one==1&&$two!=11):
$numt=str_replace('один','одна',$numt);
endif;
if ($one==2):
$numt=str_replace('два','две',$numt);
$numt=str_replace('двед','двад',$numt);
endif;
if  ($ticha!='000'):
$numt.=$name1000;
endif;
if ($rub<1000000):
return trim("$numt $nums $namerub");
endif;
//----------Миллионы
$million=substr(str_pad($rub,9,"0",STR_PAD_LEFT),0,3);
$one = substr($million, -1);
$two = substr($million, -2);
if ($two>9&&$two<21):

 $name1000000=" миллионов";
elseif ($one==1):

  $name1000000=" миллион";
elseif ($one>1&&$one<5):

  $name1000000=" миллиона";
else:

  $name1000000=" миллионов";
endif;
$numm=NumberSotih($million);
$numm.=$name1000000;

return trim("$numm $numt $nums $namerub");

}
//--------------------------------------- // Пропись квадратных метров СОТЫХ
function AreaProp2($sum)
{

// Проверка ввода
            $sum=str_replace(' ','',$sum);
            $sum = trim($sum);
            if ((!(@eregi('^[0-9]*'.'[,\.]'.'[0-9]*$', $sum)||@eregi('^[0-9]+$', $sum)))||($sum=='.')||($sum==',')) :
                return "Это не площадь: $sum";
                endif;
// Меняем запятую, если она есть, на точку
   $sum=str_replace(',','.',$sum);

   if($sum>=1000000000):
     return "Максимальная сумма &#151 один миллиард целых минус одна сотая";
   endif;

     $rub=floor($sum);
     $kop=100*round($sum-$rub,2);



// Выясняем написание слова 'сотая'
$one = substr($rub, -1);
$two = substr($rub, -2);

if ($two>9&&$two<21):
 $namerub="сотых";

elseif ($one==1):
  $namerub="сотая";

elseif ($one>1&&$one<4):
  $namerub="сотые";

else:
  $namerub="сотых";

endif;

if($rub=="0"):
return "ноль сотых";
endif;


//----------Сотни
$sotni= substr($rub, -3);
$nums=NumberSotih($sotni);
if ($rub<1000):
return trim("$nums $namerub");
endif;
//----------Тысячи
if ($rub<1000000):
$ticha=substr(str_pad($rub,6,"0",STR_PAD_LEFT),0,3);
else:
$ticha=substr($rub,strlen($rub)-6,3);
endif;
$one = substr($ticha, -1);
$two = substr($ticha, -2);
if ($two>9&&$two<21):

 $name1000=" тысяч";
elseif ($one==1):

  $name1000=" тысяча";
elseif ($one>1&&$one<5):

  $name1000=" тысячи";
else:

  $name1000=" тысяч";
endif;
$numt=NumberSotih($ticha);
if ($one==1&&$two!=11):
$numt=str_replace('один','одна',$numt);
endif;
if ($one==2):
$numt=str_replace('два','две',$numt);
$numt=str_replace('двед','двад',$numt);
endif;
if  ($ticha!='000'):
$numt.=$name1000;
endif;
if ($rub<1000000):
return trim("$numt $nums $namerub");
endif;
//----------Миллионы
$million=substr(str_pad($rub,9,"0",STR_PAD_LEFT),0,3);
$one = substr($million, -1);
$two = substr($million, -2);
if ($two>9&&$two<21):

 $name1000000=" миллионов";
elseif ($one==1):

  $name1000000=" миллион";
elseif ($one>1&&$one<5):

  $name1000000=" миллиона";
else:

  $name1000000=" миллионов";
endif;
$numm=NumberSotih($million);
$numm.=$name1000000;

return trim("$numm $numt $nums $namerub");

}

//  Загрузить ШАБЛОН из файла


function getTemplate($template, $ext = "html") {
    $templatefolder = "docs";     // папка для хранения шаблонов
    return str_replace("\"","\\\"", implode("", file($templatefolder."/".$template.".".$ext)));
}



function get_select_options_with_id ($option_list, $selected_key) {
	return get_select_options_with_id_separate_key($option_list, $option_list, $selected_key);
}


/**
 * Create HTML to display select options in a dropdown list.  To be used inside
 * of a select statement in a form.   This method expects the option list to have keys and values.  The keys are the ids.  The values are the display strings.
 * param $label_list - the array of strings to that contains the option list
 * param $key_list - the array of strings to that contains the values list
 * param $selected - the string which contains the default value
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 */
function get_select_options_with_id_separate_key ($label_list, $key_list, $selected_key) {
	$select_options = "";

	//for setting null selection values to human readable --None--
	$pattern = "/'0?'></";
	$replacement = "''> - Нет - <";

	if (empty($key_list)) $key_list = array();
	//create the type dropdown domain and set the selected value if $opp value already exists
	foreach ($key_list as $option_key=>$option_value) {

		$selected_string = '';
		// the system is evaluating $selected_key == 0 || '' to true.  Be very careful when changing this.  Test all cases.
		// The bug was only happening with one of the users in the drop down.  It was being replaced by none.
		if (($option_key != '' && $selected_key == $option_key) || ($selected_key == '' && $option_key == '') || (is_array($selected_key) &&  in_array($option_key, $selected_key)))
		{
			$selected_string = ' selected="selected" ';
		}

		$html_value = $option_key;

		$select_options .= "\n<OPTION ".$selected_string."value='$html_value'>$label_list[$option_key]</OPTION>";
	}
	$select_options = preg_replace($pattern, $replacement, $select_options);
	return $select_options;
}





?>
