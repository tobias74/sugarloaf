<?php 
namespace SugarLoaf;


class ParameterArray
{
	public function __construct($dslContext=false)
	{
		$this->dslContext = $dslContext;
		$this->_parameters = array();
	}
	
	public function finishParameterArray()
	{
		return $this->dslContext;
	}


	public function appendManagedParameter($parameter)
	{
		$this->appendParameter(new \SugarLoaf\Dependency\ManagedDependency($parameter));
		return $this;
	}

	public function appendUnmanagedParameter($parameter)
	{
		$this->appendParameter(new \SugarLoaf\Dependency\UnmanagedInstance($parameter));
		return $this;
	}

	public function appendManagedParameterWithName($name, $parameter)
	{
		$this->appendNamedParameter($name, new \SugarLoaf\Dependency\ManagedDependency($parameter));
		return $this;
	}

	public function appendUnmanagedParameterWithName($name, $parameter)
	{
		$this->appendNamedParameter($name, new \SugarLoaf\Dependency\UnmanagedInstance($parameter));
		return $this;
	}




	public function appendParameter($parameter)
	{
		$this->_parameters[] = $parameter;
		return $this;
	}


	public function appendNamedParameter($name, $parameter)
	{
		$this->_parameters[$name] = $parameter;
		return $this;
	}


	public function isEmpty()
	{
		return (count($this->_parameters) === 0);
	}




	
	public function getParameter($manager)
	{
		$output = array();
		foreach ($this->_parameters as $index => $parameter)
		{
			$output[$index] = $parameter->getInstance($manager);
		}
		
		return $output;
	}
}






