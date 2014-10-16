<div id="menu-left">
<?php
$path = '/';
foreach ($this->array_command as $value)
	$path .= $value . '/';
if ($this->menu_left and is_array($this->menu_left))
{
	foreach ($this->menu_left as $value_main)
	{
		if ($value_main['access'] > Dune_Variables::$userStatus)
			continue;
		if (isset($value_main['command']) and $value_main['command'])
			$value_main['command'] .= '/';
		else 
			$value_main['command'] = '';
		echo '<dl><dt>' . $value_main['name'] . '</dt><dd>';
		if (count($value_main['items']) > 0)
		{
			echo '<ul>';
			foreach ($value_main['items'] as $value)
			{
				if ($value['access'] > Dune_Variables::$userStatus)
					continue;
				if (!isset($value['param']))
					$value['param'] = '';
				echo '<li><a href="' . $path . $value_main['command'] . $value['command'];
				echo '/' . $value['param'] . '">' . $value['name'] . '</a></li>';
			}
			echo '</ul>';
		}
		echo '</dd></dl>';
	}
	
}
?>
</div>