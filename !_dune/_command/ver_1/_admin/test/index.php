<?php
echo $path = session_save_path();
echo '<br />';
echo ini_get('upload_tmp_dir');
die();