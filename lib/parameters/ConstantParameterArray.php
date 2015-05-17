<?php 
namespace sugarloaf;

class ConstantParameterArray extends ParameterProvider
{
	public function __construct($parameters)
	{
		$this->parameters = $parameters;
	}
	
	public function getParameter()
	{
		return $this->parameters;
	}
}

