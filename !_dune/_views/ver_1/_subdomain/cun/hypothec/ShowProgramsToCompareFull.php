<?php
echo $this->crumbs;
$vars = Dune_Variables::getInstance();

if (count($this->programs_list))
{
$table_rows_total = count($this->programs_list);
$tds = '';
$tds_empty = '';
foreach ($this->programs_list as $info)
{
    $tds .= '<td class="programs-list-one-info-td"><span class="content-center-one-info"><a href="/modules.php?name=Hypothec&op=ShowFixedPProgram&programID=' . $info->pprogram_id . '"><strong>' . $info->name_pp . '</strong></a></span><span class="pasporka">&nbsp;</span></td>';
    $tds_empty .= '<td class="programs-list-one-info-td"></td>';
    
}
?>
<hr />
<div class="text noborder">


<h1>Отобранные программы ипотечного кредитования</h1>
<p>Подробная информация</p>
<a id="to-search" href="/modules.php?name=Hypothec&op=ShowProgramsToCompare" title="Перейдите для смены порядка отбражения списка">Краткое сравнение</a>
</div>

<div id="programs-list-mach">

<div class="redborder"><div class="bluebg">
<div class="program">

<table>
<tr class="programs-list-h2"><td><h2>Общие данные</h2></td><?php echo $tds;?>
</tr>
<tr class="hilight">
<td class="first">Банк:</td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td"><strong><span class="bankname"><a href="/modules.php?name=Hypothec&op=ShowFixedBank&bankID=<?php echo $info->id; ?>"><?php echo $info->name; ?></a></span></strong></td>
<?php } ?>
</tr>

<tr class="hilight">
<td class="first">Вид кредитования:</td>
<?php foreach ($this->programs_list as $info)
{
?><td class="programs-list-one-info-td"><?php 
foreach ($info->kinds_corr as $value)
{
    echo '<strong>' . $this->data_specify_array['kinds'][$value] . '</strong>';
}
?>
</td>
<?php } ?>

</tr>
<tr class="hilight">
<td class="first">Рынок недвижимости:</td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td"><strong><?php echo $this->data_specify_array['marketid'][$info->marketid]?></strong></td>
<?php } ?>

</tr>
<!--     ЗАГОЛОВОК -->
<tr class="programs-list-h2"><td><h2>Условия кредита</h2></td><?php echo $tds_empty;?></tr>
<tr class="hilight">
<td class="first">Валюта кредита:</td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td"><strong><?php echo $this->data_specify_array['currencyid_rus'][$info->currencyid]?></strong></td>
<?php } ?>
</tr>
<tr class="hilight">
<td class="first">Ставка кредита:</td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<strong><?php echo number_format($info->rate_pp, 2); ?> %</strong>
</td>
<?php } ?>
</tr>
<tr class="hilight">
<td class="first">Обеспечение кредита:</td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<strong><?php echo $this->data_specify_array['loansecurityid'][$info->loansecurityid]?></strong>
</td>
<?php } ?>

</tr>
<tr class="hilight">
<td class="first">Срок кредита</td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<strong>
<?php
if ($info->creditperiod_min_pp)
{
?>
от 
<?php echo $info->creditperiod_min_pp; } ?>
 до <?php echo $info->creditperiod_pp;
	   if ($this->age)
	   {
	           
	       $to_p = $info->agemax - $this->age;
	       if ($to_p <= 0)
	       {
                echo ' (<a class="tt" href="#pensia" title="' . $vars->text_more_then_age_max . '">*</a>)';	           
	       }
	       else if ($to_p < $info->creditperiod_pp)
	           echo ' (<a class="tt" href="#pensia" title="' . $vars->text_age_to_pensia_near .'">' . $to_p . '*</a>)';
	           
	   }

?> лет</strong>
</td>
<?php } ?>
</tr>

<tr class="hilight">
<td class="first">Размер кредита:</td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<strong><?php echo number_format($info->sumcreditmin_pp, 0, '.', ' '); ?> – <?php echo number_format($info->sumcreditmax_pp, 0, '.', ' '); ?></strong>
</td>
<?php } ?>

</tr>
<tr class="hilight">
<td class="first">Первоначальный взнос:</td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<strong>от <?php echo $info->firstpayment_pp; ?> %</strong>
<?php
if ($info->firstpayment_comments_pp)
{?>
<em><?php echo $info->firstpayment_comments_pp; ?></em>
<?php }?>
</td>
<?php } ?>

