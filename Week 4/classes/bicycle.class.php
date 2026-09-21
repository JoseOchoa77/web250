<?php

class Bicycle
{

  public $brand;
  public $model;
  public $year;
  public $description = 'Used bicycle';
  protected $weight_kg = 0.0;
  protected static $wheels = 2;
  public static $instance_count = 0;
  public const CATEGORY = ["Road", "Mountain", "Hybrid", "Cruiser", "City", "BMX"];
  public $category;
  
  public static function create()
  {
    static::$instance_count++;
    $name = new Bicycle;
    return $name;
  }

  public function name()
  {
    return $this->brand . " " . $this->model . " (" . $this->year . ")";
  }

  public function storeCategory($int) {
    $this->category = $int;
  }


  public function category(){
    return "The category for this is ". self::CATEGORY[$this->category] ."<br/>";
  }

  public static function wheel_details()
  {
    $wheel_string = static::$wheels == 1 ? "1 wheel" : "". static::$wheels ." wheels";
    return "It has " . $wheel_string . ".";
  }

  public function weight_kg()
  {
    return $this->weight_kg . ' kg';
  }

  public function set_weight_kg($value)
  {
    $this->weight_kg = floatval($value);
  }

  public function weight_lbs()
  {
    $weight_lbs = floatval($this->weight_kg) * 2.2046226218;
    return $weight_lbs . ' lbs';
  }

  public function set_weight_lbs($value)
  {
    $this->weight_kg = floatval($value) / 2.2046226218;
  }
}
