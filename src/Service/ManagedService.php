<?php 
namespace SugarLoaf\Service;

class ManagedService extends AbstractManagedService
{
	
	public function isFullyInstantiated()
	{
	  return false;
	}
	
	public function setFullyInstantiated()
	{
	  // nothing
	}
	
	
	public function instantiate($parameters=array())
	{
    $reflectionObject = new \ReflectionClass($this->_serviceClassRef);
    $instance = $reflectionObject->newInstanceArgs($parameters);
		return $instance;
	}
	
}


