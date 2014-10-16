<h1>Каталог организаций.</h1>
<?php
foreach ($this->sections as $value)
{
    ?><div class="one-sections"><a href="<?php echo $this->url, $value['name_code'] ?>/"><?php echo ucfirst($value['name']); ?></a></div><?php
}
?>
