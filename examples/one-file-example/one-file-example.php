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
  
  public function customSetup($data)
  {
    $this->myData = $data;
  }
  
  
  public function run(){
    $this->logger->info('Starting Application...');
    $this->anotherLogger->info('Same here...');
    echo "This is my data: ".$this->myData;
    echo " ...done.\n";
  }
}




// Configuration of the DI-Container

$dependencyManager = new \SugarLoaf\DependencyManager();


// Declare LogFile with its classname as a string
$dependencyManager->registerService('LogFile');


// Declare Logger with its class and declare a name
$dependencyManager->registerService('Logger', Logger::Class)
                  ->appendManagedParameter('LogFile')
                  ->appendUnmanagedParameter('My_Prefix');


// Declare another Logger with its class and name
$dependencyManager->registerService('LoggerTwo', Logger::Class)
                  ->appendManagedParameter('LogFile')
                  ->appendUnmanagedParameter('Another_Prefix');
                  
// Declare a Service by classname
$dependencyManager->registerService('MyApplication', 'Application')
                  ->addManagedDependency('Logger', 'Logger')
                  ->addManagedDependency('AnotherLogger', 'LoggerTwo')
                  ->addCallback(function($myInstance){
                    $myInstance->customSetup('Good Morning!');
                  });
                  

$application = $dependencyManager->get('MyApplication');
$application->run();



