<?php

class Bird
{
  var $habitat;
  var $food;
  var $nesting = "tree";
  var $conservation;
  var $song = "chirp";
  var $flying = "yes";
  public static $instance_count = 0;
  public static $egg_num = 0;

  public static function create()
  {
    static::$instance_count++;
    return new static();
  }

  public function can_fly()
  {
    $this->flying == "yes" ? $flying_string = "can fly" : $flying_string = "is stuck on the ground";
    return  $flying_string;
  }
}

class YellowBelliedFlyCatcher extends Bird
{
  var $name = "yellow-bellied flycatcher";
  var $diet = "mostly insects.";
  var $song = "flat chilk";
  public static $egg_num = "3-4, sometimes 5.";
}

class Kiwi extends Bird
{
  var $name = "kiwi";
  var $diet = "omnivorous";
  var $flying = "no";
}
