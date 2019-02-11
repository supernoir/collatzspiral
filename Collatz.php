<?php

namespace Collatz;

// Requires dependencies
require_once './vendor/meyfa/php-svg/autoloader.php';

use SVG\SVG;
use SVG\Nodes\Shapes\SVGRect;
use SVG\Nodes\Shapes\SVGLine;

class CollatzSpiral
{

  protected $presets;
  const DEFAULT_INITIAL = 13;
  const DEFAULT_MAX = 1000;

  public function __construct($presets)
  {
    $this->presets = $presets;
  }

  /**
   * Calculates Collatz Numbers
   */
  public function calculateCollatzTree($ini, $max)
  {
    if (isset($this->presets) && is_numeric($this->presets)) {
      $ini = $this->presets[0];
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
  public function createGraphic($arr)
  {
    $width = 640;
    $height = 480;
    $image = new SVG($width, $height);
    $doc = $image->getDocument();

    for ($i = 0; $i < sizeof($arr); $i++) {
        $line = new SVGLine($width / 2, $height - $arr[$i], $arr[$i]*10, $arr[$i]);
        $square = new SVGRect($width / 2, $height - $arr[$i], $arr[$i]*10, $arr[$i]);
        if ($arr[$i] % 2 === 0) {
          $line->setStyle('stroke', '#AA00AA');
          $square->setStyle('fill', '#FF00FF');
        } else {
          $line->setStyle('stroke', '#00AA00');
          $square->setStyle('fill', '#00FF00');
        }
      $square->setStyle('fill-opacity', 0.1);
      $line->setStyle('stroke-width', $i * 0.025);
      $doc->addChild($line);
      $doc->addChild($square);

    }
    echo $image;
  }

  public function createSpiral()
  {
    $arr = self::calculateCollatzTree(13, 100);
    return self::createGraphic($arr);
  }
}

$collatz = new CollatzSpiral($presets);
$collatz->createSpiral();