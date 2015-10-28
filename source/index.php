<?php
define('ROOT_DIR', dirname(__FILE__).'/');

include('./core/FactoryManager.php');

$server = FactoryManager::createProduct('web_Server');
$server->initEnvironment();
$server->run();



