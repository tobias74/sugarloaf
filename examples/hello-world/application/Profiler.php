<?php 

class Profiler
{

	public function setApplicationFacade($facade)
	{
		$this->facade=$facade;
	}
	
	public function start($key)
	{
		$this->facade->getTime();
		//....
	}

	public function stop($key)
	{
		//...
	}
}

