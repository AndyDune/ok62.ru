<h1>Добавление посёлка района</h1>

<form action="<?php echo $this->form_action; ?>" method="post">
<table>
<tr>
<td>Название </td><td>
<input name="name" type="text" value="<?php echo $this->name ?>" />
</td>
</tr>


<tr>
<td>Тип </td><td>
<?php
$sel = new Dune_Form_Select('type');
foreach ($this->data_type as $key => $value)
{
    if ($key == 1)
        $sel->setOption($value['id'], $value['name'], true);
    else
        $sel->setOption($value['id'], $value['name']);
}
echo $sel->get();
?>
</td>
</tr>
<tr>
<td>Порядок </td><td>
<input name="order" type="text" value="<?php echo $this->order ?>" />
</td>
</tr>
<tr>
<td>Популяция </td><td>
<input name="population" type="text" value="<?php echo $this->population ?>" />
</td>
<tr>


</table>
<input name="area_id" type="hidden" value="<?php echo $this->data_area['id'] ?>" />
<input name="link_list" type="hidden" value="<?php echo $this->link_list; ?>" />
<input name="_do_" type="hidden" value="save" />
<input name="go" type="submit" value="Сохранить" />

</form>