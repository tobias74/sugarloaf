<?php 

namespace SugarLoaf;

class UnmanagedParameter extends AbstractParameter
{
	public function __construct($parameter)
	{
		$this->parameter = $parameter;
	}
	
	public function getParameter()
	{
		return $this->parameter;
	}
}
