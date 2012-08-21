<?php 
namespace sugarloaf;

class ManagedSingleton extends ManagedService
{
	protected $_instance = false;
	
	public function __construct($serviceName, $serviceClassRef=false, $parameters=false)
	{
		parent::__construct($serviceName, $serviceClassRef);
		$this->_parameters = $parameters;
	}
	
	public function getImplementation($parameters=array())
	{
		if (count($parameters)>0)
		{
			throw new ErrorException('you cannot parameterize singletons on the fly. they start with what they stat.');
		}
		
		if ($this->_instance === false)
		{
		    if ($this->_parameters != false)
            {
                $this->_instance = parent::getImplementation($this->_parameters->getParameters());
            }
            else 
            {
                $this->_instance = parent::getImplementation();
            }
		}
		
		return $this->_instance; 
	}
	
}


