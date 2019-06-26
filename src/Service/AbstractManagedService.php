<?php
namespace SugarLoaf\Service;

abstract class AbstractManagedService
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
  
  abstract public function instantiate($parameters);
  
  public function getServiceName()
  {
    return $this->_serviceName;
  }
  
}
