<?php
switch ($this->deal)
{
    case 'sale':
        $name = '������ �� ������� ������������';
        ?><h1><?php echo $name ?></h1><?php
        $this->setResult('title', $name . '. ');
    break;
    case 'rent':
        $name = '������ �� ������ ������������';
        ?><h1><?php echo $name ?></h1><?php
        $this->setResult('title', $name . '. ');
    break;
    default:
        $name = '������ �� ������� ��� ������ ������������';
        ?><h1><?php echo $name ?></h1><?php
        $this->setResult('title', $name . '. ');
}
?>