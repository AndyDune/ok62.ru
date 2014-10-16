<?
class SymplePrint
{
private $queryIs = true; // Индикатор успешной выборки
private $errors = array();	//  Массив со строками сообщений об ошибках
private $print_errors = true;

//		Применяется при контроле выборки
//			$this->queryIs = false;
//			$this->errors[] = mysql_error();

//	Перчатаем ошибки
public function printErrors($clear = true)
	{
		if ($this->print_errors)
		{
			if (isset($this->errors))
				foreach($this->errors as $err) // перебираем массив и заполняем переменную для подключения файлов css
					echo '<p><strong>ОШИБКА:</strong> '.$err.'</p>';
			if ($clear)
				unset($this->errors);
		}
	}
// Настройка печати ошибок
public function setErrorsOut($x=false)
	{
		$this->print_errors = $x;
	}

// Настройка печати ошибок
public function setError($str)
	{
		$this->errors[] = $str;
	}
	
	
	
// Настройка печати ошибок
	
	
public function checkQueryResult($res)
	{
     if (!$res)
       {
          $this->queryIs = false;
 		  $this->errors[] = mysql_error();
     	  return false;
  	    }
     return true;
	}

}
?>