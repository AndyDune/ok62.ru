<div id="container-padding-for-auth">
<?php echo $this->more_edit_menu ?>
<div id="inside">

<?php if ($this->h1_code)
{
    switch ($this->h1_code)
    {
        case '/public/sell/main/':
            ?><h1>���������� ���� ���������� � ��������</h1><?php
        break;
        case '/public/request/main/':
            ?><h1>���������� ���� ������</h1><?php
        break;
        
        case '/user/info/':
            ?><h1>���������� � ������������</h1><?php
        break;
        case '/user/contact/topic/':
            ?><h1>������� � �������������</h1><?php
        break;
        case '/user/list/':
            ?><h1>������������ �����</h1><?php
        break;
        case '/user/contact/':
            ?><h1>���� ��� �������</h1><?php
        break;
        case '/user/nearby/':
            Dune_Variables::addTitle('������ ����������� ��������. ');
            ?><h1>������ ����������� ��������</h1><?php
        break;
        
        case 'no_objects':
            Dune_Variables::addTitle('��� �������� � ���������� �����������. ');
            ?><h1>������ ��������</h1><?php
        break;
        case 'nearby_group_edit':
            Dune_Variables::addTitle('�������������� ������������ �������. ');
            ?><h1>�������������� ������������ �������</h1><?php
        break;
    }
}
 else if ($this->h1) echo '<h1>', $this->h1, '</h1>'; ?>

 
<?php
    echo $this->text_header;
if ($this->crumbs) {
echo $this->crumbs;
} else if (count($this->crumbs_array))
{
    $crumbs_object = Dune_Display_BreadCrumb::getInstance();
    $crumbs_object->addCrumb('�������', '/');
    foreach ($this->crumbs_array as $value)
    {
        $crumbs_object->addCrumb($value['name'], $value['link']);
    }
    ?>

<div id="crumbs"><?php echo $crumbs_object->getString(); ?></div>
<br />
<?php } ?>

<?php echo $this->bookmark ?>
<div id="object-under-bookmark">
<div id="object-info">

<?php echo $this->text;?>


</div>
<div class="ugol-left-top"></div>
<div class="ugol-left-bottom"></div>
<div class="ugol-right-top"></div>
<div class="ugol-right-bottom"></div>
</div>


</div></div>