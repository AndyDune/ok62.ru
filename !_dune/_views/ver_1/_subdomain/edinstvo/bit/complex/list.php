<?php
$data = $this->data;
?>
<div id="crumbs-info"><?php echo $this->crumbs; ?></div>
<div id="house-info">
<h1>Все комплексы</h1>
<?php

	if (count($data))
	{
	    foreach ($data as $value)
	    {
            $complex = new Display_Complex_OneInList();
            $complex->data = $value;
            echo $complex->render();
	    }
	}
	?>

</div>