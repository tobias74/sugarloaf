<?php

namespace SugarLoaf;

class DependencyList
{
	public function __construct()
	{
		$this->propertyArray = array();
		$this->parameterArray = new Parameter\ParameterArray();
		$this->callbacks = array();
	}
	
	public function addCallback($callback)
	{
		$this->callbacks[] = $callback;
	}
	
	public function addDependency($interfaceName, $component)
	{
		$component->setInterfaceName($interfaceName);
		array_push($this->propertyArray, $component);
		return $this;
	}
	
	public function addManagedDependency($interfaceName, $serviceName)
	{
		$component = new \SugarLoaf\Component\ManagedComponent($serviceName);
		return $this->addDependency($interfaceName, $component);
	}

	public function addUnmanagedInstance($interfaceName, $instance)
	{
		$component = new \SugarLoaf\Component\UnmanagedInstance($instance);
		return $this->addDependency($interfaceName, $component);
	}
	
	


	public function appendManagedParameter($parameter)
	{
		$this->parameterArray->appendManagedParameter($parameter);
		return $this;
	}

	public function appendUnmanagedParameter($parameter)
	{
		$this->parameterArray->appendUnmanagedParameter($parameter);
		return $this;
	}


	public function appendManagedParameterWithName($name, $parameter)
	{
		$this->parameterArray->appendManagedParameterWithName($name, $parameter);
		return $this;
	}

	public function appendUnmanagedParameterWithName($name, $parameter)
	{
		$this->parameterArray->appendUnmanagedParameterWithName($name, $parameter);
		return $this;
	}

	public function startManagedParameterArray()
	{
		$managedParameterArray = new Parameter\ParameterArray($this);
		$this->parameterArray->appendParameter($managedParameterArray);
		return $managedParameterArray;
	}

	public function startManagedParameterArrayWithName($name)
	{
		$managedParameterArray = new Parameter\ParameterArray($this);
		$this->parameterArray->appendNamedParameter($name, $managedParameterArray);
		return $managedParameterArray;
	}


	
	
	
	public function getPropertyList()
	{
		return $this->propertyArray;
	}
	
	public function getParameterArray()
	{
		return $this->parameterArray;
	}
	
	public function getCallbacks()
	{
		return $this->callbacks;
	}
	
	
}


