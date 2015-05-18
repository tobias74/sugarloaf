<?php 

namespace SugarLoaf;

abstract class AbstractParameter
{
  public function setManager($manager)
  {
    $this->dependencyManager = $manager;
  }
  
  
}
