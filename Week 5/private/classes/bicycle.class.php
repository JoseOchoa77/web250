<?php

class Bicycle
{
  private const CATEGORIES = ['road', 'mountain', 'hybrid', 'cruiser', 'city', 'BMX'];
  private const GENDERS = ['mens', 'womans', 'unisex'];
  private const CONDITIONS = [1 => 'Beat up', 2 => 'Decent', 3 => 'Good', 4 => 'Great', 5 => 'Like new'];
  public $brand;
  public $model;
  public $year;
  public $category;
  public $color;
  public $description;
  public $gender;
  public $price;
  public $weightKg;
  public $weightLb;
  public $conditionId;

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
    $this->weightKg = $args['weightKg'] ?? 0;
  }

  public function setWeightKg($weightKg)
  {
    $this->weightKg = $weightKg;
  }

  public function weightKg()
  {
    return $this->weightKg;
  }

  public function weightLb()
  {
    return $this->weightLb = $this->weightKg / 0.453592;
  }

  public function setWeightLb()
  {
    $this->weightLb = $this->weightKg / 0.453592;
  }

  public function condition()
  {
    return self::CONDITIONS[$this->conditionId] ?? 'Unknown';
  }
}
