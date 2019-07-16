<?php

namespace SugarLoaf\Service;

class FactoryCallback extends AbstractInstantiable
{
    public function __construct($serviceName, $callback)
    {
        $this->_serviceName = $serviceName;
        $this->factoryCallback = $callback;
    }

    public function getServiceName()
    {
        return $this->_serviceName;
    }

    public function createServiceInstance($cyclicProofFactory)
    {
        $callback = $this->factoryCallback;

        return $callback($cyclicProofFactory);
    }

    public function isFullyInstantiated()
    {
        return true;
    }

    public function setFullyInstantiated()
    {
        // nothing
    }
}
