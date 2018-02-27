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
	
	
	
	public function instantiate($parameters=array())
	{
    	$reflectionObject = new \ReflectionClass($this->_serviceClassRef);		
		
		if ($this->_instance === false)
		{
            $this->_instance = $reflectionObject->newInstanceArgs($parameters);
			return $this->_instance; 
		}
		else 
		{
			if (count($parameters)>0)
			{
				throw new \ErrorException('you cannot parameterize singletons on the fly. they start with what they stat. This is my name: '.$this->getServiceName());
			}
			else 
			{
				return $this->_instance; 
			}
		}

	}
	
}