</tr>
<tr class="hilight">
<td class="first">Подтверждение дохода:</td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<?php
if ($info->incconfirm_corr->count())
{
    foreach ($info->incconfirm_corr as $value)
    {
        echo '<strong>' . $this->data_specify_array['incconfirmid'][$value] . '</strong>';
    }
}
else 
{
?><strong>Нет данных</strong><?php
}
?>
</td>
<?php } ?>

</tr>
<tr class="hilight">
<td class="first"><span class="no-wrap">Срок рассмотрения заявки:</span></td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<strong>до <?php echo $info->approveperiod; ?> дней</strong>
</td>
<?php } ?>
</tr>

<!--
<tr>
<td class="first">Нотариальное оформление договора:</td>
<td><strong>Требуется</strong></td>
</tr>
-->
<!-- ЗАГОЛОВОК-->
<tr class="programs-list-h2"><td><h2>Требования к заемщику</h2></td><?php echo $tds_empty;?></tr>
<tr class="hilight">
<td class="first">Возраст заемщика:</td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<strong><?php echo $info->agemin; ?> – <?php echo $info->agemax; ?> лет</strong>
 <?php

	   if ($this->age)
	   {
	       $to_p = $info->agemax - $this->age;
	       if ($to_p <= 0)
	       {
                echo '<p class="message-red-stick" style="text-align:center;">' . $vars->text_more_then_age_max . '</p>';
	       }
	   }

?>

</td>
<?php } ?>
</tr>


<tr class="hilight">
<td class="first">Гражданство РФ:</td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<strong><?php echo $this->data_specify_array['nationality'][$info->nationality]?></strong>
</td>
<?php } ?>
</tr>


<tr class="hilight">
<td class="first">Регистрация по месту получения кредита:</td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<strong><?php echo $this->data_specify_array['registration'][$info->registration]?></strong>
</td>
<?php } ?>
</tr>


<tr class="hilight">
<td class="first">Общий трудовой стаж:</td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<?php if (!$info->seniority_total) {?>
<strong>Не требуется</strong>
<?php } else {?>
<strong>от <?php echo $info->seniority_total; ?> лет</strong>
<?php } ?>
</td>
<?php } ?>
</tr>


<tr class="hilight">
<td class="first">Трудовой стаж на последнем месте:</td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<?php if (!$info->seniority_last) {?>
<strong>Не требуется</strong>
<?php } else {?>
<strong>от <?php echo $info->seniority_last; ?> месяцев</strong>
<?php } ?>
</td>
<?php } ?>
</tr>


<!-- ЗАГОЛОВОК-->
<tr class="programs-list-h2"><td><h2>Созаемщики и поручители</h2></td><?php echo $tds_empty;?></tr>

<tr class="hilight">
<td class="first">Наличие поручителей:</td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<?php if (!$info->guarantor) {?>
<strong>Не требуется</strong>
<?php } else {?>
<strong><?php echo $this->data_specify_array['guarantor'][$info->guarantor]; ?></strong>
<?php
if ($info->guarantor_comment) {
?>    
  <p class="progam-comment"><em><?php echo $info->guarantor_comment;?></em></p>
<?php }} ?>
</td>
<?php } ?>
</tr>

<tr class="hilight">
<td class="first">Привлечение созаемщиков:</td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<?php if (!$info->soborrower) {?>
<strong>Нет</strong>
<?php } else {?>
<strong><?php echo $this->data_specify_array['soborrower'][$info->soborrower]; ?></strong>
<?php
if ($info->soborrower_comment) {
?>    
  <p class="progam-comment"><em><?php echo $info->soborrower_comment;?></em></p>
<?php    
}
} ?>
</td>
<?php } ?>
</tr>


<!-- ЗАГОЛОВОК-->
<tr class="programs-list-h2"><td><h2>Условия погашения кредита</h2></td><?php echo $tds_empty;?></tr>

<tr class="hilight">
<td class="first">Платежи:</td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<strong><?php echo $this->data_specify_array['paymenttypeid'][$info->paymenttypeid]?></strong>
</td>
<?php } ?>
</tr>

<tr class="hilight">
<td class="first">Досрочное погашение без санкций:</td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<?php if (!$info->advrepay) {?>
<strong>Нет ограничений</strong>
<?php } else if ($info->advrepay == 0) {?>
<strong>Нет ограничений</strong>
<?php } else {
if ($info->advrepay == 1)
    $m = 'месяца';
else
    $m = 'месяцев';
    ?>
<strong>после <?php echo $info->advrepay . ' ' . $m; ?></strong>
<?php } ?>
</td>
<?php } ?>

