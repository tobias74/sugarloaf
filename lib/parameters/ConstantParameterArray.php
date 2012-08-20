<?php 
namespace sugarloaf;

class ConstantParameterArray
{
	public function __construct($parameters)
	{
		$this->parameters = $parameters;
	}
	
	public function getParameters()
	{
		return $this->parameters;
	}
}

