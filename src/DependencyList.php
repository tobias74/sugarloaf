<?php

namespace SugarLoaf;

class DependencyList
{
    public function __construct()
    {
        $this->propertyArray = array();
        $this->parameterArray = new ParameterArray();
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

    public function addManagedDependency($interfaceName, $serviceName = false)
    {
        if (false === $serviceName) {
            $serviceName = $interfaceName;
        }
        $component = new \SugarLoaf\Dependency\ManagedDependency($serviceName);

        return $this->addDependency($interfaceName, $component);
    }

    public function addUnmanagedInstance($interfaceName, $instance)
    {
        $component = new \SugarLoaf\Dependency\UnmanagedInstance($instance);

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
