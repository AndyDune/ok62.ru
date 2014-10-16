<?php echo $this->crumbs; ?>
<hr />

<h1>������ ������� ��������� ������������.</h1>
<h2> ���� <?php echo $this->page;?> / <?php echo $this->levels_count;?>: <?php echo $this->current_page_name;?></h2>
<div style="position:relative;" id="master-div">
<?php
if ($this->count_programs)
{
    ?>
    <a id="master-count-progs-a" href="/modules.php?name=Hypothec&op=MasterForProgramList">�������� � ���������� �����������: <strong><?php echo $this->count_programs;?> </strong></a>
    <?php
}
else 
{
    ?>
    <a id="master-count-progs-a" href="/modules.php?name=Hypothec&op=MasterForProgram">�������� � ���������� ����������� ���. �������� �������</a>
    <?php
}
$form = new Dune_Form_Form();
//$form->setAction('/modules.php');
$form->setMethod();

echo $form->getBegin();
// ������ ����� �������� ������ � �����
/*foreach ($this->data as $key => $value)
{
?>
<input type="hidden" name="<? echo $key;?>" value="<? echo $value;?>">
<?php
}
*/
?>
<input type="hidden" name="page" value="<? echo $this->page;?>">
<input type="hidden" name="_do_" value="_do_">
<input type="hidden" name="name" value="Hypothec">
<input type="hidden" name="op" value="MasterForProgram">

