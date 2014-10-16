<?
/************************************************************************/
/* ���������� � ��������� ��� ������ � �� edinstvo                      */
/* Copyright (c) 2006 by Romanoff Vlad                                  */
/*                                                                      */
/************************************************************************/
//library.php


// *****************************************************************************
function connectToDB($serverName = false){
//����������
$vars = Dune_Variables::getInstance();
$dbConn = $vars->hypoDBConn;
if (!$dbConn)
{
    $config = Dune_Zend_Config_Ini::getInstance('base');
    $userName = $config->mysql->hypo->username;
    $password = $config->mysql->hypo->passwd;
    $dbName   = $config->mysql->hypo->dbname;
    $dbConn = "";
    
      //���������� � ��
      $vars->hypoDBConn = $dbConn = mysql_connect($serverName, $userName, $password);
      if (!$dbConn){
       print "<h3>���� �������� � ����������� � ��...</h3>\n";
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
/*************** ������� ����������� �������� �� IP ������ **************/
/************************************************************************/

function DefineSaler()  {
          // ����������� ��������
          
  $IP = $_SERVER['REMOTE_ADDR'];
  

  switch ($IP) {
   case "192.168.9.14" : { $salerID = 1; Break; }  // �������� �������
   case "192.168.9.13" : { $salerID = 2; Break; }  // ������� ��������
   case "192.168.9.17" : { $salerID = 101; Break; }  // ������ ����
//   case "192.168.9.17" : { $salerID = 3; Break; }  // ������������ ���������
   case "192.168.9.24" : { $salerID = 4; Break; }  // ������� �����
   case "192.168.9.6"  : { $salerID = 5; Break; }  // �������� �����
   case "192.168.9.4"  : { $salerID = 6; Break; }  // �������� ������
   case "192.168.9.19" : { $salerID = 7; Break; }  // ��������� �����
   case "192.168.9.8"  : { $salerID = 8; Break; }  // ������ �����
   case "192.168.9.77" : { $salerID = 9; Break; }  // ������� ��������
   case "192.168.9.12" : { $salerID = 10; Break; } // ��������� ��������
   case "192.168.9.22" : { $salerID = 11; Break; } // ��������� �����
   case "127.0.0.1"    : { $salerID = 12; Break; } // server
   case "192.168.9.16" : { $salerID = 13; Break; } // ����� ������
   case "192.168.9.5"  : { $salerID = 14; Break; } // �������� ����
   case "192.168.9.18" : { $salerID = 15; Break; } // ���-�� �� ���� �����������
   default             : { $salerID = $IP; Break; }  // ���, ����� �����
  }
  
  Return $salerID;

}



// *****************************************************************************
function IsInternet(){  // ����������, ��� ������� ����: � ����� ��� ���.

 if (($_SERVER['HTTP_HOST'] == "www.edinstvo62.ru") or ($_SERVER['HTTP_HOST'] == "edinstvo62.ru")) {
 	Return true;
 }
 else {
 	Return false;
 }

} // end 



// *****************************************************************************
function identByNumber($number){   // ������� ������������� ���� ������� �� ��� ������

       	$firstSymbol = substr($number, 0, 1);  // ��������� 1-�� ������� ������
       	
         switch ($firstSymbol) {
         	case "K": { $type="store"; break; }
         	case "H": { $type="office"; break; }
         	case "A": { $type="garage"; break; }
         	default : { $type="apartment"; break; }
         }

 return $type; // ���������� ������� �������  
}
// *****************************************************************************
function identByFileName($filename){   // ������� ������������� ���� ������� �� ����� �������

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
  
	
	
 return $type; // ���������� ������� �������  
}

// *****************************************************************************
//������� ��� ������������� ��������� ����������� ������� jpeg - �����.
// img.php?src={��������}&w={������������ ������}&h={������������ ������}&q={�������� jpeg-������*}
// ��� ���� ������ �������� ����� �������� ���������������� �������� ��������������� �������� � �������� ������������ �������.
// �������� ������ �� �����������, ������������ � ������������.

function Image2Preview(
                       $img,   // ���� � �������� ��������
                       $w,     // ����. ������
                       $h      // ����. ������
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
// ��������� ���� �� 29.11.2006 � 1) �������� ������� ������ ��� ������ ������� ����
//                                2) 29 ������ 2006 ����
function Date2Propis($date, $type) {
   $str="";

// ������
   $date = str_replace(' ','',$date);
   $date = str_replace(',','.',$date);
   $date = trim($date);

   $field = explode(".", $date);

   if ($type == "1") {
	   switch ($field[0]) {
	    case "1":      { $str .= "������ ";     break; }
	    case "01":     { $str .= "������ ";     break; }
	    case "2":      { $str .= "������ ";     break; }
	    case "02":     { $str .= "������ ";     break; }
	    case "3":      { $str .= "������ ";     break; }
	    case "03":     { $str .= "������ ";     break; }
	    case "4":      { $str .= "��������� ";     break; }
	    case "04":     { $str .= "��������� ";     break; }
	    case "5":      { $str .= "����� ";     break; }
	    case "05":     { $str .= "����� ";     break; }
	    case "6":      { $str .= "������ ";     break; }
	    case "06":     { $str .= "������ ";     break; }
	    case "7":      { $str .= "������� ";     break; }
	    case "07":     { $str .= "������� ";     break; }
	    case "8":      { $str .= "������� ";     break; }
	    case "08":     { $str .= "������� ";     break; }
	    case "9":      { $str .= "������� ";     break; }
	    case "09":     { $str .= "������� ";     break; }
	    case "10":     { $str .= "������� ";     break; }
	    case "11":     { $str .= "������������ ";     break; }
	    case "12":     { $str .= "����������� ";     break; }
	    case "13":     { $str .= "����������� ";     break; }
	    case "14":     { $str .= "������������� ";     break; }
	    case "15":     { $str .= "����������� ";     break; }
	    case "16":     { $str .= "������������ ";     break; }
	    case "17":     { $str .= "����������� ";     break; }
	    case "18":     { $str .= "������������� ";     break; }
	    case "19":     { $str .= "������������� ";     break; }
	    case "20":     { $str .= "��������� ";     break; }
	    case "21":     { $str .= "�������� ������ ";     break; }
	    case "22":     { $str .= "�������� ������ ";     break; }
	    case "23":     { $str .= "�������� ������ ";     break; }
	    case "24":     { $str .= "�������� ��������� ";     break; }
	    case "25":     { $str .= "�������� ����� ";     break; }
	    case "26":     { $str .= "�������� ������ ";     break; }
	    case "27":     { $str .= "�������� ������� ";     break; }
	    case "28":     { $str .= "�������� ������� ";     break; }
	    case "29":     { $str .= "�������� ������� ";     break; }
	    case "30":     { $str .= "��������� ";     break; }
	    case "31":     { $str .= "�������� ������ ";     break; }
	   }
   }
   else  {
   	 $str .= $field[0]." ";
   }




   switch ($field[1]) {
    case "1":      { $str .= "������ ";     break; }
    case "01":     { $str .= "������ ";     break; }
    case "2":      { $str .= "������� ";     break; }
    case "02":     { $str .= "������� ";     break; }
    case "3":      { $str .= "����� ";     break; }
    case "03":     { $str .= "����� ";     break; }
    case "4":      { $str .= "������ ";     break; }
    case "04":     { $str .= "������ ";     break; }
    case "5":      { $str .= "��� ";     break; }
    case "05":     { $str .= "��� ";     break; }
    case "6":      { $str .= "���� ";     break; }
    case "06":     { $str .= "���� ";     break; }
    case "7":      { $str .= "���� ";     break; }
    case "07":     { $str .= "���� ";     break; }
    case "8":      { $str .= "������� ";     break; }
    case "08":     { $str .= "������� ";     break; }
    case "9":      { $str .= "�������� ";     break; }
    case "09":     { $str .= "�������� ";     break; }
    case "10":     { $str .= "������� ";     break; }
    case "11":     { $str .= "������ ";     break; }
    case "12":     { $str .= "������� ";     break; }
   }

   if ($type == "1") {
	   switch ($field[2]) {
	    case "2006":     { $str .= "��� ������ ������� ����";     break; }
	    case "06":       { $str .= "��� ������ ������� ����";     break; }
	    case "2007":     { $str .= "��� ������ �������� ����";     break; }
	    case "07":       { $str .= "��� ������ �������� ����";     break; }
	    case "2008":     { $str .= "��� ������ �������� ����";     break; }
	    case "08":       { $str .= "��� ������ �������� ����";     break; }
	    case "2009":     { $str .= "��� ������ �������� ����";     break; }
	    case "09":       { $str .= "��� ������ �������� ����";     break; }
	    case "2010":     { $str .= "��� ������ �������� ����";     break; }
	    case "10":       { $str .= "��� ������ �������� ����";     break; }
	    case "2011":     { $str .= "��� ������ ������������� ����";     break; }
	    case "11":       { $str .= "��� ������ ������������� ����";     break; }
	    case "2012":     { $str .= "��� ������ ������������ ����";     break; }
	    case "12":       { $str .= "��� ������ ������������ ����";     break; }
	    case "2013":     { $str .= "��� ������ ������������ ����";     break; }
	    case "13":       { $str .= "��� ������ ������������ ����";     break; }
	    case "2014":     { $str .= "��� ������ �������������� ����";     break; }
	    case "14":       { $str .= "��� ������ �������������� ����";     break; }
	    case "2015":     { $str .= "��� ������ ������������ ����";     break; }
	    case "15":       { $str .= "��� ������ ������������ ����";     break; }
	    case "2016":     { $str .= "��� ������ ������������� ����";     break; }
	    case "16":       { $str .= "��� ������ ������������� ����";     break; }
	    case "2017":     { $str .= "��� ������ ������������ ����";     break; }
	    case "17":       { $str .= "��� ������ ������������ ����";     break; }
	   }
   }
   else  {
   	 $str .= $field[2]." ����";
   }

    return $str;
}



// *****************************************************************************
//        ����� ��������

//������� �������� ���� � ����� ��������. ������� ����� (����������� ������ � ������ - ����� ��� �������, ������������ ����� - �������� ������), �� ������ � ������� - ����� ��������.
//���� ���������, denik@aport.ru  http://poligraf.h1.ru

function Number($c)
{
$c=str_pad($c,3,"0",STR_PAD_LEFT);
//---------�����
switch  ($c[0])
{
case 0:
$d[0]="";
break;
case 1:
$d[0]="���";
break;
case 2:
$d[0]="������";
break;
case 3:
$d[0]="������";
break;
case 4:
$d[0]="���������";
break;
case 5:
$d[0]="�������";
break;
case 6:
$d[0]="��������";
break;
case 7:
$d[0]="�������";
break;
case 8:
$d[0]="���������";
break;
case 9:
$d[0]="���������";
break;
}
//--------------�������
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
$d[1]="������";
break;
case 11:
$d[1]="�����������";
break;
case 12:
$d[1]="����������";
break;
case 13:
$d[1]="����������";
break;
case 14:
$d[1]="������������";
break;
case 15:
$d[1]="����������";
break;
case 16:
$d[1]="�����������";
break;
case 17:
$d[1]="����������";
break;
case 18:
$d[1]="������������";
break;
case 19:
$d[1]="������������";
break;
};
}
break;
case 2:
$d[1]="��������";
break;
case 3:
$d[1]="��������";
break;
case 4:
$d[1]="�����";
break;
case 5:
$d[1]="���������";
break;
case 6:
$d[1]="����������";
break;
case 7:
$d[1]="���������";
break;
case 8:
$d[1]="�����������";
break;
case 9:
$d[1]="���������";
break;
}
//--------------�������
$d[2]="";
if ($c[1]!=1):
switch  ($c[2])
{
case 0:
$d[2]="";
break;
case 1:
$d[2]="����";
break;
case 2:
$d[2]="���";
break;
case 3:
$d[2]="���";
break;
case 4:
$d[2]="������";
break;
case 5:
$d[2]="����";
break;
case 6:
$d[2]="�����";
break;
case 7:
$d[2]="����";
break;
case 8:
$d[2]="������";
break;
case 9:
$d[2]="������";
break;
}
endif;

return $d[0].' '.$d[1].' '.$d[2];

}


function NumberSotih($c)    // ������ ��� ����� � �����!!! �.�. "����" � "���" ����� � �����, � �� "����" � "���"
{
$c=str_pad($c,3,"0",STR_PAD_LEFT);
//---------�����
switch  ($c[0])
{
case 0:
$d[0]="";
break;
case 1:
$d[0]="���";
break;
case 2:
$d[0]="������";
break;
case 3:
$d[0]="������";
break;
case 4:
$d[0]="���������";
break;
case 5:
$d[0]="�������";
break;
case 6:
$d[0]="��������";
break;
case 7:
$d[0]="�������";
break;
case 8:
$d[0]="���������";
break;
case 9:
$d[0]="���������";
break;
}
//--------------�������
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
$d[1]="������";
break;
case 11:
$d[1]="�����������";
break;
case 12:
$d[1]="����������";
break;
case 13:
$d[1]="����������";
break;
case 14:
$d[1]="������������";
break;
case 15:
$d[1]="����������";
break;
case 16:
$d[1]="�����������";
break;
case 17:
$d[1]="����������";
break;
case 18:
$d[1]="������������";
break;
case 19:
$d[1]="������������";
break;
};
}
break;
case 2:
$d[1]="��������";
break;
case 3:
$d[1]="��������";
break;
case 4:
$d[1]="�����";
break;
case 5:
$d[1]="���������";
break;
case 6:
$d[1]="����������";
break;
case 7:
$d[1]="���������";
break;
case 8:
$d[1]="�����������";
break;
case 9:
$d[1]="���������";
break;
}
//--------------�������
$d[2]="";
if ($c[1]!=1):
switch  ($c[2])
{
case 0:
$d[2]="";
break;
case 1:
$d[2]="����";
break;
case 2:
$d[2]="���";
break;
case 3:
$d[2]="���";
break;
case 4:
$d[2]="������";
break;
case 5:
$d[2]="����";
break;
case 6:
$d[2]="�����";
break;
case 7:
$d[2]="����";
break;
case 8:
$d[2]="������";
break;
case 9:
$d[2]="������";
break;
}
endif;

