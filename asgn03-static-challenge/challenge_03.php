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

$trek = new Bicycle;
$trek->brand = 'Trek';
$trek->model = 'Emonda';
$trek->year = '2017';

$uni = new Unicycle;

echo "Bicycle: " . $trek->wheel_details() . "<br />";
echo "Unicycle: " . $uni->wheel_details() . "<br />";
echo "<hr />";

echo "Set weight using kg<br />";
$trek->set_weight_kg(1);
echo $trek->weight_kg() . "<br />";
echo $trek->weight_lbs() . "<br />";
echo "<hr />";

echo "Set weight using lbs<br />";
$trek->set_weight_lbs(2);
echo $trek->weight_kg() . "<br />";
echo $trek->weight_lbs() . "<br />";
echo "<hr />";

// Will this work?
echo "Set weight for Unicycle<br />";
$uni->set_weight_kg(1);
echo $uni->weight_kg() . "<br />";
echo $uni->weight_lbs() . "<br />";

echo $uni->bug_test() . "<br />";

$newBike = Bicycle::create();
$newBike->brand = 'Trek';
$newBike->model = 'Emonda';
$newBike->year = '2017';
$newBike->storeCategory(1);

echo $newBike->name();
echo get_class($newBike) . '<br/>';
echo $newBike->category();
echo $newBike->wheel_details() . '<br/>';

echo '<hr/>';

$newUni = Unicycle::create();
$newUni->brand = 'Test';
$newUni->model = 'Tester';
$newUni->year = '2018';
$newUni->storeCategory(4);

echo $newUni->name();
echo get_class($newUni) . '<br/>';
echo $newUni->category();
echo $newUni->wheel_details();



