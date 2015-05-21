<?php 
namespace SugarLoaf\Parameter;

abstract class AbstractParameter
{
  public function setManager($manager)
  {
    $this->dependencyManager = $manager;
  }
  
  
}
