<?php

namespace Collatz;

// Requires dependencies
require_once './vendor/meyfa/php-svg/autoloader.php';

use SVG\SVG;
use SVG\Nodes\Shapes\SVGRect;

class CollatzSpiral
{

  protected $argv;
  const DEFAULT_INITIAL = 13;
  const DEFAULT_MAX = 1000;

  public function __construct($argv)
  {
    $this->argv = $argv;
  }

  /**
   * Calculates Collatz Numbers
   */
  public function calculateCollatzTree($ini, $max)
  {
    if (isset($this->argv) && is_numeric($this->argv)) {
      $ini = $this->argv[0];
    } else {
      $ini = self::DEFAULT_INITIAL;
    }
    $arr = [];
    for ($i = $ini; $i <= $max; $i++) {
      if ($i % 2 === 0) {
        $arr[] = $i / 2;
      } else {
        $arr[] = $i * 3 + 1;
      }
    }
    return $arr;
  }

  /**
   * Prints Collatz Numbers to the Console in fancy colors
   */
  public function printCollatzNumbersToConsole()
  {
    $v = $this->argv;
    $arr = self::calculateCollatzTree(13, 100);
    foreach ($arr as $val) {
      if ($val % 2 === 0) {
        echo "\e[0;35;40m" . $val . "\e[0m" . '|';
      } else {
        echo "\e[0;36;40m" . $val . "\e[0m" . '|';
      }
    }
  }

  /**
   * Creates SVG image
   */
  public function createGraphic()
  {
    $image = new SVG(100, 100);
    $doc = $image->getDocument();

    $square = new SVGRect(0, 0, 40, 40);
    $square->setStyle('fill', '#0000FF');
    $doc->addChild($square);
    echo $image;
  }

}

$collatz = new CollatzSpiral($argv);
$collatz->printCollatzNumbersToConsole();