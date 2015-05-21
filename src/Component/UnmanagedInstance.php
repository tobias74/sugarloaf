<?php
namespace SugarLoaf\Component;

class UnmanagedInstance extends AbstractComponent
{
	public function __construct($instance)
	{
		$this->instance = $instance;
	}
	
	public function getImplementation()
	{
		return $this->instance;
	}
	
}

/*
class UnmanagedValue extends UnmanagedInstance
{
  
}
*/