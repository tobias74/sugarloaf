<?php

namespace SugarLoaf;

class DependencyManager
{
    static private $instance=false;
    protected $_serviceList;
    protected $_dependenciesForService;

	public function __construct()
	{
		$this->_dependenciesForService = array();
		$this->_serviceList = array();
    }


	public function get($name, $parameters = array())
	{
		$factory = new CyclicProofFactory($this);
		$instance = $factory->build($name, $parameters);
		return $instance;
	}
	
	public function getDependencyList($name)
	{
		return $this->_dependenciesForService[$name];
	}
	
	public function getManagedServiceHandle($name)
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
	
	public function registerService($serviceName, $serviceClassRef=false)
	{
		$service = new \SugarLoaf\Service\ManagedService($serviceName, $serviceClassRef);
		return $this->registerDependencyManagedService($service);
	}

	public function registerSingleton($serviceName, $serviceClassRef=false)
	{
		$singleton = new \SugarLoaf\Service\ManagedSingleton($serviceName, $serviceClassRef);
		return $this->registerDependencyManagedService($singleton);
	}
	
}
