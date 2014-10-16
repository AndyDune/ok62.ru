<?php

class Module_Article_Parents extends Dune_Include_Abstract_Code
{

    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

$id = $this->id;
$table = 'unity_article_text';

$parents = array();
$curr = 100;
$have_parent = 0;
if ($run_id = $id)
{
    $go = true;
    $one = new Dune_Mysqli_Table($table);
    while ($go)
    {
        $one->useId($run_id);
        if (!$data = $one->getData())
        {
            $go = false;
            break;
        }
        if (!$have_parent)
            $have_parent = $run_id;
        $parents[$curr] = $data;
        $curr--;
        if (!$data['parent'])
        {
            $go = false;
            break;
        }
        $run_id = $data['parent'];
    }
}
ksort($parents);

$this->setResult('data', $parents);
$this->setResult('have_parent', $have_parent);


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    