<?php
if (isset($this->support[$this->page]))
{
?><table><?php
    foreach ($this->support[$this->page]['form'] as $value)
    {
        ?><tr><?php
        switch ($value)
        {
// ���� ����� ���� �������� �������
            case 'age':
                ?>
                <tr><td colspan="2" class="master-text-td">
                <?php echo $this->texts->age?>
                </td></tr>
                <?php
                $field = new Dune_Form_InputText('age');
                $field->setSize(3);
                $field->setValue($this->data->age);

               ?><td class="search-table-td-name">������� �������: </td><td>
               <?php echo $field->get(); ?> </td>
               <?php
            break;
// ���� ����� ����� ���������� � ����������
            case 'registration':
                ?>
                <tr><td colspan="2" class="master-text-td">
                <?php echo $this->texts->registration?>
                </td></tr>
                <?php
                
                $field = new Dune_Form_Select('registration');
                foreach ($this->data_specify_array['registration'] as $key => $value)
                {
                    if ($key == $this->data->registration)
                    {
                        $field->setOption($key, $value, true);
                    }
                    else 
                        $field->setOption($key, $value);
                }

               ?><td class="search-table-td-name">����������� �� ����� ��������� �������: </td><td>
               <?php echo $field->get(); ?> </td>
               <?php
            break;
// ������������ ��
            case 'nationality':
                ?>
                <tr><td colspan="2" class="master-text-td">
                <?php echo $this->texts->nationality?>
                </td></tr>
                <?php
                
                $field = new Dune_Form_Select('nationality');
                foreach ($this->data_specify_array['nationality'] as $key => $value)
                {
                    if ($key == $this->data->nationality)
                    {
                        $field->setOption($key, $value, true);
                    }
                    else 
                        $field->setOption($key, $value);
                }

               ?><td class="search-table-td-name">����������� ��: </td><td>
               <?php echo $field->get(); ?> </td>
               <?php
            break;
  // ������
            case 'currencyid':
                $field = new Dune_Form_Select('currencyid');
                foreach ($this->data_specify_array['currencyid_rus_rus'] as $key => $value)
                {
                    if ($key == $this->data->currencyid)
                    {
                        $field->setOption($key, $value, true);
                    }
                    else 
                        $field->setOption($key, $value);

                }
                ?>
                <tr><td colspan="2" class="master-text-td">
                <?php echo $this->texts->currencyid?>
                </td></tr>
                <?php

               ?><td class="search-table-td-name">������: </td><td>
               <?php echo $field->get(); ?> </td>
               <?php
            break;
            
// ������������� ������
            case 'incconfirmid':
                $field = new Dune_Form_Select('incconfirmid');
                foreach ($this->data_specify_array['incconfirmid'] as $key => $value)
                {
                    if ($key == $this->data->incconfirmid)
                    {
                        $field->setOption($key, $value, true);
                    }
                    else 
                        $field->setOption($key, $value);
                }
                ?>
                <tr><td colspan="2" class="master-text-td">
                <?php echo $this->texts->incconfirmid?>
                </td></tr>
                <?php
                

               ?><td class="search-table-td-name">������������� ������: </td><td>
               <?php echo $field->get(); ?> </td>
               <?php
            break;
            
// ����������� �������
            case 'loansecurityid':
                $field = new Dune_Form_Select('loansecurityid');
                foreach ($this->data_specify_array['loansecurityid'] as $key => $value)
                {
                    if ($key == $this->data->loansecurityid)
                    {
                        $field->setOption($key, $value, true);
                    }
                    else 
                        $field->setOption($key, $value);

                }

               ?><td class="search-table-td-name">����������� �������: </td><td>
               <?php echo $field->get(); ?> </td>
               <?php
            break;
            
// ����
            case 'bank_id':
                $field = new Dune_Form_Select('bank_id');
                $field->setOption(0, '���');
                foreach ($this->banks as $value)
                {
                    if ($value['id'] == $this->data->bank_id)
                    {
                        $field->setOption($value['id'], $value['name'], true);
                    }
                    else 
                        $field->setOption($value['id'], $value['name']);
                }

               ?><td class="search-table-td-name">����: </td><td>
               <?php echo $field->get(); ?> </td>
               <?php
            break;
            
// ���� ������������ ������
            case 'approveperiod':
                $field = new Dune_Form_InputText('approveperiod');
                $field->setSize(5);
                $field->setValue($this->data->approveperiod);

               ?><td class="search-table-td-name">���� ������������ ������: </td><td>
               <?php echo $field->get(); ?> ����</td>
               <?php
            break;
// ������ �������
            case 'rate':
                $field = new Dune_Form_InputText('rate');
                $field->setSize(3);
                $field->setValue($this->data->rate);

               ?><td class="search-table-td-name">������ �������: </td><td>
               <?php echo $field->get(); ?> %</td>
               <?php
            break;

            
// ���� �������
            case 'creditperiod':
                $creditperiodmin = new Dune_Form_InputText('creditperiodmin');
                $creditperiodmin->setSize(3);
                $creditperiodmin->setValue($this->data->creditperiodmin);
                $creditperiodmax = new Dune_Form_InputText('creditperiodmax');
                $creditperiodmax->setSize(3);
                $creditperiodmax->setValue($this->data->creditperiodmax);

               ?><td class="search-table-td-name">���� �������: </td><td>
               �� <?php echo $creditperiodmin->get(); ?> �� <?php echo $creditperiodmax->get(); ?></td>
               <?php
            break;
            

// ��� ������������
            case 'kinds':
                $field = new Dune_Form_Select('kinds');
                foreach ($this->data_specify_array['kinds'] as $key => $value)
                {
                    $field->setOption($key, $value);
                }

               ?><td class="search-table-td-name">��� ������������: </td><td>
               <?php echo $field->get(); ?> </td>
               <?php
            break;
            
// ������ �������
            case 'sumcredit':
                ?>
                <tr><td colspan="2" class="master-text-td">
                <?php echo $this->texts->sumcredit?>
                </td></tr>
                <?php
                
                $field = new Dune_Form_InputText('sumcredit');
                $field->setSize(10);
                $field->setValue($this->data->sumcredit);

               ?><td class="search-table-td-name">������ �������: </td><td>
               <?php echo $field->get(); ?></td>
               <?php
            break;

// ��������������� ����
            case 'firstpayment':
                $field = new Dune_Form_InputText('firstpayment');
                $field->setSize(4);
                $field->setValue($this->data->firstpayment);
                
                ?>
                <tr><td colspan="2" class="master-text-td">
                <?php echo $this->texts->firstpayment?>
                </td></tr>
                <?php
                
                
               ?><td class="search-table-td-name">�������������� ����: </td><td>
               <?php echo $field->get(); ?> %</td>
               <?php
            break;

            
// ��������� ��������� ��� ������� �����
            case 'advrepay':
                $field = new Dune_Form_InputText('advrepay');
                $field->setSize(3);
                $field->setValue($this->data->advrepay);

               ?><td class="search-table-td-name">��������� ��������� ��� ������� �����: </td><td>
               <?php echo $field->get(); ?> �������</td>
               <?php
            break;
            
  // ����������� ������
            case 'monthpay':
                $field = new Dune_Form_InputText('monthpay');
                $field->setSize(10);
                $field->setValue($this->data->monthpay);
                
                
                ?>
                <tr><td colspan="2" class="master-text-td">
                <?php echo $this->texts->monthpay?>
                </td></tr>
                <?php

               ?><td class="search-table-td-name">����������� ������: </td><td>
               <?php echo $field->get(); ?> </td>
               <?php
            break;
            
            
            
// �������
            case 'paymenttypeid':
                $field = new Dune_Form_Select('paymenttypeid');
                foreach ($this->data_specify_array['paymenttypeid'] as $key => $value)
                {
                    $field->setOption($key, $value);
                }

               ?><td class="search-table-td-name">�������: </td><td>
               <?php echo $field->get(); ?> </td>
               <?php
            break;
         
               
        }
        ?></tr><?php
    }
?></table><?php
}

$ff = new Dune_Form_InputSubmit('GO');
$ff->setValue('����� &gt;&gt;');
$ff->setClass('hypo-submit');
?> <p id="master-form-buttoms"><?php
if ($this->page > 1) {
?><a href="/modules.php?name=Hypothec&op=MasterForProgram&page=<?php echo $this->page - 1?>" id="hypo-master-back-a"> &lt;&lt; ����� </a><?php
}
echo $ff->get();
?></p> <?php
echo $form->getEnd();
?>
</div>

