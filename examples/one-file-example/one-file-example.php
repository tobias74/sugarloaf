<?php

error_reporting(E_ALL);
date_default_timezone_set('Europe/Berlin');

spl_autoload_register(function ($class) {
    $prefix = 'SugarLoaf\\';
    $base_dir = __DIR__ . '/../../src/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});




// Class without Dependencies
class LogFile
{
  public function append($msg){
    error_log($msg);
  }
}

// Class that uses Constructor-Injection
class Logger
{
  public function __construct($logFile, $logPrefix){
    $this->logFile = $logFile;
    $this->logPrefix = $logPrefix;
  }
  
  public function error($msg){
    $this->logFile->append('Logging Error: '.$this->logPrefix.': '.$msg);
  }

  public function info($msg){
    $this->logFile->append('Logging Info: '.$this->logPrefix.': '.$msg);
  }
}

//Class that uses Setter-Injection
class Application
{
  public function setLogger($logger){
    $this->logger = $logger;
  }

  public function setAnotherLogger($logger){
    $this->anotherLogger = $logger;
  }
  
  public function run(){
    $this->logger->info('Starting Application...');
    $this->anotherLogger->info('Same here...');
    echo "done.";
  }
}




// Configuration of the DI-Container

$dependencyManager = \SugarLoaf\DependencyManager::getInstance();


// the LogFile-Class does not need have Dependencies
$dependencyManager->registerDependencyManagedService(new \SugarLoaf\Service\ManagedService('LogFile'));


// the Logger-Class takes to arguments in its constructor
$parameter = new \SugarLoaf\Parameter\ParameterArray();
$parameter->appendParameter(new \SugarLoaf\Parameter\ManagedParameter('LogFile'));
$parameter->appendParameter(new \SugarLoaf\Parameter\UnmanagedParameter('My_Prefix'));
$dependencyManager->registerDependencyManagedService(new \SugarLoaf\Service\ManagedSingleton('Logger','Logger',$parameter));

// the Logger-Class takes to arguments in its constructor
$parameter = new \SugarLoaf\Parameter\ParameterArray();
$parameter->appendParameter(new \SugarLoaf\Parameter\ManagedParameter('LogFile'));
$parameter->appendParameter(new \SugarLoaf\Parameter\UnmanagedParameter('Another_Prefix'));
$dependencyManager->registerDependencyManagedService(new \SugarLoaf\Service\ManagedSingleton('LoggerTwo','Logger',$parameter));
                  
    
$dependencyManager->registerDependencyManagedService(new \SugarLoaf\Service\ManagedService('MyApplication','Application'))
                  ->addDependency('Logger', new \SugarLoaf\Component\ManagedDependency('Logger'))
                  ->addDependency('AnotherLogger', new \SugarLoaf\Component\ManagedDependency('LoggerTwo'));
                  

$application = $dependencyManager->get('MyApplication');
$application->run();



