<?php 

class Bicycle {
  private const CATEGORIES = ['road', 'mountain', 'hybrid', 'cruiser', 'city', 'BMX'];
  private const GENDERS = ['mens', 'womans', 'unisex'];
  private const CONDITIONS = [1 => 'Beat up', 2 => 'Decent', 3 => 'Good', 4 => 'Great', 5 => 'Like new'];
  private $brand;
  private $model;
  private $year;
  private $category;
  private $color;
  private $description;
  private $gender;
  private $price;
  private $weightKg;
  private $weightLb;
  private $conditionId;

  public function __construct($args = [])
  {
    $this->brand = $args['brand'] ?? '';
    $this->model = $args['model'] ?? '';
    $this->year = $args['year'] ?? '';
    $this->category = $args['category'] ?? '';
    $this->color = $args['color'] ?? '';
    $this->description = $args['description'] ?? '';
    $this->gender = $args['gender'] ?? '';
    $this->price = $args['price'] ?? 0;
    $this->conditionId = $args['conditionId'] ?? 3;
    $this->conditionId = $args['weightKg'] ?? 0;
  }

  public function setWeightKg($weightKg){
    $this->weightKg = $weightKg;
  }

  public function weight(){
    return $this->weightKg;
  }

  public function weightLb(){
    return $this->weightLb;
  }

  public function setWeightLb(){
    $this->weightLb = $this->weightKg / 0.453592 ;
  }

  public function condition(){
    $condition = '';
    $this->conditionId == 1 ?? $condition = self::CONDITIONS[1];
    $this->conditionId == 2 ?? $condition = self::CONDITIONS[2];
    $this->conditionId == 3 ?? $condition = self::CONDITIONS[3];
    $this->conditionId == 4 ?? $condition = self::CONDITIONS[4];
    $this->conditionId == 5 ?? $condition = self::CONDITIONS[5];
    return $condition;
  }

}
