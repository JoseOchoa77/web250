<?php

class Instrument
{

  var $brand_name;
  var $year;
  var $model;

  function song_catalog($song)
  {
    return "Songs that can be played on this instrument are " . $song . ".";
  }

  function isStringed($boolean)
  {
    if ($boolean == true) {
      return "This instrument is stringed.</br>";
    } else {
      return "This instrument isn't stringed.</br>";
    }
  }

  function info()
  {
    return "This instrument is the " . $this->year . ", " . $this->brand_name . ", " . $this->model . ".</br>";
  }
}

class Guitar extends Instrument
{
  public int $numStrings;

  function Message()
  {
    return "This instrument has " . $this->numStrings . " strings. </br>";
  }
}

class Trombone extends Instrument
{
  var $range;

  function Message()
  {
    return "This instrument has a  " . $this->range . " range.";
  }
}


$fender = new Guitar();
$fender->brand_name = "Fender";
$fender->year = "1984";
$fender->model = "Stratocaster";
$fender->numStrings = 6;
echo $fender->info();
echo $fender->isStringed(true);
echo $fender->Message();

echo "</br>";

$king = new Trombone();
$king->brand_name = "King";
$king->year = "1968";
$king->model = "3B Concert";
$king->range = "tenor";
echo $king->info();
echo $king->isStringed(false);
echo $king->Message();
