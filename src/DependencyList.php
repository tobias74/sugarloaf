<?php

namespace SugarLoaf;

class DependencyList
{
	public function __construct()
	{
		$this->propertyArray = array();
		$this->parameterArray = new Parameter\ParameterArray();
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
	
	
}





/*
    $depList = $dm->registerDependencyManagedService(new \SugarLoaf\Service\ManagedService('Tobias3','Tobias3'));

    $nestedParameterArray = new \SugarLoaf\Parameter\ParameterArray();
    $nestedParameterArray->appendParameter(new \SugarLoaf\Parameter\ManagedParameter('Tobias3'));
    $depList = $dm->registerDependencyManagedService(new \SugarLoaf\Service\ManagedSingleton('Tobias2','Tobias2',$nestedParameterArray));

    $outerArray = new \SugarLoaf\Parameter\ParameterArray();
    $nestedParameterArray = new \SugarLoaf\Parameter\ParameterArray();
    $nestedParameterArray->appendNamedParameter('tobias2',new \SugarLoaf\Parameter\ManagedParameter('Tobias2'));
    $outerArray->appendParameter($nestedParameterArray);
    $depList = $dm->registerDependencyManagedService(new \SugarLoaf\Service\ManagedService('Tobias','Tobias',$outerArray));


    $depList = $dm->registerDependencyManagedService(new \SugarLoaf\Service\ManagedService('Somebody','Somebody'));
      $depList->addDependency('Tobias', new \SugarLoaf\Component\ManagedComponent('Tobias'));

*/