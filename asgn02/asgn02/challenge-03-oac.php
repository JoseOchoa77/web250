<?php

class Instrument
{

  private $brand_name;
  private $year;
  private $model;

  public function set_info($year, $brand_name, $model) {
    $this->brand_name = $brand_name;
    $this->year = $year;
    $this->model = $model;
  }

  public function isStringed($boolean)
  {
    if ($boolean == true) {
      return "This instrument is stringed.</br>";
    } else {
      return "This instrument isn't stringed.</br>";
    }
  }

  public function get_info()
  {
    return "This instrument is the " . $this->year . ", " . $this->brand_name . ", " . $this->model . ".</br>";
  }
}

class Guitar extends Instrument
{
  private int $numStrings;

  public function set_numStrings($value) {
    $this->numStrings = $value;
  }

  public function Message()
  {
    return "This instrument has " . $this->numStrings . " strings. </br>";
  }
}

class Trombone extends Instrument
{
  private $range;

  public function set_range($value) {
    $this->range = $value;
  }

  public function Message()
  {
    return "This instrument has a  " . $this->range . " range.";
  }
}


$fender = new Guitar();
$fender->set_info("1984", "Fender", "Stratocaster");
$fender->set_numStrings(6);
echo $fender->get_info();
echo $fender->isStringed(true);
echo $fender->Message();

echo "</br>";

$king = new Trombone();
$king->set_info("1968", "King", "3B Concert");
$king->set_range("tenor");
echo $king->get_info();
echo $king->isStringed(false);
echo $king->Message();