return $d[0].' '.$d[1].' '.$d[2];

}
//--------------------------------------- // ������� ����� (���. ���.)
function SumProp($sum)
{

// �������� �����
            $sum=str_replace(' ','',$sum);
            $sum = trim($sum);
            if ((!(@eregi('^[0-9]*'.'[,\.]'.'[0-9]*$', $sum)||@eregi('^[0-9]+$', $sum)))||($sum=='.')||($sum==',')) :
                return "��� �� ������: $sum";
                endif;
// ������ �������, ���� ��� ����, �� �����
   $sum=str_replace(',','.',$sum);
   if($sum>=1000000000):
   return "������������ ����� &#151 ���� �������� ������ ����� ���� �������";
   endif;
// ��������� ������
     $rub=floor($sum);
     $kop=100*round($sum-$rub,2);
     $kop.=" ���.";
      if (strlen($kop)==6):
      $kop="0".$kop;
      endif;
// �������� ��������� ����� '�����'
$one = substr($rub, -1);
$two = substr($rub, -2);
if ($two>9&&$two<21):
 $namerub=") ������";

elseif ($one==1):
  $namerub=") �����";

elseif ($one>1&&$one<5):
  $namerub=") �����";

else:
  $namerub=") ������";

endif;
if($rub=="0"):
//return "���� ������ $kop";
return "����) ������";
endif;
//----------�����
$sotni= substr($rub, -3);
$nums=Number($sotni);
if ($rub<1000):
return ucfirst(trim("$nums$namerub"));
endif;
//----------������
if ($rub<1000000):
$ticha=substr(str_pad($rub,6,"0",STR_PAD_LEFT),0,3);
else:
$ticha=substr($rub,strlen($rub)-6,3);
endif;
$one = substr($ticha, -1);
$two = substr($ticha, -2);
if ($two>9&&$two<21):

 $name1000=" �����";
elseif ($one==1):

  $name1000=" ������";
elseif ($one>1&&$one<5):

  $name1000=" ������";
else:

  $name1000=" �����";
endif;
$numt=Number($ticha);
if ($one==1&&$two!=11):
$numt=str_replace('����','����',$numt);
endif;
if ($one==2):
$numt=str_replace('���','���',$numt);
$numt=str_replace('����','����',$numt);
endif;
if  ($ticha!='000'):
$numt.=$name1000;
endif;
if ($rub<1000000):
return ucfirst(trim("$numt $nums$namerub"));
endif;
//----------��������
$million=substr(str_pad($rub,9,"0",STR_PAD_LEFT),0,3);
$one = substr($million, -1);
$two = substr($million, -2);
if ($two>9&&$two<21):

 $name1000000=" ���������";
elseif ($one==1):

  $name1000000=" �������";
elseif ($one>1&&$one<5):

  $name1000000=" ��������";
else:

  $name1000000=" ���������";
endif;
$numm=Number($million);
$numm.=$name1000000;

return ucfirst(trim("$numm $numt $nums$namerub"));

}
//--------------------------------------- // ������� ���������� ������ �����
function AreaProp1($sum)
{

// �������� �����
            $sum=str_replace(' ','',$sum);
            $sum = trim($sum);
            if ((!(@eregi('^[0-9]*'.'[,\.]'.'[0-9]*$', $sum)||@eregi('^[0-9]+$', $sum)))||($sum=='.')||($sum==',')) :
                return "��� �� �������: $sum";
                endif;
// ������ �������, ���� ��� ����, �� �����
   $sum=str_replace(',','.',$sum);

   if($sum>=1000000000):
     return "������������ ����� &#151 ���� �������� ����� ����� ���� �����";
   endif;

     $rub=floor($sum);
     $kop=100*round($sum-$rub,2);

// ��������� �����



// �������� ��������� ����� '�����'
$one = substr($rub, -1);
$two = substr($rub, -2);

if ($two>9&&$two<21):
 $namerub="�����";

elseif ($one==1):
  $namerub="�����";

elseif ($one>1&&$one<4):
  $namerub="�����";

else:
  $namerub="�����";

endif;

if($rub=="0"):
return "���� �����";
endif;


//----------�����
$sotni= substr($rub, -3);
$nums=NumberSotih($sotni);
if ($rub<1000):
return trim("$nums $namerub");
endif;
//----------������
if ($rub<1000000):
$ticha=substr(str_pad($rub,6,"0",STR_PAD_LEFT),0,3);
else:
$ticha=substr($rub,strlen($rub)-6,3);
endif;
$one = substr($ticha, -1);
$two = substr($ticha, -2);
if ($two>9&&$two<21):

 $name1000=" �����";
elseif ($one==1):

  $name1000=" ������";
elseif ($one>1&&$one<5):

  $name1000=" ������";
else:

  $name1000=" �����";
endif;
$numt=NumberSotih($ticha);
if ($one==1&&$two!=11):
$numt=str_replace('����','����',$numt);
endif;
if ($one==2):
$numt=str_replace('���','���',$numt);
$numt=str_replace('����','����',$numt);
endif;
if  ($ticha!='000'):
$numt.=$name1000;
endif;
if ($rub<1000000):
return trim("$numt $nums $namerub");
endif;
//----------��������
$million=substr(str_pad($rub,9,"0",STR_PAD_LEFT),0,3);
$one = substr($million, -1);
$two = substr($million, -2);
if ($two>9&&$two<21):

 $name1000000=" ���������";
elseif ($one==1):

  $name1000000=" �������";
elseif ($one>1&&$one<5):

  $name1000000=" ��������";
else:

  $name1000000=" ���������";
endif;
$numm=NumberSotih($million);
$numm.=$name1000000;

return trim("$numm $numt $nums $namerub");

}
//--------------------------------------- // ������� ���������� ������ �����
function AreaProp2($sum)
{

// �������� �����
            $sum=str_replace(' ','',$sum);
            $sum = trim($sum);
            if ((!(@eregi('^[0-9]*'.'[,\.]'.'[0-9]*$', $sum)||@eregi('^[0-9]+$', $sum)))||($sum=='.')||($sum==',')) :
                return "��� �� �������: $sum";
                endif;
// ������ �������, ���� ��� ����, �� �����
   $sum=str_replace(',','.',$sum);

   if($sum>=1000000000):
     return "������������ ����� &#151 ���� �������� ����� ����� ���� �����";
   endif;

     $rub=floor($sum);
     $kop=100*round($sum-$rub,2);



// �������� ��������� ����� '�����'
$one = substr($rub, -1);
$two = substr($rub, -2);

if ($two>9&&$two<21):
 $namerub="�����";

elseif ($one==1):
  $namerub="�����";

elseif ($one>1&&$one<4):
  $namerub="�����";

else:
  $namerub="�����";

endif;

if($rub=="0"):
return "���� �����";
endif;


//----------�����
$sotni= substr($rub, -3);
$nums=NumberSotih($sotni);
if ($rub<1000):
return trim("$nums $namerub");
endif;
//----------������
if ($rub<1000000):
$ticha=substr(str_pad($rub,6,"0",STR_PAD_LEFT),0,3);
else:
$ticha=substr($rub,strlen($rub)-6,3);
endif;
$one = substr($ticha, -1);
$two = substr($ticha, -2);
if ($two>9&&$two<21):

 $name1000=" �����";
elseif ($one==1):

  $name1000=" ������";
elseif ($one>1&&$one<5):

  $name1000=" ������";
else:

  $name1000=" �����";
endif;
$numt=NumberSotih($ticha);
if ($one==1&&$two!=11):
$numt=str_replace('����','����',$numt);
endif;
if ($one==2):
$numt=str_replace('���','���',$numt);
$numt=str_replace('����','����',$numt);
endif;
if  ($ticha!='000'):
$numt.=$name1000;
endif;
if ($rub<1000000):
return trim("$numt $nums $namerub");
endif;
//----------��������
$million=substr(str_pad($rub,9,"0",STR_PAD_LEFT),0,3);
$one = substr($million, -1);
$two = substr($million, -2);
if ($two>9&&$two<21):

 $name1000000=" ���������";
elseif ($one==1):

  $name1000000=" �������";
elseif ($one>1&&$one<5):

  $name1000000=" ��������";
else:

  $name1000000=" ���������";
endif;
$numm=NumberSotih($million);
$numm.=$name1000000;

return trim("$numm $numt $nums $namerub");

}

//  ��������� ������ �� �����


function getTemplate($template, $ext = "html") {
    $templatefolder = "docs";     // ����� ��� �������� ��������
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
	$replacement = "''> - ��� - <";

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
