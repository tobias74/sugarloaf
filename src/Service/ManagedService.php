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
	
	
	public function getImplementation($parameters=array(), $di, $configuredParameterArray)
	{
    $reflectionObject = new \ReflectionClass($this->_serviceClassRef);

    if (count($parameters) > 0)
    {
      if ($configuredParameterArray->isEmpty())
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
      if (!$configuredParameterArray->isEmpty())
      {
        $configuredParameterArray->setManager($di);
        $instance = $reflectionObject->newInstanceArgs($configuredParameterArray->getParameter());
      }
      else 
      {
        $instance = $reflectionObject->newInstanceArgs(array());
      }
    }
    
		return $instance;
	}
	
}