</tr>
<tr class="hilight">
<td class="first"><span>Минимальная сумма досрочного платежа:</span></td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">

<?php if (!$info->advrepay_min_sum) {?>
<strong>Без ограничений</strong>
<?php } else if ($info->advrepay_min_sum == 0) {?>
<strong>Нет ограничений</strong>
<?php } else {
    ?>
<strong><?php echo $info->advrepay_min_sum; ?> 
<?php echo $this->data_specify_array['currency'][$info->advrepay_min_sum_currencyid]?>
</strong>
<?php } ?>

</td>
<?php } ?>
</tr>



<!-- ЗАГОЛОВОК-->
<tr class="programs-list-h2"><td><h2>Расходы по кредиту</h2></td><?php echo $tds_empty;?></tr>

<!--------------------->
<tr class="hilight">
<td class="first"><strong>Рассмотрение кредитной заявки</strong></td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<!-- единица -->
<?php if (!$info->examination_value) { ?>
<span class="content-center-one-info">Бесплатно</span>
<?php } else { 
?><span class="content-center-one-info"> <?php
echo $info->examination_value . '';
echo $this->data_specify_array['currency'][$info->examination_value_unit];

if ($info->examination_periodicity)
    echo ' (' . $this->data_specify_array['periodicity'][$info->examination_periodicity] . ')';?>
</span>
<!-- единица -->
</td>
<?php } }?>
</tr>
<!--------------------->

<!--------------------->
<tr class="hilight">
<td class="first"><strong>Проверка документов и объекта ипотеки</strong></td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<!-- единица -->
<span class="content-center-one-info">
<?php
if ($info->check_value == ''){
?>Нет
<?php } else {
 if (!$info->check_value) { ?>
Бесплатно
<?php } else { 
echo $info->check_value . '';
echo $this->data_specify_array['currency'][$info->check_value_unit]
?>
<?php } 
if ($info->check_value)
    echo ' (' . $this->data_specify_array['periodicity'][$info->check_periodicity] . ')';?>

<?php } ?>    
</span>
<!-- единица -->
</td>
<?php } ?>
</tr>
<!--------------------->



<!--------------------->
<tr class="hilight">
<td class="first"><strong>Оценка объекта ипотеки</strong></td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<!-- единица -->
<span class="content-center-one-info">
<?php
//if ($info->valuation_value > 0 and $info->valuation_value < 0.01){
if ($info->valuation_value == ''){
?>Нет
<?php } else {
if (!$info->valuation_value) { ?>
Бесплатно
<?php } else { 
echo $info->valuation_value . '';
echo $this->data_specify_array['currency'][$info->valuation_value_unit]
?>
<?php } 
if ($info->valuation_value)
    echo ' (' . $this->data_specify_array['periodicity'][$info->valuation_periodicity] . ')';
}    
    ?>

    
</span>    
<!-- единица -->
</td>
<?php } ?>
</tr>
<!--------------------->


<!--------------------->
<tr class="hilight">
<td class="first"><strong>Страхование</strong></td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<!-- единица -->
<span class="content-center-one-info">
<?php
//if ($info->insurance_value > 0 and $info->insurance_value < 0.01){
if ($info->insurance_value == ''){
?>Нет
<?php } else {
if (!$info->insurance_value) { ?>
Бесплатно
<?php } else { 
echo $info->insurance_value . '';
echo $this->data_specify_array['currency'][$info->insurance_value_unit]
?>
<?php } 
if ($info->insurance_value)
    echo ' (' . $this->data_specify_array['periodicity'][$info->insurance_periodicity] . ')';
?></span><?php
if ($info->insurance_info)
    echo '<em>' . $info->insurance_info . '</em>';?>
<?php } ?>
<!-- единица -->
</td>
<?php } ?>
</tr>
<!--------------------->


<!--------------------->
<tr class="hilight">
<td class="first"><strong>Комиссия за выдачу кредита</strong></td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<!-- единица -->
<span class="content-center-one-info">
<?php
if ($info->commission_value == ''){
?>Нет
<?php } else { 

if (!$info->commission_value) { ?>
Бесплатно
<?php } else { 
echo $info->commission_value . '';
echo $this->data_specify_array['currency'][$info->commission_value_unit]
?>
<?php } 
if ($info->commission_value)
    echo ' (' . $this->data_specify_array['periodicity'][$info->commission_periodicity] . ')';
?></span><?php
if ($info->commission_info)
    echo '<em>' . $info->commission_info . '</em>';?>
<?php } ?>
<!-- единица -->
</td>
<?php } ?>
</tr>
<!--------------------->


