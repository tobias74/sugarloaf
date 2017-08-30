<?php

namespace SugarLoaf;

class DependencyList
{
	public function __construct()
	{
		$this->_list = array();
	}
	
	public function addDependency($interfaceName, $component)
	{
		$component->setInterfaceName($interfaceName);
		array_push($this->_list, $component);
		return $this;
	}
	
	public function addManagedDependency($interfaceName, $serviceName)
	{
		$component = new \SugarLoaf\Component\ManagedComponent($serviceName);
		return $this->addDependency($interfaceName, $component);
	}

	public function addManagedProvider($interfaceName, $serviceName)
	{
		$component = new \SugarLoaf\Component\ManagedComponentProvider($serviceName);
		return $this->addDependency($interfaceName, $component);
	}
	
	public function addUnmanagedInstance($interfaceName, $instance)
	{
		$component = new \SugarLoaf\Component\UnmanagedInstance($instance);
		return $this->addDependency($interfaceName, $component);
	}
	
	public function getList()
	{
		return $this->_list;
	}
	
	
}
