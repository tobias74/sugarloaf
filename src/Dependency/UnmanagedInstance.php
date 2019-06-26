<?php
namespace SugarLoaf\Dependency;

class UnmanagedInstance extends AbstractDependency
{
	public function __construct($instance)
	{
		$this->instance = $instance;
	}
	
	public function getInstance($manager)
	{
		return $this->instance;
	}
	
}

