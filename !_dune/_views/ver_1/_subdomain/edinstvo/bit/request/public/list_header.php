<?php
switch ($this->deal)
{
    case 'sale':
        $name = 'Заявки на покупку недвижимости';
        ?><h1><?php echo $name ?></h1><?php
        $this->setResult('title', $name . '. ');
    break;
    case 'rent':
        $name = 'Заявки на аренду недвижимости';
        ?><h1><?php echo $name ?></h1><?php
        $this->setResult('title', $name . '. ');
    break;
    default:
        $name = 'Заявки на покупку или аренду недвижимости';
        ?><h1><?php echo $name ?></h1><?php
        $this->setResult('title', $name . '. ');
}
?>