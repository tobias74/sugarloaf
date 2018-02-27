<?php

namespace SugarLoaf;

class DependencyList
{
	public function __construct()
	{
		$this->_list = array();
		$this->parameterArray = new Parameter\ParameterArray();
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
	
	


	public function appendManagedParameter($parameter)
	{
		$this->parameterArray->appendParameter(new Parameter\ManagedParameter($parameter));
		return $this;
	}

	public function appendUnmanagedParameter($parameter)
	{
		$this->parameterArray->appendParameter(new Parameter\UnmanagedParameter($parameter));
		return $this;
	}


	public function appendManagedParameterWithName($name, $parameter)
	{
		$this->parameterArray->appendNamedParameter($name, new Parameter\ManagedParameter($parameter));
		return $this;
	}

	public function appendUnmanagedParameterWithName($name, $parameter)
	{
		$this->parameterArray->appendNamedParameter($name, new Parameter\UnmanagedParameter($parameter));
		return $this;
	}




	
	
	
	public function getList()
	{
		return $this->_list;
	}
	
	public function getParameterArray()
	{
		return $this->parameterArray;
	}
	
	
}
