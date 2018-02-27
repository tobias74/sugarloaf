<?php
namespace SugarLoaf\Component;

class ManagedComponent extends AbstractComponent
{
	
	public function getInstance()
	{
		return $this->dependencyManager->get($this->_instanceName);
	}
	
}
