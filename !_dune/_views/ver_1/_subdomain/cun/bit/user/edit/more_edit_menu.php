<div id="more_edit_menu">        
<div>
<table>
        
<?php if ($this->code != 'changepassword'
          and 
          $this->code != 'edit'
          and 
          $this->code != 'info'
            ) { ?>        
        <tr><td>
        <a href="/user/info/">������������ ����������</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <a href="/user/info/" class="current">������������ ����������</a>
        </td></tr>
<?php } ?>


<?php if (false) 
{ ?>
<?php if ($this->current != 'basket' and $this->have_basket) { ?>
        <tr><td>
        <a href="/user/basket/">�������</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <span>�������</span>
        </td></tr>
<?php } ?>
<?php } ?>

<?php if ($this->code != 'sell') { ?>
        <tr><td>
        
        <a href="/user/sell/<?php
        
if ($this->code == 'tosell')
{
    ?>request/<?php
}

        
        ?>">��� �������</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <a href="/user/sell/" class="current">��� �������</a>
        </td></tr>

<?php } ?>


	
<?php if ($this->code != 'tosell') { ?>
        <tr><td>
        <a href="/public/sell/">���������� ����������</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <a href="/public/sell/" class="current">���������� ����������</a>
        </td></tr>
<?php } ?>



<?php if ($this->code != 'request_info') { ?>
        <tr><td>
        <a href="/user/request/">��� ������</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <a href="/user/request/" class="current">��� ������</a>
        </td></tr>
<?php } ?>

<?php if ($this->code != 'request') { ?>
        <tr><td>
        <a href="/public/request/">���������� ������</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <a href="/public/request/" class="current">���������� ������</a>
        </td></tr>
<?php } ?>


<?php if ($this->code != 'contact') { ?>
        <tr><td>
        <a href="/user/list/">������������</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <a href="/user/list/" class="current">������������</a>
        </td></tr>
<?php } ?>


<?php
if ($this->code != 'message') { ?>
        <tr><td>
        <a href="/user/message/">��� ���������</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <a href="/user/message/" class="current">��� ���������</a>
        </td></tr>
<?php } ?>

<?php
if ($this->user_status > 499) { 
if ($this->code != 'nearby') { ?>
        <tr><td>
        <a href="/user/nearby/">����������</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <a href="/user/nearby/" class="current">����������</a>
        </td></tr>
<?php } } ?>



<?php if (false) { ?>
	
<?php if ($this->code != 'salelist') { ?>
        <tr><td>
        <a href="/user/salelist/">������� ������������</a>
        </td></tr>
<?php } else {?>
        <tr><td>
        <span>������� ������������</span>
        </td></tr>
<?php } ?>

<?php } ?>
        </table>
</div>
<div class="ugol-left-top"></div>
<div class="ugol-left-bottom"></div>
<div class="ugol-right-top"></div>
<div class="ugol-right-bottom"></div>
</div>