<?php 
namespace SugarLoaf\Service;

class ManagedSingleton extends AbstractManagedService
{
	protected $_instance = false;
	protected $_isFullyInstantiated = false;
	
	
	public function isFullyInstantiated()
	{
		return $this->_isFullyInstantiated;
	}
		
		
	public function setFullyInstantiated()
	{
	 $this->_isFullyInstantiated = true;  
	}	
	
	
	
	public function getImplementation($parameters=array(), $di, $configuredParameterArray)
	{
		if (count($parameters)>0)
		{
			throw new \ErrorException('you cannot parameterize singletons on the fly. they start with what they stat. This is my name: '.$this->getServiceName());
		}

    	$reflectionObject = new \ReflectionClass($this->_serviceClassRef);		
		
		if ($this->_instance === false)
		{
		    if (!$configuredParameterArray->isEmpty())
        {
            $configuredParameterArray->setManager($di);
            $this->_instance = $reflectionObject->newInstanceArgs($configuredParameterArray->getParameter());
        }
        else 
        {
            $this->_instance = $reflectionObject->newInstanceArgs(array());
        }
        
            
		}
		
		return $this->_instance; 
	}
	
}


