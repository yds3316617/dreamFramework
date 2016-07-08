<?php  
use Core\FactoryManager;
define('ROOT_DIR', realpath(dirname(__FILE__).'/../').'/');
define('BASE_URL', 'http://localhost/dreamFrameworkGithub/source/public');
//print_r(ROOT_DIR);exit;
include('../Core/FactoryManager.php');

$server = FactoryManager::singleCreateProduct('Server@Web');
$server->initEnvironment();
$server->run();
