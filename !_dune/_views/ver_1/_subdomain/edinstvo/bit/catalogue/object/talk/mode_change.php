<div id="talk-mode-change">
<ul>
<?php if ($this->talk_mode == 'private') { ?>
<li><a href="?talk_mode=public#talk-mode-change" title="���������, ��������� ��� ��������� ���� ������������� �����."><span><em>�����������</em></span></a></li>
<li class="current"><p><span><em>��������� ������� � ���������</em></span></p></li>

<?php } else {?>
<li class="current"><p><span><em>�����������</em></span></p></li>
<li><a href="?talk_mode=private#talk-mode-change" title=""><span><em>��������� ������� � ���������</em></span></a></li>
<?php }?>
</ul>
</div>