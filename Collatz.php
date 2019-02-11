<?php

namespace Collatz;

// Requires dependencies
require_once './vendor/meyfa/php-svg/autoloader.php';

use SVG\SVG;
use SVG\Nodes\Shapes\SVGRect;
use SVG\Nodes\Shapes\SVGLine;
use SVG\Nodes\Shapes\SVGPath;
use SVG\Nodes\Shapes\SVGPolyline;

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
    $nodes = [];
    $stroke = "#000000";
    $stage = 0;
    $direction = [];

    for ($i = 0; $i < sizeof($arr); $i++) {
      if ($stage % 4 === 0) {
        $stage = 1;
      } else {
        $stage = $stage + 1;
      }
      
      switch($stage)
      {
        case 1:
        $direction = [$arr[$i],$arr[$i]];
        case 2:
        $direction = [$arr[$i],-$arr[$i]];
        case 3:
        $direction = [-$arr[$i],-$arr[$i]];
        case 4:
        $direction = [-$arr[$i],$arr[$i]];
      }
      
      $nodes[] = [$width/2, $i === 0 ? $arr[$i] :$arr[$i-1]];
      //$nodes[] = [$width/2, $i === 0 ? $arr[$i] :$arr[$i-1]];
      $nodes[] = $direction;
      //$nodes[] = [$arr[$i]*pi(), $arr[$i]/pi()];

        if ($arr[$i] % 2 === 0) {
          $stroke = "#AA00AA";
        } else {
          $stroke = "#00AA00";
        }

    }
    $path = new SVGPolyline($nodes);
    $path->setStyle('stroke', $stroke);
    $path->setStyle('stroke-width', 0.2);
    $path->setStyle('fill-opacity',0);
    $doc->addChild($path);
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