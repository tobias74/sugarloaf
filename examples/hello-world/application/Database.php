<?php 

class Database
{
	
	public function setProfiler($profiler)
	{
		$this->profiler = $profiler;
	}
	
	
	public function getDummyData()
	{
		$this->profiler->start('dummyData');
		//...getting Data
		
		$this->profiler->stop('dummyData');
		
		return 'dummyData';
		
		
	}
	
}

