<?php 

namespace SugarLoaf;


class ParameterArray
{
	public function __construct()
	{
		$this->_parameters = array();
	}

	public function appendParameter($parameter)
	{
		$this->_parameters[] = $parameter;
	}
	
	public function getParameters()
	{
		$output = array();
		foreach ($this->_parameters as $parameter)
		{
			$output[] = $parameter->getParameter();
		}
		
		return $output;
	}
}

