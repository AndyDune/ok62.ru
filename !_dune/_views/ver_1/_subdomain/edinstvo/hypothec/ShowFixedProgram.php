<?php
echo $this->crumbs;
if ($this->data_have)
{
    $name = $this->data_specify_array;
    
$data = new Dune_Array_IsSet($this->data_array);
$data_bank = new Dune_Array_IsSet($this->data_array['bank_data']);
$incconfirm_data = new Dune_Array_IsSet($this->data_array['incconfirm_data']);
?>
<div class="text noborder"><h1><?php echo $data->name;?></h1>
</div>
<p><?php echo $data->bonus;?></p>
<p><?php echo str_replace(array("\r\n", "\n"), '<br />', $this->info->comment_pp);?></p>
<div class="redborder"><div class="bluebg">

<div class="program">
<h2>����� ������</h2>
<table>
<?php if ($data_bank->check('name')) {?>
<tr>
<td class="first">����:</td>
<td><span class="bankname"><a href="/modules.php?name=Hypothec&op=ShowFixedBank&bankID=<?php echo $data_bank->id; ?>"><?php echo $data_bank->name; ?></a></span></td>
</tr>
<?php }?>
<tr>
<td class="first">���� ������������:</td>
<td><strong><?php echo $this->data_specify_array['goalid'][$data->goalid]?></strong></td>
</tr>
<tr>
<td class="first">����� ������������:</td>
<td><strong><?php echo $this->data_specify_array['marketid'][$data->marketid]?></strong></td>
</tr>
</table>
</div>

<div class="program">
<h2>������� �������</h2>
<table>
<tr class="mover-highlight">
<td class="first">������ �������:</td>
<td><strong><?php echo $this->data_specify_array['currencyid'][$data->currencyid]?></strong></td>
</tr>
<tr>
<td class="first">������ �������:</td>
<td>
<strong><?php echo number_format($data->ratemin, 2); ?> � <?php echo number_format($data->ratemax, 2); ?> %</strong>
<?php if ($data->rate_info) {?>
<div class="cmt">
<?php echo $data->rate_info; ?>
</div>
<?php }?>
</td>
</tr>
<tr>
<td class="first">����������� �������:</td>
<td><strong><?php echo $this->data_specify_array['loansecurityid'][$data->loansecurityid]?></strong></td>
</tr>
<tr>
<td class="first">���� �������</td>
<td><strong>�� <?php echo $data->creditperiodmax; ?> ���</strong></td>
</tr>
<tr>
<td class="first">������ �������:</td>
<td><strong><?php echo number_format($data->sumcreditmin, 0, '.', ' '); ?> � <?php echo number_format($data->sumcreditmax, 0, '.', ' '); ?></strong></td>
</tr>
<tr>
<td class="first">�������������� �����:</td>
<td><strong>�� <?php echo $data->firstpayment; ?> %</strong></td>
</tr>
<tr>
<td class="first">������������� ������:</td>

<?php if (!$data->incconfirm_data_have) {?>
<td><strong>��� ������</strong></td>
<?php } else {
echo '<td><ul>';
foreach ($this->data_array['incconfirm_data'] as $value)
{
    echo '<li>' . $this->data_specify_array['incconfirmid'][$value['incconfirmid']] . '</li>';
}
    ?>
</ul></td>    
<td><strong><?php echo $data->guarantor; ?></strong></td>
<?php } ?>


</tr>
<tr>
<td class="first">���� ������������ ������:</td> 
<td><strong>�� <?php echo $data->approveperiod; ?> ����</strong></td>
</tr>
<tr>
<td class="first">������������ ���������� ��������:</td>
<td><strong>���������</strong></td>
</tr>
</table>
</div>

<div class="program">
<h2>���������� � ��������</h2>
<table>
<tr>
<td class="first">������� ��������:</td>
<td><strong><?php echo $data->agemin; ?> � <?php echo $data->agemax; ?> ���</strong></td>
</tr>
<tr>
<td class="first">����������� ��:</td>
<td><strong><?php echo $this->data_specify_array['nationality'][$data->nationality]?></strong></td>
</tr>
<tr>
<td class="first">����������� �� ����� ��������� �������:</td>
<td><strong><?php echo $this->data_specify_array['registration'][$data->registration]?></strong></td>
</tr>
<tr>
<td class="first">����� �������� ����:</td>
<td><strong>�� <?php echo $data->seniority_total; ?> ���</strong></td>
</tr>
<tr>
<td class="first">�������� ���� �� ��������� �����:</td>
<td><strong>�� <?php echo $data->seniority_last; ?> �������</strong></td>
</tr>
</table>
</div>

<div class="program">
<h2>���������� � ����������</h2>
<table>
<tr>
<td class="first">������� �����������:</td>
<?php if (!$data->check('guarantor')) {?>
<td><strong>��� ������</strong></td>
<?php } else if ($data->guarantor == 0) {?>
<td><strong>�� ���������</strong></td>
<?php } else {?>
<td><strong><?php echo $data->guarantor; ?></strong></td>
<?php } ?>
</tr>
<tr>
<td class="first">����������� �����������:</td>
<?php if (!$data->soborrower) {?>
<td><strong>��� ������</strong></td>
<?php } else {?>
<td><strong><?php echo $this->data_specify_array['soborrower'][$data->soborrower]; ?></strong>
<?php
if ($data->soborrower_comment) {
?>    
  <p class="progam-comment"><?php echo $data->soborrower_comment;?> </p>
<?php    
} echo '</td>';
} ?>
</tr>
</table>
</div>



<div class="program">
<h2>������� ��������� �������</h2>
<table>
<tr>
<td class="first">�������:</td>
<td><strong><?php echo $this->data_specify_array['paymenttypeid'][$data->paymenttypeid]?></strong></td>
</tr>
<tr>
<td class="first">��������� ��������� ��� �������:</td>

<?php if (!$data->check('advrepay')) {?>
<td><strong>���</strong></td>
<?php } else if ($data->advrepay == 0) {?>
<td><strong>��� �����������</strong></td>
<?php } else {
if ($data->advrepay == 1)
    $m = '������';
else
    $m = '�������';
    ?>
<td><strong>����� <?php echo $data->advrepay . ' ' . $m; ?></strong></td>
<?php } ?>


</tr>
<tr>
<td class="first">����������� ����� ���������� �������:</td>
<?php if (!$data->check('advrepay_min_sum')) {?>
<td><strong>��� �����</strong></td>
<?php } else if ($data->advrepay_min_sum == 0) {?>
<td><strong>��� �����������</strong></td>
<?php } else {
    ?>
<td><strong><?php echo $data->advrepay_min_sum; ?> %</strong></td>
<?php } ?>



</tr>
<tr>
<td class="first"></td>
<td><strong></strong></td>
</tr>
</table>
</div>


<?php if ($data->expenses_have) {
$expenses = new Dune_Array_IsSet($data->expenses);
    ?>
<div class="program noborder"><h2>������� �� �������</h2></div>
<div class="bluetable results"><table width="100%" class="expenses-table">
<tr class="table-header-tr">
<th>������</th>
<th>�������������</th>
<th>��������</th>
</tr>



<?php if ($expenses->examination_value != '') {?>
<tr>
<td class="first"><strong>������������ ��������� ������</strong></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->examination_periodicity]?></td>
<td>
<?php if (!$expenses->examination_value) { ?>
���������
<?php } else { 
echo $expenses->examination_value . ' ';
echo $this->data_specify_array['currency'][$expenses->examination_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>

<?php if ($expenses->check_value != '') {?>
<tr>
<td class="first"><strong>�������� ���������� � ������� �������</strong><?php
if ($expenses->check_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->check_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->check_periodicity]?></td>
<td>
<?php if (!$expenses->check_value) { ?>
���������
<?php } else { 
echo $expenses->check_value . ' ';
echo $this->data_specify_array['currency'][$expenses->check_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>


<?php
// ������ ������� �������
 if ($expenses->valuation_value != '') {?>
<tr>
<td class="first"><strong>������ ������� �������</strong><?php
if ($expenses->valuation_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->valuation_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->valuation_periodicity]?></td>
<td>
<?php if (!$expenses->valuation_value) { ?>
���������
<?php } else { 
echo $expenses->valuation_value . ' ';
echo $this->data_specify_array['currency'][$expenses->valuation_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>

<?php
// �����������
 if ($expenses->insurance_value != '') {?>
<tr>
<td class="first"><strong>�����������</strong><?php
if ($expenses->insurance_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->insurance_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->insurance_periodicity]?></td>
<td>
<?php if (!$expenses->insurance_value) { ?>
���������
<?php } else { 
echo $expenses->insurance_value . ' ';
echo $this->data_specify_array['currency'][$expenses->insurance_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>


<?php
// �������� �� ������ �������
 if ($expenses->commission_value != '') {?>
<tr>
<td class="first"><strong>�������� �� ������ �������</strong><?php
if ($expenses->commission_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->commission_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->commission_periodicity]?></td>
<td>
<?php if (!$expenses->commission_value) { ?>
���������
<?php } else { 
echo $expenses->commission_value . ' ';
echo $this->data_specify_array['currency'][$expenses->commission_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>


<?php
// �������� �������� �����
 if ($expenses->account_commission_value != '') {?>
<tr>
<td class="first"><strong>�������� �������� �����</strong><?php
if ($expenses->account_commission_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->account_commission_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->account_commission_periodicity]?></td>
<td>
<?php if (!$expenses->account_commission_value) { ?>
���������
<?php } else { 
echo $expenses->account_commission_value . ' ';
echo $this->data_specify_array['currency'][$expenses->account_commission_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>


<?php
// ������� �������� �����
 if ($expenses->lead_account_value != '') {?>
<tr>
<td class="first"><strong>������� �������� �����</strong><?php
if ($expenses->lead_account_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->lead_account_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->lead_account_periodicity]?></td>
<td>
<?php if (!$expenses->lead_account_value) { ?>
���������
<?php } else { 
echo $expenses->lead_account_value . ' ';
echo $this->data_specify_array['currency'][$expenses->lead_account_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>



<?php
// ���������� ���������� �� �������
 if ($expenses->make_document_value != '') {?>
<tr>
<td class="first"><strong>���������� ���������� �� �������</strong><?php
if ($expenses->make_document_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->make_document_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->make_document_periodicity]?></td>
<td>
<?php if (!$expenses->make_document_value) { ?>
���������
<?php } else { 
echo $expenses->make_document_value . ' ';
echo $this->data_specify_array['currency'][$expenses->make_document_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>

<?php
// ����������� ������������ ��������� �������
 if ($expenses->cashless_value != '') {?>
<tr>
<td class="first"><strong>����������� ������������ ��������� �������</strong><?php
if ($expenses->cashless_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->cashless_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->cashless_periodicity]?></td>
<td>
<?php if (!$expenses->cashless_value) { ?>
���������
<?php } else { 
echo $expenses->cashless_value . ' ';
echo $this->data_specify_array['currency'][$expenses->cashless_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>


<?php
// ��������� ��������� ������� ���������
 if ($expenses->cash_value != '') {?>
<tr>
<td class="first"><strong>��������� ��������� ������� ���������</strong><?php
if ($expenses->cash_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->cash_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->cash_periodicity]?></td>
<td>
<?php if (!$expenses->cash_value) { ?>
���������
<?php } else { 
echo $expenses->cash_value . ' ';
echo $this->data_specify_array['currency'][$expenses->cash_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>


<?php
// ������ �����
 if ($expenses->safe_value != '') {?>
<tr>
<td class="first"><strong>������ �����</strong><?php
if ($expenses->safe_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->safe_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->safe_periodicity]?></td>
<td>
<?php if (!$expenses->safe_value) { ?>
���������
<?php } else { 
echo $expenses->safe_value . ' ';
echo $this->data_specify_array['currency'][$expenses->safe_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>


<?php
// �������� �� ������������ �������� � ���� ��������� �������
 if ($expenses->transferring_value != '') {?>
<tr>
<td class="first"><strong>�������� �� ������������ �������� � ���� ��������� �������</strong><?php
if ($expenses->transferring_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->transferring_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->transferring_periodicity]?></td>
<td>
<?php if (!$expenses->transferring_value) { ?>
���������
<?php } else { 
echo $expenses->transferring_value . ' ';
echo $this->data_specify_array['currency'][$expenses->transferring_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>


<?php
// ������� �� ��������� ���������
 if ($expenses->delinquency_value != '') {?>
<tr>
<td class="first"><strong>������� �� ��������� ���������</strong><?php
if ($expenses->delinquency_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->delinquency_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->delinquency_periodicity]?></td>
<td>
<?php if (!$expenses->delinquency_value) { ?>
���������
<?php } else { 
echo $expenses->delinquency_value . ' ';
echo $this->data_specify_array['currency'][$expenses->delinquency_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>


</table></div>
<?php } ?>



<div class="program">
<h2>���������� ����������</h2>
<table>

<?php if ($data->url) { ?> 
<tr>
<td class="first">����:</td>
<td><noindex><a target="_blank" rel="nofollow" href="http://<?php echo $data->url; ?>">�������� ��������� �� ����� �����</a></noindex></td>
</tr>
<?php }?>
<?php if ($data->email) { ?> 
<tr>
<td class="first">E-mail:</td>
<td><noindex><a rel="nofollow" href="mailto:<?php echo $data->email; ?>"><?php echo $data->email; ?></a></noindex></td>
</tr>
<?php }?>

<tr>
<td class="first">�������:</td>
<td><strong><?php echo $data->phone; ?></strong></td>
</tr>
</table>
</div>

<div class="program noborder">
<h2>������������ ������</h2>
<table><tr>
<td class="first">����:</td>
<td><strong><?php 
$date = new Dune_Data_Parsing_Date($data->actual_date, Dune_Data_Parsing_Date::TYPE_DATE);
echo $date->getDay() . '.' . $date->getMonth() . '.' . $date->getYear();

?></strong></td>
</tr></table>
</div>
</div></div>

<?php
}
else {
?>
<h1>��� ������</h1>
<?php
}
?>