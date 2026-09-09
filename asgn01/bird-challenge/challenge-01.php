<?php 

class Bicycle {
  var $brand;
  var $model;
  var $year;
  var $description;
  var $weight_kg;

  function name() {
    return $this->year ." " . $this->brand . " " . $this->model;
  }

  function set_weight_lbs($value) {
    $new_value = $this->weight_kg = floatval($value) / 2.205;
    return $new_value;
  }

  function weight_lbs(){
    $weight_lb = $this->weight_kg * 2.205;
    return $weight_lb;
  }
}

$bike = new Bicycle;
$bike->brand = 'zoloft';
$bike->model = 'mango';
$bike->year = 1984;
$bike->description = 'pingas';
$bike->weight_kg = 59;

echo "Bike name is ". $bike->name() ." <br/>";
echo "Bike weight in lbs is ". $bike->weight_lbs() ." <br/>";

$bike->set_weight_lbs(2);
echo $bike->weight_kg; "<br/>";
echo $bike->weight_lbs();

?>
