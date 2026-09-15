<?php
class TradInstrument
{
  // This static property is shared at the class level.
  public static int $registeredCount = 0;
  public static string $tradition = "Irish Traditional Music <br/>";
  // A static method that changes the shared static property.

  public static function showTradition(): void
  {
    print self::$tradition . PHP_EOL;
  }

  public static function registerInstrument(): void
  {
    self::$registeredCount++;
    print "Instrument registered." . '<br/>';
  }
  // A static method for displaying the count.
  public static function showCount(): void
  {
    print "Registered instruments: " . self::$registeredCount .
      '<br/>';
  }
  // A normal method can still exist in the same class.
  public function describe(): void
  {
    print "This is an Irish traditional instrument." . '<br/>';
  }
}
// Fiddle inherits everything from TradInstrument.
class Fiddle extends TradInstrument
{
  public function describe(): void
  {
    print "The fiddle is a bowed string instrument." . '<br/>';
  }

  public static function tuning(): void
  {
    print "Fiddle tuning: G D A E" . '<br/>';
  }

  public static function registerFiddle(): void
  {
    print "Registering a fiddle..." . '<br/>';
    // parent:: refers to the parent class.
    parent::registerInstrument();
  }
}
// Concertina also inherits from TradInstrument.
class Concertina extends TradInstrument
{

  public function describe(): void
  {
    print "The concertina is a free-reed instrument." . '<br/>';
  }

  public static function tuning(): void
  {
    print "Anglo concertina: commonly C/G <br/>";
  }
}
// Whistle also inherits from TradInstrument.
class Whistle extends TradInstrument
{
  public function describe(): void
  {
    print "The tin whistle is a simple six-hole wind instrument." .
      '<br/>';
  }
}

class UilleannPipes extends TradInstrument
{
  public function describe(): void
  {
    print "Uilleann pipes are an Irish bellows-blown bagpipe." . PHP_EOL;
  }
}

// Call the inherited static method through the child classes.
Fiddle::registerFiddle();
Concertina::registerInstrument();
Whistle::registerInstrument();
UilleannPipes::registerInstrument();
// The counter is shared through the inheritance hierarchy.
TradInstrument::showCount();
// We can still create normal objects.
$fiddle = new Fiddle();
$concertina = new Concertina();
$fiddle->describe();
$concertina->describe();

Fiddle::tuning();
Concertina::tuning();

Fiddle::showTradition();
Concertina::showTradition();
UilleannPipes::showTradition();
