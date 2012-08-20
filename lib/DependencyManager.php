<?php

namespace SugarLoaf;

class DependencyManager
{
    static private $instance=false;
    
	protected function __construct()
	{
		if (self::$instance!=false)
		{
			throw new Exception("use of singleton via new. dont do that.");
			die();
		}
		
		$this->_dependenciesForService = array();
		$this->_serviceList = array();
		
    }

	public static function getInstance()
	{
		if (!self::$instance)
		{
			self::$instance = new static();
		}
		return self::$instance;
	}
	
	
	public function get($name, $parameters = array())
	{
		$factory = new CyclicProofFactory($this);
		$instance = $factory->build($name, $parameters);
		return $instance;
	}
	
	public function instantiateManagedService($name, $parameters=array())
	{
		$handle = $this->getManagedServiceHandler($name);
		return $handle->getImplementation($parameters);
	}
	
	public function getDependencyList($name)
	{
		return $this->_dependenciesForService[$name];
	}
	
	public function getManagedServiceHandler($name)
	{
		if (!isset($this->_serviceList[$name]))
		{
			throw new \ErrorException('This Service has not been declared in the DI: '.$name);
		}
		
		return $this->_serviceList[$name];
	}
	
	protected function addDependencyList($managedService,$dependencyList)
	{
		$this->_dependenciesForService[$managedService->getServiceName()] = $dependencyList;
		$this->_serviceList[$managedService->getServiceName()] = $managedService;
	}
	
	public function registerDependencyManagedService($managedService)
	{
		$dl = new DependencyList();
		$this->addDependencyList($managedService, $dl);
		return $dl;
	}
	
}
