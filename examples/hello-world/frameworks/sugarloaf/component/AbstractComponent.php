<?php
namespace SugarLoaf;

abstract class AbstractComponent
{
	public function __construct($instanceName, $parameterProvider=false)
	{
		$this->_instanceName = $instanceName;
		$this->parameterProvider = $parameterProvider;
	}
	
	
	public function setManager($manager)
	{
		$this->dependencyManager = $manager;
	}
	
	public function getParameters()
	{
		if ($this->parameterProvider!==false)
		{
			return $this->parameterProvider->getParameters();
		}
		else
		{
			return array();			
		}
	}
	
}

