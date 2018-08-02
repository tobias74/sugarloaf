<?php 
namespace SugarLoaf\Parameter;


class ParameterArray extends AbstractParameter
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
		$this->appendParameter(new ManagedParameter($parameter));
		return $this;
	}

	public function appendUnmanagedParameter($parameter)
	{
		$this->appendParameter(new UnmanagedParameter($parameter));
		return $this;
	}

	public function appendManagedParameterWithName($name, $parameter)
	{
		$this->appendNamedParameter($name, new ManagedParameter($parameter));
		return $this;
	}

	public function appendUnmanagedParameterWithName($name, $parameter)
	{
		$this->appendNamedParameter($name, new UnmanagedParameter($parameter));
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




	
	public function getParameter()
	{
		$output = array();
		foreach ($this->_parameters as $index => $parameter)
		{
		  $parameter->setManager($this->dependencyManager);
			$output[$index] = $parameter->getParameter();
		}
		
		return $output;
	}
}






