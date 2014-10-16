<div id="request">
<table>
<?php

$name_type = new Dune_Array_Container($this->types, 'недвижимость');
foreach ($this->list as $value) { ?>
<tr>
<td><a href="/public/request/info/<?php echo $value['id']; ?>/"><?php echo ucfirst($name_type[$value['type']]['name']); ?></a></td>
</tr>
<?php } ?>
</table>
</div>