<?
class SymplePrint
{
private $queryIs = true; // ��������� �������� �������
private $errors = array();	//  ������ �� �������� ��������� �� �������
private $print_errors = true;

//		����������� ��� �������� �������
//			$this->queryIs = false;
//			$this->errors[] = mysql_error();

//	��������� ������
public function printErrors($clear = true)
	{
		if ($this->print_errors)
		{
			if (isset($this->errors))
				foreach($this->errors as $err) // ���������� ������ � ��������� ���������� ��� ����������� ������ css
					echo '<p><strong>������:</strong> '.$err.'</p>';
			if ($clear)
				unset($this->errors);
		}
	}
// ��������� ������ ������
public function setErrorsOut($x=false)
	{
		$this->print_errors = $x;
	}

// ��������� ������ ������
public function setError($str)
	{
		$this->errors[] = $str;
	}
	
	
	
// ��������� ������ ������
	
	
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