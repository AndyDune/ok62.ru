<?php
$data = $this->data;
?>
<div id="crumbs-info"><?php echo $this->crumbs; ?></div>
<div id="house-info">
<h1>Все дома</h1>
<?php

	if (count($data))
	{
	    foreach ($data as $value)
	    {
            $house = new Display_House_OneInList();
            $house->data = $value;
            echo $house->render();
	    }
	}
	?>

</div>