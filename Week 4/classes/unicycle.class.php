<?php

class Unicycle extends Bicycle
{
  // visibility must match property being overridden
  protected static $wheels = 1;

  public static function create()
  {
    static::$instance_count++;
    $name = new Unicycle;
    return $name;
  }

  public function bug_test()
  {
    return $this->weight_kg;
  }
}
