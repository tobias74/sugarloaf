<?php

namespace SugarLoaf;

class CyclicProofFactory
{
    const CONSTRUCTOR_RECURSION_ERROR = 'if you see this, you tried to have recursive dependencies with constructor injection';

    public function __construct($context)
    {
        $this->_dependencyManager = $context;

        $this->_cyclicDependencyStack = array();
    }

    protected function findInStack($serviceName)
    {
        foreach ($this->_cyclicDependencyStack as $cyclicHandle) {
            if ($cyclicHandle->serviceName === $serviceName) {
                return $cyclicHandle;
            }
        }
    }

    protected function push($serviceHandle)
    {
        array_push($this->_cyclicDependencyStack, $serviceHandle);
    }

    protected function pop()
    {
        return array_pop($this->_cyclicDependencyStack);
    }

    public function build($implementationName)
    {
        $cyclicHandle = (object) array(
            'serviceName' => $implementationName,
            'instance' => null,
            'constructorRecursionError' => CyclicProofFactory::CONSTRUCTOR_RECURSION_ERROR,
        );
        $this->push($cyclicHandle);

        $serviceHandle = $this->_dependencyManager->getManagedServiceHandle($implementationName);

        $serviceInstance = $serviceHandle->createServiceInstance($this);

        $cyclicHandle->instance = $serviceInstance;
        $cyclicHandle->constructorRecursionError = false;

        if (!$serviceHandle->isFullyInstantiated()) {
            $dependencyList = $serviceHandle->getDependencyList();
            foreach ($dependencyList->getPropertyList() as $dependency) {
                $implementation = $dependency->getInstance($this);
                $setImplementation = 'set'.ucfirst($dependency->getInterfaceName());
                $serviceInstance->$setImplementation($implementation);
            }

            foreach ($dependencyList->getCallbacks() as $callback) {
                $callback($serviceInstance);
            }

            $serviceHandle->setFullyInstantiated();
        }

        $this->pop();

        return $serviceInstance;
    }

    public function get($implementationName)
    {
        $cyclicHandle = $this->findInStack($implementationName);
        if ($cyclicHandle) {
            error_log('NOTICE SUGARLOAF: We have a cyclic dependency with '.$implementationName.' ### STACK: '.print_r($this->_cyclicDependencyStack, true));
            if (CyclicProofFactory::CONSTRUCTOR_RECURSION_ERROR === $cyclicHandle->constructorRecursionError) {
                throw new \ErrorException('Recursion during Constructor-Injection: '.$implementationName);
            }

            return $cyclicHandle->instance;
        } else {
            return $this->build($implementationName);
        }
    }
}
