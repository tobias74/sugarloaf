<?php 

namespace SugarLoaf;


class ParameterArray extends AbstractParameter
{
	public function __construct()
	{
		$this->_parameters = array();
	}

	public function appendParameter($parameter)
	{
		$this->_parameters[] = $parameter;
	}

  public function appendNamedParameter($name, $parameter)
  {
    $this->_parameters[$name] = $parameter;
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






