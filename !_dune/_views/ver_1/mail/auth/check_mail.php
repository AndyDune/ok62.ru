<div id="letter-body">
<h1>�������� ����������� ���������� ������ ��. �����</h1>
<p>���� ��������� ������� ����������������� �� ����� <a href="http://<?php echo $this->domain?>"><?php echo $this->domain?></a></p>
<p>���� �� �������� ����������, ����������, �������� �� ������: <a href="http://<?php echo $this->domain?>/user/checkmail/?mail=<?php echo $this->mail?>&code=<?php echo $this->code?>"><?php echo $this->domain?></a></p>
<p>���� �������� �� �������� ����� <a href="http://<?php echo $this->domain?>/user/checkmail/"><?php echo $this->domain?></a> � �������:</p>
<ul>
<li style="margin: 2px;"><span style="width:100px">����� e-mail: </span><span style="padding 2px; background-color:#FFFFCC;"><?php echo $this->mail;?></span></li>
<li style="margin: 2px;"><span style="width:100px">���: </span><span style="padding 2px; background-color:#FFFFCC;"><?php echo $this->code;?></span></li>
</ul>
</div>