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
	
	protected function getProfiler()
	{
		return $this->_dependencyManager->getProfiler();	
	}

  protected function getLogger()
  {
    return $this->_dependencyManager->getLogger();  
  }
  
	
	protected function getStartedTimer($description)
	{
		if ($this->getProfiler() != false)
		{
			$timer = $this->getProfiler()->startTimer($description);
			return $timer;
		}
		else
		{
			return false;
		}
	}
	
	protected function stopTimer($timer)
	{
		if ($timer != false)
		{
			$timer->stop();
		}
	}
	
	protected function push($name)
	{
	  array_push($this->_cyclicDependencyStack,$name);
	}
	
  protected function pop()
  {
    return array_pop($this->_cyclicDependencyStack);
  }
  
	public function build($implementationName, $parameters=array())
	{
	  $this->push($implementationName);
	  
    $serviceHandle = $this->_dependencyManager->getManagedServiceHandle($implementationName);

		$dependencyList = $this->_dependencyManager->getDependencyList($implementationName);
    
    $configuredParameterArray = $dependencyList->getParameterArray();
    
    $configuredParameterArray->setManager($this);
        
    
    
    if ((count($parameters) > 0 ) && (!$configuredParameterArray->isEmpty()))
    {
        throw new \ErrorException('you cannot parameterize this service on the fly. It has already been configured. This is my name: '.$implementationName);
    }
    else if (count($parameters) > 0 ) 
    {
    	$instance = $serviceHandle->instantiate($parameters);
    }
    else if (!$configuredParameterArray->isEmpty())
    {
    	$instance = $serviceHandle->instantiate($configuredParameterArray->getParameter());
    }
    else 
    {
    	$instance = $serviceHandle->instantiate(array());
    }
    
    

    if (!$serviceHandle->isFullyInstantiated())
    {
      $this->_cyclicRecorder[$implementationName] = $instance;        

      
      foreach ($dependencyList->getPropertyList() as $dependency)
      {
  			if ($dependency->isProvider())
  			{
	        $dependency->setManager($this->_dependencyManager);
  			}
  			else 
  			{
	        $dependency->setManager($this);
  			}
        
        $timer2 = $this->getStartedTimer('DM: requesting implementation');
        $implementation = $dependency->getInstance();
        $this->stopTimer($timer2);
                
        $setImplementation = "set".ucfirst($dependency->getInterfaceName());
        $instance->$setImplementation($implementation);
              
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
        // this is a cyclic dependency!
        //error_log('NOTICE SUGARLOAF: We have a cyclic dependency with '.$implementationName.' ### STACK: '.print_r($this->_cyclicDependencyStack, true));  
        if ($this->getLogger() != false)
        {
          $this->getLogger()->debug('Sugarloaf detected a cylic dependency: '.$implementationName.' ### STACK: '.print_r($this->_cyclicDependencyStack, true));
        }
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

