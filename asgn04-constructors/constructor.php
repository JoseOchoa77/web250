<?php

class Bird {
  public $commonName;
  public $latinName;

  public function setBirdNames($commonName, $latinName){
    $this->commonName = $commonName;
    $this->latinName = $latinName;
  }

}

$bird1 = new Bird();
$bird1->setBirdNames('Robin', 'Turdus migratorius');

$bird2 = new Bird();
$bird2->setBirdNames('Eastern Towhee', 'Pipilo erythrophthalmus');

echo $bird1->commonName . '<br/>';
echo $bird1->latinName . '<br/>';

echo '<hr/>';
echo $bird2->commonName. '<br/>';
echo $bird2->latinName . '<br/>';
