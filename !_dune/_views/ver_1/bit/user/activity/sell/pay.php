<div id="catalogue-list">
<table>
<tr>
<th>���</th>
<th>���</th>
<th>�����</th>
<th>����</th>
<th>����������</th>
</tr>

<?php 
/////       ���� ���� �����������
if ($this->count)
{
?>
<?php
$cat_url = new Special_Vtor_Catalogue_Url_Collector();
foreach ($this->data as $one)
{  
$cat_url->setRegion($one['region_id']);
$cat_url->setArea($one['area_id']);
$cat_url->setSettlement($one['settlement_id']);
$cat_url->setStreet($one['street_id']);
$cat_url->setHouse($one['house_number']);
if (Special_Vtor_Settings::$districtPlus)
{
    $cat_url->setDistrict($one['district_id_plus'], true);
}
else 
    $cat_url->setDistrict($one['district_id']);
$cat_url->setType($one['type']);
$cat_url->setObject($one['id']);
     ?>
<tr>
<td><?php echo $one['name_type']?></td>
<td><?php echo $one['id']?></td>
<td>
<a href="<?php echo $cat_url;?>">
<?php echo $one['name_settlement']?>, <?php echo $one['name_district']?>, ����� <?php echo $one['name_street'];
if ($one['house_number'])
{
    ?>, ��� <?php echo $one['house_number'];
}

if ($one['building_number'])
{
    ?>, ������ <?php echo $one['building_number'];
}

if ($one['room'] and $one['type'] == 1)
{
    ?>, �������� <?php echo $one['room'];
}
else if ($one['room'])
{
    ?>, ����� <?php echo $one['room'];
}

?>
</a>
</td>
<td><?php echo number_format($one['price'],0,'.',' ')?> ���.</td>
<td>
<?php
if ($one['activity'] == 1)
{
    ?>�������<?php
}
else
{
        ?>�� �������<?php
}
// <a id="a-save-buttom" href="/user/do/deletefromquery/<?php echo $one['id']/">�������</a>
?>
</td>
</tr>
   <?php    
} ?>
</table>
<?php } else { ?>
</table>
<p class="p-center-say">� ��� ��� �������� � ��������</p>
<?php } ?>








</div>