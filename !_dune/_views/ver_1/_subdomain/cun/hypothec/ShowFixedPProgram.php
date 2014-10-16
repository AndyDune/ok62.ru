<?php
echo $this->crumbs;
$vars = Dune_Variables::getInstance();
if (!$vars->pensia_age)
    $vars->pensia_age = 65;


if (count($this->info))
{
//    $name = $this->data_specify_array;
//    echo $this->info;
    
?>
<hr />
<div class="text noborder"><h1><?php echo $this->info->name_pp;?></h1>
</div>
<p><?php echo str_replace(array("\r\n", "\n"), '<br />', $this->info->bonus);?></p>
<p><?php echo str_replace(array("\r\n", "\n"), '<br />', $this->info->comment_pp);?></p>
<div class="redborder"><div class="bluebg">

<div class="program">
<h2>Общие данные</h2>
<table>

<tr>
<td class="first">Банк:</td>
<td><span class="bankname"><a href="/modules.php?name=Hypothec&op=ShowFixedBank&bankID=<?php echo $this->info->bank_id; ?>"><?php echo $this->info->name; ?></a></span></td>
</tr>

<tr>
<td class="first">Вид кредитования:</td>
<td><?php 
foreach ($this->kinds_corr as $value)
{
    echo '<strong>' . $this->data_specify_array['kinds'][$value] . '</strong><br />';
}
?>

</td>
</tr>
<!--
<tr>
<td class="first">Рынок недвижимости:</td>
<td><strong><?php echo $this->data_specify_array['marketid'][$this->info->marketid]?></strong></td>
</tr>
-->

</table>
</div>

<div class="program">
<h2>Условия кредита</h2>
<table>
<tr class="mover-highlight">
<td class="first">Валюта кредита:</td>
<td><strong><?php echo $this->data_specify_array['currencyid_rus'][$this->info->currencyid_pp]?></strong></td>
</tr>
<tr>
<td class="first">Ставка кредита:</td>
<td>
<strong><?php echo number_format($this->info->rate_pp, 2); ?> %</strong>
<?php
if ($this->info->rate_float_pp)
{
?><p class="message-nocolor-stick">Ставка по кредиту плавающая. Увеличивается на <?php echo $this->info->rate_float_value_pp?>% каждые 5 лет.</p><?php
}
?>
</td>
</tr>
<tr>
<td class="first">Обеспечение кредита:</td>
<td><strong><?php echo $this->data_specify_array['loansecurityid'][$this->info->loansecurityid]?></strong></td>
</tr>
<tr>
<td class="first">Срок кредита</td>
<td><strong>
<?php
if ($this->info->creditperiod_min_pp)
{
?>
от 
<?php echo $this->info->creditperiod_min_pp; } ?>
 до <?php echo $this->info->creditperiod_pp;
?> лет</strong> <?php

// В скобках приписываем сколько лет с учётом пенсии
	   if ($this->age)
	   {
//	       $to_p = $vars->pensia_age - $this->age;
	       $to_p = $this->info->agemax - $this->age;
	       if (($to_p < $this->info->creditperiod_min_pp))
	           echo '<p class="message-red-stick">' . $vars->text_creditperiod_out . '</p>';
	       else if ($to_p < $this->info->creditperiod_pp)
	           echo ' <p class="message-red-stick">' . $vars->text_age_to_pensia_near .' Максимально возможный срок для Вас: ' . $to_p . '</p> ';
	   }

?> </td>
</tr>
<tr>
<td class="first">Размер кредита:</td>
<td><strong><?php echo number_format($this->info->sumcreditmin_pp, 0, '.', ' '); ?> – <?php echo number_format($this->info->sumcreditmax_pp, 0, '.', ' '); ?></strong></td>
</tr>

<tr>
<td class="first">Первоначальный взнос:</td>
<td>
<strong>от <?php echo $this->info->firstpayment_pp; ?> %</strong>
<?php
if ($this->info->firstpayment_comments_pp)
{?><br />
<em><?php echo $this->info->firstpayment_comments_pp; ?></em>
<?php }?>

</td>
</tr>

<?php
if ($this->info->lombard_part_pp)
{
?>
<tr>
<td class="first">Доля от стоимости закладываемого жилья:</td>
<td>
<strong> <?php echo $this->info->lombard_part_pp; ?> %</strong>
<?php
if ($this->info->lombard_part_comments_pp)
{?><br />
<em><?php echo $this->info->lombard_part_comments_pp; ?></em>
<?php }?>

</td>
</tr>

<?php } ?>

<tr>
<td class="first">Подтверждение дохода:</td>

<td>
<?php
foreach ($this->incconfirm_corr as $value)
{
    echo '<strong>' . $this->data_specify_array['incconfirmid'][$value] . '</strong><br />';
}
?>
</td>


</tr>
<tr>
<td class="first">Срок рассмотрения заявки:</td> 
<td><strong>до <?php echo $this->info->approveperiod; ?> дней</strong></td>
</tr>


<tr>
<td class="first">Нотариальное оформление договора:</td>
<td>
<?php if (!$this->info->notarius) {?>
<strong>Не требуется</strong>
<?php } else {?>
<strong>Требуется</strong><br />
<?php echo $this->info->notarius_comment; ?>
<?php } ?>
</td>
</tr>
</table>


</div>

<div class="program">
<h2>Требования к заемщику</h2>
<table>
<tr>
<td class="first">Возраст заемщика:</td>
<td><strong><?php echo $this->info->agemin; ?> – <?php echo $this->info->agemax; ?> лет</strong>
<?php
	   if ($this->age)
	   {
	       $to_p = $this->info->agemax - $this->age;
	       if ($to_p <= 0)
	       {
                echo '<p class="message-red-stick">' . $vars->text_more_then_age_max . '</p>';
	       }
	   }
?>
</td>
</tr>
<tr>
<td class="first">Гражданство РФ:</td>
<td><strong><?php echo $this->data_specify_array['nationality'][$this->info->nationality]?></strong></td>
</tr>
<tr>
<td class="first">Регистрация по месту получения кредита:</td>
<td><strong><?php echo $this->data_specify_array['registration'][$this->info->registration]?></strong></td>
</tr>
<tr>
<td class="first">Общий трудовой стаж:</td><td>
<?php if (!$this->info->seniority_total) {?>
<strong>Не требуется</strong>
<?php } else {
if ($this->info->seniority_total == 1)
    $m = 'года';
else 
    $m = 'лет';
    
    ?>
<strong>от <?php echo $this->info->seniority_total; ?> <?php echo $m?></strong>
<?php } ?>
</td>
</tr>
<tr>
<td class="first">Трудовой стаж на последнем месте:</td>
<td>
<?php if (!$this->info->seniority_last) {?>
<strong>Не требуется</strong>
<?php } else {
if ($this->info->seniority_last == 1)
    $m = 'месяца';
else 
    $m = 'месяцев';
    
    ?>
<strong>от <?php echo $this->info->seniority_last; ?> <?php echo $m?></strong>
<?php } ?>
</td>
</tr>
</table>
</div>

<div class="program">
<h2>Созаемщики и поручители</h2>
<table>
<tr>
<td class="first">Наличие поручителей:</td>
<?php if (!$this->info->guarantor) {?>
<td><strong>Не требуется</strong></td>
<?php } else {?>
<td><strong><?php echo $this->data_specify_array['guarantor'][$this->info->guarantor]; ?></strong>
<?php if ($this->info->guarantor_comment) {
?>    
  <p class="progam-comment"><em><?php echo $this->info->guarantor_comment;?></em></p>
<?php } ?>

</td>
<?php } ?>
</tr>
<tr>
<td class="first">Привлечение созаемщиков:</td>
<?php if (!$this->info->soborrower) {?>
<td><strong>Нет</strong></td>
<?php } else {?>
<td><strong><?php echo $this->data_specify_array['soborrower'][$this->info->soborrower]; ?></strong>
<?php
if ($this->info->soborrower_comment) {
?>    
  <p class="progam-comment"><?php echo $this->info->soborrower_comment;?> </p>
<?php    
} echo '</td>';
} ?>
</tr>
</table>
</div>



<div class="program">
<h2>Условия погашения кредита</h2>
<table>
<tr>
<td class="first">Платежи:</td>
<td><strong><?php echo $this->data_specify_array['paymenttypeid'][$this->info->paymenttypeid]?></strong>
<?php 
if ($this->info->paymenttypeid == 'ANNUIT')
    echo Data_Edinstvo_Hypothec::getOneGlossary(1, $vars->glassary);
?>
</td>
</tr>



<?php if ($this->info->advrepay) {?>
<tr>
<td class="first">Досрочное погашение без санкций:</td>
<?php if ($this->info->advrepay == 100) {?>
<td><strong>Невозможно без санкций</strong></td>
<?php } else if ($this->info->advrepay == 0) {?>
<td><strong>Нет ограничений</strong></td>
<?php } else {
if ($this->info->advrepay == 1)
    $m = 'месяца';
else
    $m = 'месяцев';
    ?>
<td><strong>после <?php echo $this->info->advrepay . ' ' . $m; ?></strong></td>
<?php } ?>
</tr>
<?php } ?>

<?php if ($this->info->advrepay_commen_pp) {?>
<tr>
<td class="first"></td>
<td><?php echo $this->info->advrepay_commen_pp ?></td>
</tr>
<?php } ?>


<tr>
<td class="first">Минимальная сумма досрочного платежа:</td>
<?php if (!$this->info->advrepay_min_sum) {?>
<td><strong>Нет даных</strong></td>
<?php } else if ($this->info->advrepay_min_sum == 0) {?>
<td><strong>Нет ограничений</strong></td>
<?php } else {
    ?>
<td><strong><?php echo $this->info->advrepay_min_sum; ?> 
<?php echo $this->data_specify_array['currency'][$this->info->advrepay_min_sum_currencyid]?>
</strong></td>
<?php } ?>



</tr>
<tr>
<td class="first"></td>
<td><strong></strong></td>
</tr>
</table>
</div>


<?php if ($this->expenses_have) {
$expenses = new Dune_Array_Container($this->expenses);
    ?>
<div class="program noborder"><h2>Расходы по кредиту</h2></div>
<div class="bluetable results"><table width="100%" class="expenses-table">
<tr class="table-header-tr">
<th>Расход</th>
<th>Периодичность</th>
<th>Значение</th>
</tr>



<?php if ($expenses->examination_value != '') {?>
<tr>
<td class="first"><strong>Рассмотрение кредитной заявки</strong></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->examination_periodicity]?></td>
<td>
<?php if (!$expenses->examination_value) { ?>
Бесплатно
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
<td class="first"><strong>Проверка документов и объекта ипотеки</strong><?php
if ($expenses->check_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->check_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->check_periodicity]?></td>
<td>
<?php if (!$expenses->check_value) { ?>
Бесплатно
<?php } else { 
echo $expenses->check_value . ' ';
echo $this->data_specify_array['currency'][$expenses->check_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>


<?php
// Оценка объекта ипотеки
 if ($expenses->valuation_value != '') {?>
<tr>
<td class="first"><strong>Оценка объекта ипотеки</strong><?php
if ($expenses->valuation_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->valuation_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->valuation_periodicity]?></td>
<td>
<?php if (!$expenses->valuation_value) { ?>
Бесплатно
<?php } else { 
echo $expenses->valuation_value . ' ';
echo $this->data_specify_array['currency'][$expenses->valuation_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>

<?php
// Страхование
 if ($expenses->insurance_value != '') {?>
<tr>
<td class="first"><strong>Страхование</strong><?php
if ($expenses->insurance_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->insurance_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->insurance_periodicity]?></td>
<td>
<?php if (!$expenses->insurance_value) { ?>
Бесплатно
<?php } else { 
echo $expenses->insurance_value . ' ';
echo $this->data_specify_array['currency'][$expenses->insurance_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>


<?php
// Комиссия за выдачу кредита
 if ($expenses->commission_value != '') {?>
<tr>
<td class="first"><strong>Комиссия за выдачу кредита</strong><?php
if ($expenses->commission_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->commission_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->commission_periodicity]?></td>
<td>
<?php if (!$expenses->commission_value) { ?>
Бесплатно
<?php } else { 
echo $expenses->commission_value . ' ';
echo $this->data_specify_array['currency'][$expenses->commission_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>


<?php
// Открытие ссудного счета
 if ($expenses->account_commission_value != '') {?>
<tr>
<td class="first"><strong>Открытие ссудного счета</strong><?php
if ($expenses->account_commission_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->account_commission_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->account_commission_periodicity]?></td>
<td>
<?php if (!$expenses->account_commission_value) { ?>
Бесплатно
<?php } else { 
echo $expenses->account_commission_value . ' ';
echo $this->data_specify_array['currency'][$expenses->account_commission_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>


<?php
// Ведение ссудного счета
 if ($expenses->lead_account_value != '') {?>
<tr>
<td class="first"><strong>Ведение ссудного счета</strong><?php
if ($expenses->lead_account_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->lead_account_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->lead_account_periodicity]?></td>
<td>
<?php if (!$expenses->lead_account_value) { ?>
Бесплатно
<?php } else { 
echo $expenses->lead_account_value . ' ';
echo $this->data_specify_array['currency'][$expenses->lead_account_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>



<?php
// Оформление документов по ипотеке
 if ($expenses->make_document_value !== '') {?>
<tr>
<td class="first"><strong>Оформление документов по ипотеке</strong><?php
if ($expenses->make_document_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->make_document_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->make_document_periodicity]?></td>
<td>
<?php if (!$expenses->make_document_value) { ?>
Бесплатно
<?php } else { 
echo $expenses->make_document_value . ' ';
echo $this->data_specify_array['currency'][$expenses->make_document_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>

<?php
// Безналичное перечисление кредитных средств
 if ($expenses->cashless_value != '') {?>
<tr>
<td class="first"><strong>Безналичное перечисление кредитных средств</strong><?php
if ($expenses->cashless_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->cashless_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->cashless_periodicity]?></td>
<td>
<?php if (!$expenses->cashless_value) { ?>
Бесплатно
<?php } else { 
echo $expenses->cashless_value . ' ';
echo $this->data_specify_array['currency'][$expenses->cashless_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>


<?php
// Получение кредитных средств наличными
 if ($expenses->cash_value != '') {?>
<tr>
<td class="first"><strong>Получение кредитных средств наличными</strong><?php
if ($expenses->cash_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->cash_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->cash_periodicity]?></td>
<td>
<?php if (!$expenses->cash_value) { ?>
Бесплатно
<?php } else if ($expenses->cash_value < 0.01){
?> Нет
<?php } else { 
echo $expenses->cash_value . ' ';
echo $this->data_specify_array['currency'][$expenses->cash_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>


<?php
// Аренда сейфа
 if ($expenses->safe_value != '') {?>
<tr>
<td class="first"><strong>Аренда сейфа</strong><?php
if ($expenses->safe_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->safe_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->safe_periodicity]?></td>
<td>
<?php if (!$expenses->safe_value) { ?>
Бесплатно
<?php } else if ($expenses->safe_value < 0.01){
?> Нет<?php
} else {     
echo $expenses->safe_value . ' ';
echo $this->data_specify_array['currency'][$expenses->safe_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>


<?php
// Комиссия за перечисление платежей в счет погашения кредита
 if ($expenses->transferring_value != '') {?>
<tr>
<td class="first"><strong>Комиссия за перечисление платежей в счет погашения кредита</strong><?php
if ($expenses->transferring_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->transferring_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->transferring_periodicity]?></td>
<td>
<?php if (!$expenses->transferring_value) { ?>
Бесплатно
<?php } else { 
echo $expenses->transferring_value . ' ';
echo $this->data_specify_array['currency'][$expenses->transferring_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>



<?php
// Комиссия за досрочное погашение кредита
 if ($expenses->advrepay_commission_value != '') {?>
<tr>
<td class="first"><strong>Комиссия за досрочное погашение кредита</strong><?php
if ($expenses->advrepay_commission_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->advrepay_commission_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->advrepay_commission_periodicity]?></td>
<td>
<?php if (!$expenses->advrepay_commission_value) { ?>
Бесплатно
<?php } else { 
echo $expenses->advrepay_commission_value . ' ';
echo $this->data_specify_array['currency'][$expenses->advrepay_commission_value_unit]
?>
<?php } ?>
</td>
</tr>
<?php } ?>



<?php
// Санкции за просрочку погашения
 if ($expenses->delinquency_value !== '') {?>
<tr>
<td class="first"><strong>Санкции за просрочку погашения</strong><?php
if ($expenses->delinquency_info) {
?>    
  <p class="progam-comment"><?php echo $expenses->delinquency_info;?> </p>
<?php    
}?></td>
<td><?php echo $this->data_specify_array['periodicity'][$expenses->delinquency_periodicity]?></td>
<td>
<?php if (!$expenses->delinquency_value) { ?>
Бесплатно
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
<h2>Контактная информация</h2>
<table>

<?php if ($this->info->url) { ?> 
<tr>
<td class="first">Сайт:</td>
<td><noindex><a target="_blank" rel="nofollow" href="http://<?php echo $this->info->url; ?>">страница программы на сайте банка</a></noindex></td>
</tr>
<?php }?>
<?php if ($this->info->email) { ?> 
<tr>
<td class="first">E-mail:</td>
<td><noindex><a rel="nofollow" href="mailto:<?php echo $this->info->email; ?>"><?php echo $this->info->email; ?></a></noindex></td>
</tr>
<?php }?>

<tr>
<td class="first">Телефон:</td>
<td><strong><?php echo $this->info->phone; ?></strong></td>
</tr>
</table>
</div>

<?php
/*
<div class="program noborder">
<h2>Актуальность данных</h2>
<table><tr>
<td class="first">Дата:</td>
<td><strong>
*/
?>
<?php 
//$date = new Dune_Data_Parsing_Date($this->info->actual_date, Dune_Data_Parsing_Date::TYPE_DATE);
//echo $date->getDay() . '.' . $date->getMonth() . '.' . $date->getYear();
?>
<?php
/*</strong></td>
</tr></table>
</div>
*/
?>

</div></div>

<?php
}
else {
?>
<h1>Нет данных</h1>
<?php
}
?>