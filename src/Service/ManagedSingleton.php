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
	
	
	
	public function getImplementation($parameters=array(),$di)
	{
		if (count($parameters)>0)
		{
			throw new \ErrorException('you cannot parameterize singletons on the fly. they start with what they stat. This is my name: '.$this->getServiceName());
		}

    $reflectionObject = new \ReflectionClass($this->_serviceClassRef);		
		
		if ($this->_instance === false)
		{
		    if ($this->_parameters != false)
        {
            $this->_parameters->setManager($di);
            $this->_instance = $reflectionObject->newInstanceArgs($this->_parameters->getParameter());
        }
        else 
        {
            $this->_instance = $reflectionObject->newInstanceArgs(array());
        }
        
            
		}
		
		return $this->_instance; 
	}
	
}


