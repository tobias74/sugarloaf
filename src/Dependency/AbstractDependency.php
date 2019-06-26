<?php
namespace SugarLoaf\Dependency;

abstract class AbstractDependency
{
	
	abstract public function getInstance($manager);


	public function setInterfaceName($val)
	{
		// this is the name of the setterMethod, which will be called on the thing later
		$this->interfaceName = $val;
	}

	public function getInterfaceName()
	{
		return $this->interfaceName;
	}


}

