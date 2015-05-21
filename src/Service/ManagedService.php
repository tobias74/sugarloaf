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
	
	
	public function getImplementation($parameters=array(),$di)
	{
    $reflectionObject = new \ReflectionClass($this->_serviceClassRef);

    if (count($parameters) > 0)
    {
      if ($this->_parameters === false)
      {
        $instance = $reflectionObject->newInstanceArgs($parameters);
      }
      else 
      {
        error_log(print_r($parameters, true));
        throw new \ErrorException('you cannot parameterize this service on the fly. It has already been configured. This is my name: '.$this->getServiceName());
      }
    }
    else 
    {
      if ($this->_parameters != false)
      {
        $this->_parameters->setManager($di);
        $instance = $reflectionObject->newInstanceArgs($this->_parameters->getParameter());
      }
      else 
      {
        $instance = $reflectionObject->newInstanceArgs(array());
      }
    }
    
		return $instance;
	}
	
}


