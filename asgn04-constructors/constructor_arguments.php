<?php 

class Bird {
  public $commonName;
  public $latinName;

  public function __construct($args =[]){
    $this->commonName = $args['commonName'] ?? NULL;
    $this->latinName = $args['latinName'] ?? NULL;
  }

}

$bird1 = new Bird(['commonName'=> 'Acadian Flycatcher', 'latinName'=>' Turdus migratorius']);

$bird2 = new Bird(['commonName'=> 'Eastern Towhee
', 'latinName'=>'Pipilo erythrophthalmus']);

echo $bird1->commonName . '<br/>';
echo $bird1->latinName . '<br/>';

echo '<hr/>';
echo $bird2->commonName. '<br/>';
echo $bird2->latinName . '<br/>';
