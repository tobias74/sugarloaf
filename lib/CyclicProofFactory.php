<?php

namespace SugarLoaf;

class CyclicProofFactory
{
	public function __construct($context)
	{
		$this->_context = $context;
		
		$this->_cyclicRecorder = array();
		
	}
	
	protected function getProfilerName()
	{
		return $this->_context->getProfilerName();	
	}
	
	protected function getProfiler()
	{
		if ($this->getProfilerName() != "")
		{
			return $this->get($this->getProfilerName());	
		}
		else 
		{
			return false;	
		}
	}
	
	protected function getStartedTimer($description)
	{
		if ($this->getProfiler() != false)
		{
			$timer = $this->getProfiler()->startTimer($description);
			return $timer;
		}
		else
		{
			return false;
		}
	}
	
	protected function stopTimer($timer)
	{
		if ($timer != false)
		{
			$timer->stop();
		}
	}
	
	
	public function build($implementationName, $parameters=array())
	{
		$instance = $this->_context->instantiateManagedService($implementationName, $parameters);
		$this->_cyclicRecorder[$implementationName] = $instance;				
		
		
		foreach ($this->_context->getDependencyList($implementationName)->getList() as $dependency)
		{

			$dependency->setManager($this);
			
			$timer = $this->getStartedTimer('DM: requesting implementation');
			$implementation = $dependency->getImplementation($parameters);
			$this->stopTimer($timer);
			
			$setImplementation = "set".ucfirst($dependency->getInterfaceName());
			$timer = $this->getStartedTimer('DM: setting implementation');
			$instance->$setImplementation($implementation);
			$this->stopTimer($timer);
						
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

