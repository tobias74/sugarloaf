<?php

namespace SugarLoaf\Service;

abstract class AbstractManagedService extends AbstractInstantiable
{
    public function __construct($serviceName, $serviceClassRef = false)
    {
        $this->_serviceName = $serviceName;
        $this->setDependecyList(new \SugarLoaf\DependencyList());

        if (false === $serviceClassRef) {
            $this->_serviceClassRef = $serviceName;
        } else {
            $this->_serviceClassRef = $serviceClassRef;
        }
    }

    abstract protected function instantiate($parameters);

    public function getServiceName()
    {
        return $this->_serviceName;
    }

    public function setDependecyList($dl)
    {
        $this->dependencyList = $dl;
    }

    public function getDependencyList()
    {
        return $this->dependencyList;
    }

    public function createServiceInstance($cyclicProofFactory)
    {
        $parametersInstance = $this->getDependencyList()->getParameterArray()->getInstance($cyclicProofFactory);

        return $this->instantiate($parametersInstance);
    }
}
