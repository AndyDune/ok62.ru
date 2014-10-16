<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title><?php echo $this->title;?></title>
<meta name="description" content="<?php echo htmlspecialchars($this->description); ?>" />
<meta name="keywords" content="<?php echo htmlspecialchars($this->keywords); ?>" />
<?php
echo $this->css;
echo $this->js;
?>
</head>
<body>

<?php
echo $this->object_card;
?>
</body>