<?php 

namespace SugarLoaf;

class ManagedParameter
{
	public function __construct($component)
	{
		$this->componentName = $component;
	}
	
	public function getParameter()
	{
		return DependencyManager::getInstance()->get($this->componentName, array());	
	}
}


