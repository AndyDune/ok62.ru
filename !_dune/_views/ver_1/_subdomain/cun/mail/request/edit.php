<div id="letter-body">
<h1>���� ��������������� ������ �� ������������ ������������.</h1>
<p>���������� ������ ������ �� �����: <a href="http://<?php echo $this->domain; ?>/public/request/info/<?php echo $this->id; ?>/"><?php echo $this->domain?></a></p>
<p>�������, ��� ��������� ����� ������ ���������� ���� �������������� �� ����� <a href="http://<?php echo $this->domain?>"><?php echo $this->domain?></a> � ����� ��������������� �����.</p>

<hr />
����� ������:
<hr />
<h2>���� <?php
$x= 0;
if ($this->data['sale'])
{
    $x = 1;
    ?> ������<?php    
}

if ($this->data['rent'])
{
    if ($x)
    {
        ?> ��� <?php
    }
    ?> ����������<?php    
}
?>


<?php foreach ($this->types as $key => $value) 
{
    
    if ($this->data['type'] == $key)
    {
        ?> <?php echo $value['nameTo'];
    }
} ?>
</h2>

<dl><dt><strong>��������������:</strong></dt>
<dd>
<p class="in-dd">
<?php echo str_replace("\r\n", '<br />', $this->data['adress']) ?>
</p>
</dd>
</dl>

<?php ob_start(); ?>
<p class="in-dd"><strong>������:</strong>
<?php
$x = false;
 if ($this->data['rooms_count_1']) { $x = true; ?>1<?php } 
 if ($this->data['rooms_count_2']) {
    if ($x) { ?>, <?php }      
    $x = true; ?>2<?php } 
 if ($this->data['rooms_count_3']) {
     if ($x) { ?>, <?php }      
     $x = true; ?>3<?php } 
 if ($this->data['rooms_count_4']) {
     if ($x) { ?> ��� <?php }      
     $x = true; ?>����� 3-�<?php } ?>
<?php if ($this->data['rooms_count_text']) { 
    if ($x) { ?> (<?php }
echo $this->data['rooms_count_text'];
    if ($x) { ?>) <?php }
    $x = true;
} ?> 
</p>
<?php 
$text = ob_get_clean();
if ($x)
   echo $text;
?>
 


<p><strong>��������� ��:</strong> <?php echo $this->data['price_to']; ?></p>

<dl><dt><strong>����� ��������� �����:</strong></dt><dd>
<p class="in-dd">
<?php echo $this->data['variant_text'] ?>

<?php if ($this->data['variant_date']) { ?>
 <em>��������� ������� ��</em> <?php echo $this->data['variant_date'] ?>
<?php } ?>
</p>
</dd></dl>

<dl><dt><strong>��������:</strong></dt>
<dd>
<p class="in-dd">
<?php echo str_replace("\r\n", '<br />', $this->data['contact']) ?>
</p>
</dd>
</dl>

</div>