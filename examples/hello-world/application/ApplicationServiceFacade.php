<?php 

class ApplicationServiceFacade
{
	
	public function setDatabase($db)
	{
		$this->db =$db;
	}
	
	public function setProfiler($profiler)
	{
		$this->profiler = $profiler;
	}
	
	public function getTime()
	{
		return "11:14";
	}
	
	public function getDummyData()
	{
		$data = $this->db->getDummyData();
		return $this->encodeData($data);		
	}
	
	public function encodeData($data)
	{
		$this->profiler->start('encodeData');
		$data = strtoupper($data);
		$this->profiler->stop('encodeData');
		
		return $data;
	}
	
}

