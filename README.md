sugarloaf
=========

PHP Dependency Injection Framework 

SugarLoaf is a (very) lightweight DI-Container that supports Constructor-Injection as well as Setter-Injection. In case of Setter-Injection, it is also possible (though frowned uppon?) to configure cyclic dependencies.

The following example consists of the Classes "LogFile", "Logger" and "Application". The Logger uses a LogFile which has to be injected in the constructor, while the Application depends on two instances of said logger, injected by two setter-methods.



```php

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





```

Using Service-Providers
-----------------------

In case a service can be preconfigured to use different dependencies, but still needs to be injected with another instance only available at runtime, the class "ManagedDependencyProvider" implements a wrapper that can be called by its "provide"-Method. See examples in the git-repo for further information.
