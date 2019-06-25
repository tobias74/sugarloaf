<?php
namespace SugarLoaf;

class CyclicProofFactory
{
	public function __construct($context)
	{
		$this->_dependencyManager = $context;
		
    $this->_cyclicDependencyStack = array();		
	}
	

	protected function findInStack($serviceName)
	{
	  foreach ($this->_cyclicDependencyStack as $cyclicHandle) 
	  {
	  	if ($cyclicHandle->serviceName === $serviceName)
	  	{
	  		return $cyclicHandle;
	  	}
	  }
	}

	protected function push($serviceHandle)
	{
	  array_push($this->_cyclicDependencyStack, $serviceHandle);
	}
	
  protected function pop()
  {
    return array_pop($this->_cyclicDependencyStack);
  }
  
	public function build($implementationName)
	{
		$cyclicHandle = (object) array('serviceName' => $implementationName, 'instance' => null);
	  $this->push($cyclicHandle);

    $serviceHandle = $this->_dependencyManager->getManagedServiceHandle($implementationName);
		$dependencyList = $this->_dependencyManager->getDependencyList($implementationName);
    
    $configuredParameterArray = $dependencyList->getParameterArray();
    $configuredParameterArray->setManager($this);
    
  	$instance = $serviceHandle->instantiate($configuredParameterArray->getParameter());
		$cyclicHandle->instance = $instance;
		
    if (!$serviceHandle->isFullyInstantiated())
    {
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
	
	public function get($implementationName)
	{
		$cyclicHandle = $this->findInStack($implementationName);
		if ($cyclicHandle)
		{
      error_log('NOTICE SUGARLOAF: We have a cyclic dependency with '.$implementationName.' ### STACK: '.print_r($this->_cyclicDependencyStack, true));  
			return $cyclicHandle->instance;				
		}
		else
		{
			return $this->build($implementationName);
		}
	}
}

