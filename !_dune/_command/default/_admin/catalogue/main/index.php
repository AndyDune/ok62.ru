<?php
/////       ЛИСТ
///////////////////////////////
////     
///     Страница в разделе каталога - главная
///

    $folder_url = Dune_Data_Collector_UrlSingleton::getInstance();
    $currentCommand = $folder_url->getFolder();
	
    echo '<h1>Раздел редактирования инфорамции кталога.</h1>';
    

    
