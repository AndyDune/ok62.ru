<div id="talk-mode-change">
<ul>
<?php if ($this->talk_mode == 'private') { ?>
<li><a href="<?php echo $this->url_object->get();?>?talk_mode=public" title="���������, ��������� ��� ��������� ���� ������������� �����.">��������� �������</a></li>
<li><span>��������� �������</span></li>

<?php } else {?>
<li><span>��������� �������</span></li>
<li><a href="<?php echo $this->url_object->get();?>?talk_mode=private" title="">��������� �������</a></li>
<?php }?>
</ul>
</div>