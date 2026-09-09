<?php

class Bird
{
  var $commonName;
  var $food = 'bugs';
  var $nestPlacement = 'tree';
  var $conservationLevel;

  function song($song)
  {
    if ($song) {
      return 'It can sing the song ' . $song . '';
    } else {
      return 'This bird sings no songs';
    }
  }

  function canFly($boolean)
  {
    if ($boolean == 'yes') {
      return 'This bird can fly!';
    } else {
      return 'This bird can\'t fly!';
    }
  }
}

$bird1 = new Bird;
$bird1->commonName = 'Eastern Towhee';
$bird1->food =  'small seeds, berries, buds, and insects';
$bird1->nestPlacement = 'Ground';
$bird1->conservationLevel = 'low';
$bird1->song('drink you tea!');
$bird1->canFly('yes');


$bird2 = new Bird;
$bird2->commonName = 'Indigo Bunting';
$bird2->food = 'seeds, fruits, insects,spiders';
$bird2->nestPlacement = ' roadsides, and railroad rights-of-wafields and on the edges';
$bird2->conservationLevel = 'low';
$bird2->song('whatwhat');
$bird2->canFly('yes');


echo ("Bird1 name is " . $bird1->commonName . " , it eats " . $bird1->food . " its nest placement is on " . $bird1->nestPlacement . ". " . $bird1->song('drink you tea!') . " " . $bird1->canFly('yes') . " <br/>");

echo ("Bird2 name is " . $bird2->commonName . " , it eats " . $bird2->food . " its nest placement is on " . $bird2->nestPlacement . ". " . $bird2->song('drink you tea!') . " " . $bird2->canFly('yes') . "");
