<?php  
use Core\FactoryManager;
define('ROOT_DIR', realpath(dirname(__FILE__).'/../').'/');
//define('BASE_URL', 'http://192.168.1.169/dreamFrameworkGithub/source/public');
define('BASE_URL', 'http://localhost/dreamFrameworkGithub/source/public');
//print_r(ROOT_DIR);exit;
include('../Core/FactoryManager.php');
include('../Core/DatabaseManager.php');
include('../Core/Api.php');


$server = FactoryManager::singleCreateProduct('Server@Web');
//$server = FactoryManager::singleCreateProduct('KVStore@Core');
$server->initEnvironment();
$server->run();
