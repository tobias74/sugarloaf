<?php 
error_reporting(E_ALL);
set_time_limit(3600);
date_default_timezone_set('Europe/Berlin');


spl_autoload_register(function ($class) {

    // project-specific namespace prefix
    $prefix = 'SugarLoaf\\';

    // base directory for the namespace prefix
    $base_dir = __DIR__ . '/../../src/';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});



require_once(dirname(__FILE__).'/application/application.php');

$dependencyManager = \SugarLoaf\DependencyManager::getInstance();


$dependencyManager->registerDependencyManagedService(new \SugarLoaf\Service\ManagedSingleton('ApplicationServiceFacade'))
                  ->addDependency('Database', new \SugarLoaf\Component\ManagedComponent('Database'))
                  ->addDependency('Profiler', new \SugarLoaf\Component\ManagedComponent('Profiler'));
                  
		
$dependencyManager->registerDependencyManagedService(new \SugarLoaf\Service\ManagedSingleton('Profiler'))
                  ->addDependency('ApplicationFacade', new \SugarLoaf\Component\ManagedComponent('ApplicationServiceFacade'));
                  

$dependencyManager->registerDependencyManagedService(new \SugarLoaf\Service\ManagedService('Database'))
                  ->addDependency('Profiler', new \SugarLoaf\Component\ManagedComponent('Profiler'));
                  		

$facade = $dependencyManager->get('ApplicationServiceFacade');
echo $facade->getDummyData();


echo "<br>done.";
