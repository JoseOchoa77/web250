<?php

/*
 * Bird class -- STARTER SCAFFOLD
 *
 * Your job is to fill this in. Every TODO below corresponds to a line item on
 * the assignment rubric. Work top to bottom: properties, constants,
 * constructor, then methods. Load birds.php in a browser after each step so
 * you find your mistakes one at a time instead of all at once.
 *
 * Your model is private/classes/bicycle.class.php from the chapter 7 videos.
 * Nearly everything here has a direct counterpart there. Where it does not,
 * the comment says so.
 *
 * REMINDER: above each item marked "why comment required" you must write a
 * block comment explaining how the code is used and WHY it exists -- what
 * problem it solves and what would break if you did it a simpler way. A
 * comment that only restates the code earns no credit.
 */

class Bird {

  /*
   * TODO 1 -- Properties
   */
    public $common_name;
    public $scientific_name;
    public $habitat;
    public $food;
    public $nest_placement;
    public $behavior;
    public $backyard_tips;
    protected $wingspan_cm;
    protected $weight_g;
    protected $weight_oz;
    protected $conservation_id;



   /*
   * Open private/wnc-birds.csv and look at the header row. Every column needs
   * a matching property, and the property name must match the column name
   * exactly, because the constructor looks the values up by key.
   *
   * Do NOT make them all public. Decide for each one:
   *
   *   public    -- plain descriptive text. Nothing to enforce, no formatting
   *                decision to make. Example: common_name.
   *
   *   protected -- anything stored in a specific UNIT or as a coded ID, so
   *                that reading and writing must go through a method. Three
   *                of the columns qualify. Look at how bicycle.class.php
   *                treats $weight_kg and $condition_id and follow that.
   *
   * why comment required: on the first protected property, explain why it is
   * protected when common_name is public.
   */



  /*
   * TODO 2 -- A static counter
   *
   * Add a public static property $count, starting at 0, and increment it in
   * the constructor. This has no counterpart in the bicycle class.
   *
   * why comment required: explain how this differs from the row_count()
   * method on ParseCSV. They often report the same number. Say when they
   * would not.
   * 
   * Answer: They wouldn't when 
   */

  public static $birdCount = 0;



  /*
   * TODO 3 -- Public constants
   *
   * Add at least two public constant arrays listing the allowed values for
   * two of the text columns -- HABITATS and FOOD_TYPES are the obvious pair.
   * Read the values out of the CSV; do not invent your own.
   *
   * These are the equivalent of CATEGORIES and GENDERS in bicycle.class.php.
   * Nothing in this assignment validates against them, but a filter menu or
   * an HTML form would read them, which is the reason they are public.
   */

    public const HABITATS = [
    1 => 'Open woodlands',
    2 => 'Forests',
    3 => 'Scrub',
    4 => 'High elevation',
    5 => 'Fields',
    6 => 'Wetland',
    7 => 'Cliff'];


    public const FOOD_TYPES = [
    1 => 'Insects',
    2 => 'Nectar',
    3 => 'Seeds',
    4 => 'Nuts',
    5 => 'Fish',
    6 => 'Small mammals',
    7 => 'Birds',
    8 => 'Omnivore'];


  /*
   * TODO 4 -- A protected constant for the conservation scale
   *
   * Copy the shape of CONDITION_OPTIONS from bicycle.class.php. Name it
   * CONSERVATION_OPTIONS and use this scale, which matches the
   * conservation_id column in the CSV:
   *
   *   1 = Low concern
   *   2 = Moderate concern
   *   3 = Extreme concern
   *   4 = Extinct
   *
   * why comment required: two things to address. Why is this protected when
   * HABITATS is public? And why does the CSV store the number 3 instead of
   * the words "Extreme concern"?
   */

    private const CONDITIONS = [1 => 'Low concern', 2 => 'Moderate concern', 3 => 'Extreme concern', 4 => 'Extinct'];

  /*
   * TODO 5 -- The constructor
   *
   * public function __construct($args=[])
   *
   * One array parameter, not ten separate ones. Assign every property from
   * $args using the null coalescing operator (??) so that a missing column
   * produces a default instead of an "Undefined array key" warning.
   *
   * Use a default of 1 for conservation_id and 0 for the two measurements.
   *
   * Route the two measurement assignments through your own setters rather
   * than writing to the protected properties directly. If you ever add
   * validation to a setter, the constructor then gets it for free.
   *
   * Don't forget to increment your counter from TODO 2.
   *
   * why comment required: why one $args array instead of a parameter for each
   * column? What happens if someone reorders the columns in the CSV?
   */

