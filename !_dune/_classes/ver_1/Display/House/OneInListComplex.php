<?php

class Display_House_OneInListComplex extends Dune_Include_Abstract_Display
{

    /**
     * Используемые стили
     *
     * @var array
     */
    protected $______styles = array(
                                   'complex_house',
                                   'thickbox'
                                   );

    /**
     * Используемые скрипты
     *
     * @var array
     */
    protected $______scripts = array(
                                   'thickbox'
                                   );
                                   
    protected function code()
    {
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
$id = $this->id;
$data = $this->data;
if (!$data)
{
    $house = new Special_Vtor_Sub_Data_House($id);
    if (!($data = $house->getInfo(1)))
        return '';
}




if ($data['have_fasad'])
{
    $img = new Special_Vtor_Sub_Image_Fasad($data['id']);
    $this->fasad = $img->getOneImage();
}
?><table id="table-house-one" width="100%" cellpadding="5" cellspacing="0">
<tr>
<td width="260px" rowspan="2">
<?php if ($data['name'])
{
    ?><p class="p-house-list-name"><a href="/house/<?php echo $data['id']; ?>/"><?php echo $data['name'] ?></a></p><?php
}
?>

<?php if ($this->fasad)
{
    ?><a href="/house/<?php echo $data['id']; ?>/"><img src="<?php echo $this->fasad->getPreviewFileUrl(250); ?>" alt="Фасад дома." /></a><?php
}
?>
</td>
<td colspan="2">
<?php
if ($data['district_id_plus'] > 1)
{
    ?><p class="p-house-list-district">Район: <?php echo $data['name_district_plus'] ?></p><?php
}

// Этажность
if ($data['count_floors'])
{
    ?><p>Этажность: <?php echo $data['count_floors']; ?></p><?php
}
?><td></tr><tr><td><?php

?><div><?php
// Свободных квартир
if ($data['count_room_total'])
{
    ?><p class="strong">Всего квартир - <?php echo $data['count_room_total']; ?></p><?php
}

if ($data['count_room'])
{
    ?><p class="strong">Свободных - <a href="/house/<?php echo $data['id'] ?>/grid/room/"><?php echo $data['count_room']; ?></a></p><?php
}

if ($data['count_room_1'])
{
    ?><p class="strong">1-комн. - <a href="/house/<?php echo $data['id'] ?>/grid/room/"><?php echo $data['count_room_1']; ?></a></p><?php
}
if ($data['count_room_2'])
{
    ?><p class="strong">2-комн. - <a href="/house/<?php echo $data['id'] ?>/grid/room/"><?php echo $data['count_room_2']; ?></a></p><?php
}
if ($data['count_room_3'])
{
    ?><p class="strong">3-комн. - <a href="/house/<?php echo $data['id'] ?>/grid/room/"><?php echo $data['count_room_3']; ?></a></p><?php
}

if ($data['count_room_4'])
{
    ?><p class="strong">других - <a href="/house/<?php echo $data['id'] ?>/grid/room/"><?php echo $data['count_room_4']; ?></a></p><?php
}


?></div>
</td>
<td><div>
<?php
// Свободных нежилых
if ($data['count_nolife_total'])
{
    ?><p class="strong">Всего нежилых помещений: <?php echo $data['count_nolife_total']; ?></p><?php
}

// Свободных нежилых
if ($data['count_nolife'])
{
    ?><p class="strong">Свободных: <a href="/house/<?php echo $data['id'] ?>/grid/nolife/"><?php echo $data['count_nolife']; ?></a></p><?php
}
?></div><div><?php
// Свободных нежилых
if ($data['count_pantry_total'])
{
    ?><p class="strong">Всего кладовых помещений: <?php echo $data['count_pantry_total']; ?></p><?php
}

// Свободных кладовых
if ($data['count_pantry'])
{
    ?><p class="strong">Свободных: <a href="/house/<?php echo $data['id'] ?>/grid/pantry/"><?php echo $data['count_pantry']; ?></a></p><?php
}

?></div>
</td>
</tr>
</table>
<div>
<p class="info-photo">
<?php
$goo = false;
if ($data['gm_x'])
{
    $gm = array('x' => $data['gm_x'], 'y' => $data['gm_y']);
    $goo = true;
}
else if ($data['group_gm_x'])
{
    $gm = array('x' => $data['group_gm_x'], 'y' => $data['group_gm_y']);
    $goo = true;
}
if ($goo)
{
    ?><a href="/map/public/<?php echo $gm['x']; ?>_<?php echo $gm['y']; ?>/"><img width="21" height="21" src="/data/img/subdomain/edinstvo/img/info/map.gif" alt="Смотреть на карте" /></a> <?php
}
if ($data['panorama_id'] or $data['complex_panorama_id'])
{
    ?><a href="/house/<?php echo $data['id']; ?>/panorama/"><img width="21" height="21" src="/data/img/subdomain/edinstvo/img/info/pan.gif" alt="Панорамный обзор" /></a> <?php
}

if ($data['have_photo'] or $data['complex_have_photo'])
{
    ?><a href="/house/<?php echo $data['id']; ?>/photo/"><img width="21" height="21" src="/data/img/subdomain/edinstvo/img/info/photo.gif" alt="Фоторепортаж" /></a> <?php
}
?>

</p><?php
if ($data['text_short'])
{
    ?><p><?php echo $data['text_short']; ?></p><?php
}
?>

</div>


<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        
    }
    
}
    
    