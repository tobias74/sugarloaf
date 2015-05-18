<?php
namespace SugarLoaf;

abstract class AbstractComponent
{
	public function __construct($instanceName)
	{
		$this->_instanceName = $instanceName;
	}
	
	abstract public function getImplementation();
	

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
	
	
}

