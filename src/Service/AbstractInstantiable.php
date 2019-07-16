<?php

namespace SugarLoaf\Service;

abstract class AbstractInstantiable
{
    abstract public function createServiceInstance($cyclicProofFactory);

    abstract public function getServiceName();

    abstract public function isFullyInstantiated();

    abstract public function setFullyInstantiated();
}
