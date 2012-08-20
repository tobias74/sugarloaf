<?php

namespace SugarLoaf;

class CyclicProofFactory
{
	public function __construct($context)
	{
		$this->_context = $context;
		
		$this->_cyclicRecorder = array();
		
	}
	
	public function build($implementationName, $parameters=array())
	{
		$instance = $this->_context->instantiateManagedService($implementationName, $parameters);
		$this->_cyclicRecorder[$implementationName] = $instance;				
		
		
		foreach ($this->_context->getDependencyList($implementationName)->getList() as $dependency)
		{

			$dependency->setManager($this);
			
			//$timer = $this->get('PhpProfiler')->startTimer('DM: requesting implementation for '.$implementationName);
			$timer = $this->get('PhpProfiler')->startTimer('DM: requesting implementation');
			$implementation = $dependency->getImplementation($parameters);
			$timer->stop();
			
			$setImplementation = "set".ucfirst($dependency->getInterfaceName());
			$timer = $this->get('PhpProfiler')->startTimer('DM: setting implementation');
			$instance->$setImplementation($implementation);
			$timer->stop();
			
		}
		
		
		return $instance;
	}
	
	public function get($implementationName, $parameters = array())
	{
		if (isset($this->_cyclicRecorder[$implementationName]))
		{
			// cyclic dependency
			$implementation = $this->_cyclicRecorder[$implementationName];				
		}
		else
		{
			$implementation = $this->build($implementationName, $parameters);
		}
		
		return $implementation;
	}
}

