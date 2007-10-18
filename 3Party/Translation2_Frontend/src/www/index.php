<?php
set_include_path('../' . PATH_SEPARATOR . get_include_path());

require_once 'k.php';

$application = new Translation2_Frontend_Controller_Root();
$application->dispatch();