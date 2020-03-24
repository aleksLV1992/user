<?php
include_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoloader.php';


use vendor\Site as Site;
Site::GetInstance();
Site::Loading();

?>
