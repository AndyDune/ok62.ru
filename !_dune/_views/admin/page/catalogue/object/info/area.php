<h1>Редактирвание района области</h1>

<form action="<?php echo $this->form_action; ?>" method="post">
<table>
<tr>
<td>Название </td><td>
<input name="name" type="text" value="<?php echo $this->data_area['name']?>" />
</td>
</tr><tr>
<td>Порядок </td><td>
<input name="order" type="text" value="<?php echo $this->data_area['order'] ?>" />
</td>
<tr>
</table>
<input name="region_id" type="hidden" value="<?php echo $this->data_region['id'] ?>" />
<input name="id" type="hidden" value="<?php echo $this->data_area['id'] ?>" />
<input name="link_list" type="hidden" value="<?php echo $this->link_list ?>" />
<input name="_do_" type="hidden" value="save" />
<input name="go" type="submit" value="Сохранить" />

</form>