<?php

namespace SugarLoaf;

class DependencyManager
{
    protected $_serviceList;

    public function __construct()
    {
        $this->_serviceList = array();
    }

    public function get($name)
    {
        $factory = new CyclicProofFactory($this);
        $instance = $factory->build($name);

        return $instance;
    }

    public function getManagedServiceHandle($name)
    {
        if (!isset($this->_serviceList[$name])) {
            throw new \ErrorException('This Service has not been declared in the DI: '.$name);
        }

        return $this->_serviceList[$name];
    }

    public function registerDependencyManagedService($managedService)
    {
        $this->_serviceList[$managedService->getServiceName()] = $managedService;
    }

    public function registerService($serviceName, $serviceClassRef = false)
    {
        $service = new \SugarLoaf\Service\ManagedService($serviceName, $serviceClassRef);
        $this->registerDependencyManagedService($service);

        return $service->getDependencyList();
    }

    public function registerSingleton($serviceName, $serviceClassRef = false)
    {
        $singleton = new \SugarLoaf\Service\ManagedSingleton($serviceName, $serviceClassRef);
        $this->registerDependencyManagedService($singleton);

        return $singleton->getDependencyList();
    }

    public function registerFactoryCallback($serviceName, $callback)
    {
        $factoryCallback = new \SugarLoaf\Service\FactoryCallback($serviceName, $callback);
        $this->registerDependencyManagedService($factoryCallback);
    }
}
