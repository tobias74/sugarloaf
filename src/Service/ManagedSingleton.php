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
	
	
	
	public function instantiate($parameters)
	{
		if ($this->_instance === false)
		{
	    	$reflectionObject = new \ReflectionClass($this->_serviceClassRef);		
            $this->_instance = $reflectionObject->newInstanceArgs($parameters);
			return $this->_instance; 
		}
		return $this->_instance; 
	}
	
}


