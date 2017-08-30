<?php
namespace SugarLoaf\Component;

abstract class AbstractComponent
{
	public function __construct($instanceName)
	{
		$this->_instanceName = $instanceName;
	}
	
	abstract public function getImplementation();
	

	public function setInterfaceName($val)
	{
		// this is the name of the setterMethod, which will be called on the thing later
		$this->interfaceName = $val;
	}

	public function getInterfaceName()
	{
		return $this->interfaceName;
	}

	public function getImplementationName()
	{
	  return 'ImpName: '.$this->_instanceName;
	}
		
	public function setManager($manager)
	{
		$this->dependencyManager = $manager;
	}
	
	protected function getManager()
	{
	  return $this->dependencyManager;
	}
	
	public function isProvider()
	{
		return false;
	}
	
	
}

