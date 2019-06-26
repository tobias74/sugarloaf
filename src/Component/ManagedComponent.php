<?php
namespace SugarLoaf\Component;

class ManagedComponent extends AbstractComponent
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
