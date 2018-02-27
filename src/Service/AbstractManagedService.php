<?php
namespace SugarLoaf\Service;

class AbstractManagedService
{
  public function __construct($serviceName, $serviceClassRef=false)
  {
    $this->_serviceName = $serviceName;
    
    if ($serviceClassRef === false)
    {
      $this->_serviceClassRef = $serviceName;
    }
    else
    {
      $this->_serviceClassRef = $serviceClassRef;
    }
    
  }
  
  public function getServiceName()
  {
    return $this->_serviceName;
  }
  
}
