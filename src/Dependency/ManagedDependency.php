<?php
namespace SugarLoaf\Dependency;

class ManagedDependency extends AbstractDependency
{
	public function __construct($instanceName)
	{
		$this->_instanceName = $instanceName;
	}
	
	public function getInstance($manager)
	{
		return $manager->get($this->_instanceName);
	}
	
}
