<?php 
namespace SugarLoaf\Parameter;

class ManagedParameter extends AbstractParameter
{
	public function __construct($component)
	{
		$this->componentName = $component;
	}
	
	public function getParameter()
	{
		return $this->dependencyManager->get($this->componentName);	
	}
}


