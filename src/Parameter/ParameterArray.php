<?php 
namespace SugarLoaf\Parameter;


class ParameterArray extends AbstractParameter
{
	public function __construct()
	{
		$this->_parameters = array();
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






