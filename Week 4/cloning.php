<?php

class Beverage {
  public $name;

  public function __construct()
  {
    echo "New beverage was create. <br/>";
  }

  public function __clone()
  {
    echo "New beverage was cloned. <br/>";
  }

}


$a = new Beverage();
$a->name = "coffee";
echo $a->name . '<br/>';

$b = clone $a;
echo $a->name . '<br/>';
echo $b->name . '<br/>';
echo '<hr/>';

$b->name = 'tea';

echo $a->name . '<br/>';
echo $b->name . '<br/>';

echo '<hr/>';

$c = $b;
$c->name = 'Orange Juice';

echo $a->name . '<br/>';
echo $b->name . '<br/>';
echo $c->name . '<br/>';