       public function __construct($args = [])
  {
    $this->common_name = $args['common_name'] ?? '';
    $this->scientific_name = $args['scientific_name'] ?? '';
    $this->habitat = $args['habitat'] ?? '';
    $this->food = $args['food'] ?? '';
    $this->nest_placement = $args['nest_placement'] ?? '';
    $this->behavior = $args['behavior'] ?? '';
    $this->wingspan_cm = $args['wingspan_cm'] ?? 0;
    $this->weight_g = $args['weight_g'] ?? 0;
    $this->conservation_id = $args['conservation_id'] ?? 1;
    $this->backyard_tips = $args['backyard_tips'] ?? '';

    self::$birdCount++;
  }

  /*
   * TODO 6 -- Getters and setters for wingspan
   *
   * Four methods, following weight_kg() / set_weight_kg() / weight_lbs() /
   * set_weight_lbs() in bicycle.class.php:
   *
   *   wingspan_cm()          returns the value formatted, with a unit label
   *   set_wingspan_cm($v)    stores it as a float
   *   wingspan_in()          converts and returns formatted inches
   *   set_wingspan_in($v)    converts inches to cm and stores that
   *
   * 1 cm = 0.393701 in. Use number_format() for the display formatting.
   *
   * why comment required: on set_wingspan_in(), explain why a setter named
   * for inches writes to a property measured in centimeters.
   */

    public function wingspan_cm(){
      echo $this->wingspan_cm . " cm";
    }

    public function set_weight_cm($v) {
     $this->weight_g = (float) $v / 0.035274;
   }

    public function wingspan_in() {
      echo number_format($this->wingspan_cm / 2.54, 2) . "in";
    }

    public function set_wingspan_in($v) {
     $this->wingspan_cm = (float) $v / 0.393701;
   }


  /*
   * TODO 7 -- Getters and setters for weight
   *
   * Same four-method pattern for weight_g / weight_oz.
   * 1 g = 0.0352740 oz.
   */

    public function weight_g(){
      return $this->weight_g;
    }

    public function set_weight($v) {
      $this->weight_g = $v;
    }

    public function weight_oz() {
      return number_format($this->weight_g * 0.035274, 4);
    }

    public function set_weight_oz($v){
      $v = $v * 0.035274;
      return $v;
    }

  /*
   * TODO 8 -- conservation()
   *
   * Mimic the condition() method in bicycle.class.php: take the id this
   * object is holding, look up the label in your protected constant, and
   * return it.
   *
   * Two requirements the bicycle version does not have. Use self:: to reach
   * the constant, not $this->. And an id that is not in the list must return
   * the string "Unknown" rather than producing a PHP error -- test this by
   * temporarily setting a conservation_id of 99 in the CSV.
   *
   * why comment required: why self:: and not $this->?
   */

    public function condition()
  {
    return self::CONDITIONS[$this->conservation_id] ?? 'Unknown';
  }

  public function conservation(){
    return $this->conservation_id;
  }


  /*
   * TODO 9 -- size_class()
   *
   * There is no counterpart for this in the videos; you are writing new
   * logic. Return 'Small', 'Medium', or 'Large' based on wingspan.
   *
   * You choose the cutoffs. Look at the actual range in the CSV (the
   * hummingbird is 11 cm, the raven is 130 cm) and pick thresholds that put a
   * useful number of birds in each group. Document the numbers you chose in
   * your comment and say why they suit this data.
   */

    public function size_class() {
      if ($this->wingspan_cm <= 35) {
        return 'Small';
      } elseif ($this->wingspan_cm <= 60) {
        return 'Medium';
      } else {
        return 'Large';
      }
    }


  /*
   * TODO 10 -- display_name()
   *
   * Return the common name together with the scientific name.
   *
   * There is a real decision here and it is graded on your reasoning, not on
   * which way you go. Scientific names are conventionally italicized. So
   * either:
   *
   *   (a) this method returns plain text and birds.php adds the <em> tags, or
   *   (b) this method returns a string containing <em> tags.
   *
   * If you pick (b), what happens when birds.php wraps the result in h()?
   * Try it and look at the page. Then decide which layer should own the
   * markup.
   *
   * why comment required: state which approach you chose and why.
   */

  public function display_name(){
    return  h($this->common_name).' (<em>'. h($this->scientific_name).'<em/>)';
  }



}

?>
