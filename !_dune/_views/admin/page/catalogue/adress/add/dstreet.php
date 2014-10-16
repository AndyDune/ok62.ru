<h1>Добавление улицы городского района</h1>

<form action="<?php echo $this->form_action; ?>" method="post">
<table>
<tr>
<td>Название </td><td>
<input name="name" type="text" value="<?php echo $this->name ?>" />
</td>
</tr>

<tr>
<td>Порядок </td><td>
<input name="order" type="text" value="<?php echo $this->order ?>" />
</td>
<tr>

<tr>
<td>Указывать что улица</td><td>
<input name="adding" type="checkbox" value="1" checked="checked" />
</td>
</tr>


</table>
<input name="district_id" type="hidden" value="<?php echo $this->data_district['id'] ?>" />
<input name="link_list" type="hidden" value="<?php echo $this->link_list; ?>" />
<input name="_do_" type="hidden" value="save" />
<input name="go" type="submit" value="Сохранить" />

</form>