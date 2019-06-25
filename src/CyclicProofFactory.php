<?php
namespace SugarLoaf;

class CyclicProofFactory
{
	public function __construct($context)
	{
		$this->_dependencyManager = $context;
		
		$this->_cyclicRecorder = array();
	
    $this->_cyclicDependencyStack = array();		
	}
	

	protected function push($name)
	{
	  array_push($this->_cyclicDependencyStack,$name);
	}
	
  protected function pop()
  {
    return array_pop($this->_cyclicDependencyStack);
  }
  
	public function build($implementationName)
	{
	  $this->push($implementationName);
	  
    $serviceHandle = $this->_dependencyManager->getManagedServiceHandle($implementationName);
		$dependencyList = $this->_dependencyManager->getDependencyList($implementationName);
    
    $configuredParameterArray = $dependencyList->getParameterArray();
    $configuredParameterArray->setManager($this);
  	$instance = $serviceHandle->instantiate($configuredParameterArray->getParameter());

    if (!$serviceHandle->isFullyInstantiated())
    {
      $this->_cyclicRecorder[$implementationName] = $instance;        

      foreach ($dependencyList->getPropertyList() as $dependency)
      {
        $dependency->setManager($this);

        $implementation = $dependency->getInstance();

        $setImplementation = "set".ucfirst($dependency->getInterfaceName());
        $instance->$setImplementation($implementation);
      }

      foreach ($dependencyList->getCallbacks() as $callback)
      {
      	$callback($instance);
      }
      
      $serviceHandle->setFullyInstantiated();
    }
    
		
		$this->pop();
		return $instance;
	}
	
	public function get($implementationName, $parameters = array())
	{
		if (isset($this->_cyclicRecorder[$implementationName]))
		{
		  if (array_search($implementationName,$this->_cyclicDependencyStack) !== false)
		  {
        error_log('NOTICE SUGARLOAF: We have a cyclic dependency with '.$implementationName.' ### STACK: '.print_r($this->_cyclicDependencyStack, true));  
		  }
			$implementation = $this->_cyclicRecorder[$implementationName];				
		}
		else
		{
			$implementation = $this->build($implementationName, $parameters);
		}
		
		return $implementation;
	}
}

