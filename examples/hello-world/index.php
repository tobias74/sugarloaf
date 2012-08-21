<?php 
error_reporting(E_ALL);
set_time_limit(3600);


function exception_error_handler($errno, $errstr, $errfile, $errline ) 
{
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}
set_error_handler("exception_error_handler");

date_default_timezone_set('Europe/Berlin');

require_once(dirname(__FILE__).'/frameworks/sugarloaf/sugarloaf.php');
require_once(dirname(__FILE__).'/application/application.php');


$dependencyManager = \SugarLoaf\DependencyManager::getInstance();


$dependencyManager->registerDependencyManagedService(new \SugarLoaf\ManagedSingleton('ApplicationServiceFacade'))
                  ->addDependency('Database', new \SugarLoaf\ManagedComponent('Database'))
                  ->addDependency('Profiler', new \SugarLoaf\ManagedComponent('Profiler'));
                  
		
$dependencyManager->registerDependencyManagedService(new \SugarLoaf\ManagedSingleton('Profiler'))
                  ->addDependency('ApplicationFacade', new \SugarLoaf\ManagedComponent('ApplicationServiceFacade'));
                  

$dependencyManager->registerDependencyManagedService(new \SugarLoaf\ManagedService('Database'))
                  ->addDependency('Profiler', new \SugarLoaf\ManagedComponent('Profiler'));
                  		

$facade = $dependencyManager->get('ApplicationServiceFacade');
echo $facade->getDummyData();


echo "<br>done.";