<!------  Открытие ссудного счета --------------->
<tr class="hilight">
<td class="first"><strong>Открытие ссудного счета</strong></td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<!-- единица -->
<span class="content-center-one-info">
<?php
if ($info->account_commission_value == ''){
?>Нет
<?php } else { 

if (!$info->account_commission_value) { ?>
Бесплатно
<?php } else { 
echo $info->account_commission_value . '';
echo $this->data_specify_array['currency'][$info->account_commission_value_unit]
?>
<?php } 
if ($info->account_commission_value)
    echo ' (' . $this->data_specify_array['periodicity'][$info->account_commission_periodicity] . ')';
?></span><?php    
if ($info->account_commission_info)
    echo '<em>' . $info->account_commission_info . '</em>';?>
<?php } ?>
<!-- единица -->
</td>
<?php } ?>
</tr>
<!--------------------->



<!------  Ведение ссудного счета --------------->
<tr class="hilight">
<td class="first"><strong>Ведение ссудного счета</strong></td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<!-- единица -->
<span class="content-center-one-info">
<?php
if ($info->lead_account_value == ''){
?>Нет
<?php } else { 

if (!$info->lead_account_value) { ?>
Бесплатно
<?php } else { 
echo $info->lead_account_value . '';
echo $this->data_specify_array['currency'][$info->lead_account_value_unit]
?>
<?php } 
if ($info->lead_account_value)
    echo ' (' . $this->data_specify_array['periodicity'][$info->lead_account_periodicity] . ')';
?></span><?php    
if ($info->lead_account_info)
    echo '<em>' . $info->lead_account_info . '</em>';?>
<?php } ?>
<!-- единица -->
</td>
<?php } ?>
</tr>
<!--------------------->



<!------  Оформление документов по ипотеке --------------->
<tr class="hilight">
<td class="first"><strong>Оформление документов по ипотеке</strong></td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<!-- единица -->
<span class="content-center-one-info">
<?php
if ($info->make_document_value == ''){
?>Нет
<?php } else { 
if (!$info->make_document_value) { ?>
Бесплатно
<?php } else { 
echo $info->make_document_value . '';
echo $this->data_specify_array['currency'][$info->make_document_value_unit]
?>
<?php } 
if ($info->make_document_value)
    echo ' (' . $this->data_specify_array['periodicity'][$info->make_document_periodicity] . ')';
?></span><?php     
if ($info->make_document_info)
    echo '<em>' . $info->make_document_info . '</em>';?>
<?php } ?>
<!-- единица -->
</td>
<?php } ?>
</tr>
<!--------------------->


<!------  Безналичное перечисление кредитных средств --------------->
<tr class="hilight">
<td class="first"><strong>Безналичное перечисление кредитных средств</strong></td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<!-- единица -->
<span class="content-center-one-info">
<?php
if ($info->cashless_value == ''){
?>Нет
<?php } else { 
if (!$info->cashless_value) { ?>
Бесплатно
<?php } else { 
echo $info->cashless_value . '';
echo $this->data_specify_array['currency'][$info->cashless_value_unit]
?>
<?php } 
if ($info->cashless_value)
    echo ' (' . $this->data_specify_array['periodicity'][$info->cashless_periodicity] . ')';
?></span><?php     
if ($info->cashless_info)
    echo '<em>' . $info->cashless_info . '</em>';?>

<?php } ?>    
<!-- единица -->
</td>
<?php } ?>
</tr>
<!--------------------->


<!------  Получение кредитных средств наличными --------------->
<tr class="hilight">
<td class="first"><strong>Получение кредитных средств наличными</strong></td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<!-- единица -->
<span class="content-center-one-info">
<?php
//if ($info->cash_value > 0 and $info->cash_value < 0.01){
if ($info->cash_value == ''){
?>Нет
<?php } else { 
if (!$info->cash_value) { ?>
Бесплатно
<?php } else { 
echo $info->cash_value . '';
echo $this->data_specify_array['currency'][$info->cash_value_unit]
?>
<?php } 
if ($info->cash_value)
    echo ' (' . $this->data_specify_array['periodicity'][$info->cash_periodicity] . ')';
?></span><?php    
if ($info->cash_info)
    echo '<em>' . $info->cash_info . '</em>';?>

<?php }?>    
<!-- единица -->
</td>
<?php }?>
</tr>
<!--------------------->


