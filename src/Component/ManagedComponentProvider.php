<?php
namespace SugarLoaf\Component;

class ManagedComponentProvider extends AbstractComponent
{
	
	
	public function getInstance()
	{
		return $this;
	}
	
	public function isProvider()
	{
		return true;
	}
	
	public function provide()
	{
		// we are not using the cyclic factory here, we have been injected with the instance of the dependency ma
		$parameters = func_get_args();
		return $this->dependencyManager->get($this->_instanceName, $parameters);

		// do not use the cyclic favtory here, this will be called long after dependency management.
		// return \Sugarloaf\DependencyManager::getInstance()->get($this->_instanceName, $parameters);
	}
}