<!------  Аренда сейфа --------------->
<tr class="hilight">
<td class="first"><strong>Аренда сейфа</strong></td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<!-- единица -->
<span class="content-center-one-info">
<?php 
//if ($info->safe_value > 0 and $info->safe_value < 0.01){
if ($info->safe_value == ''){
?>Нет
<?php } else { 
if (!$info->safe_value) { ?>
Бесплатно
<?php } else { 
echo $info->safe_value . '';
echo $this->data_specify_array['currency'][$info->safe_value_unit]
?>
<?php } 
if ($info->safe_value)
    echo ' (' . $this->data_specify_array['periodicity'][$info->safe_periodicity] . ')';
?></span><?php     
if ($info->safe_info)
    echo '<em>' . $info->safe_info . '</em>';?>

<?php }?>    
<!-- единица -->
</td>
<?php }?>
</tr>
<!--------------------->


<!------  Комиссия за перечисление платежей в счет погашения кредита --------------->
<tr class="hilight">
<td class="first"><strong>Комиссия за перечисление платежей в счет погашения кредита</strong></td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<!-- единица -->
<span class="content-center-one-info">
<?php if (!$info->transferring_value) { ?>
Бесплатно
<?php } else { 
echo $info->transferring_value . '';
echo $this->data_specify_array['currency'][$info->transferring_value_unit]
?>
<?php } 
if ($info->transferring_value)
    echo ' (' . $this->data_specify_array['periodicity'][$info->transferring_periodicity] . ')';
?></span><?php      
if ($info->transferring_info)
    echo '<em>' . $info->transferring_info . '</em>';?>

<!-- единица -->
</td>
<?php } ?>
</tr>
<!--------------------->



<!------  Санкции за просрочку погашения --------------->
<tr class="hilight">
<td class="first"><strong>Санкции за просрочку погашения</strong></td>
<?php foreach ($this->programs_list as $info)
{

?>
<td class="programs-list-one-info-td">
<!-- единица -->
<span class="content-center-one-info">
<?php if (!$info->delinquency_value) { ?>
Нет данных
<?php } else { 
echo $info->delinquency_value . '';
echo $this->data_specify_array['currency'][$info->delinquency_value_unit]
?>
<?php } 
if ($info->delinquency_value)
    echo ' (' . $this->data_specify_array['periodicity'][$info->delinquency_periodicity] . ')';
?></span><?php    
if ($info->delinquency_info)
    echo '<em>' . $info->delinquency_info . '</em>';?>

<!-- единица -->
</td>
<?php } ?>
</tr>
<!--------------------->



<!-- ЗАГОЛОВОК-->
<tr class="programs-list-h2"><td><h2>Контактная информация</h2></td><?php echo $tds;?></tr>


<tr class="hilight">
<td class="first">Сайт</td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td" style="text-align:center;">
<?php if ($info->url) { 
    $url_show = 'Сайт банка';
    if (strlen($info->url) > 3)
    {
        $x_point = strpos($info->url, '.ru');
        $substr = strpos('.', $info->url);
        $str = $info->url;
        $new_str = array();
        for ($x = $x_point; $x >= 0; $x--)
        {
            if ($str[$x] != '/')
                $new_str[] = $str[$x];
            else 
                break;
        }
        krsort($new_str, SORT_NUMERIC);
        $url_show = implode('', $new_str) . 'ru';
    }
    else 
        $url_show = 'Сайт банка';
    
?><a target="_blank" rel="nofollow" href="http://<?php echo $info->url; ?>"><?php echo $url_show; ?></a>
<?php }?>
</td>
<?php } ?>
</tr>


<tr class="hilight">
<td class="first">E-mail</td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td" style="text-align:center;">
<?php if ($info->email) { ?> 
<a rel="nofollow" href="mailto:<?php echo $info->email; ?>"><?php echo $info->email; ?></a>
<?php }?>
</td>
<?php } ?>
</tr>


<tr class="hilight">
<td class="first">Телефон</td>
<?php foreach ($this->programs_list as $info)
{
?>
<td class="programs-list-one-info-td">
<?php if ($info->phone) { ?> 
<strong><?php echo $info->phone; ?></strong>
<?php }?>
</td>
<?php } ?>
</tr>



</table>
</div>







</div></div>

</div>
<?php
}
else {
?>
<h1>Нет данных</h1>
<?php
}
?>