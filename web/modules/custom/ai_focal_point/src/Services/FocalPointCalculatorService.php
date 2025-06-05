<?php

namespace Drupal\ai_focal_point\Services;

/**
 * Computes the focal point from a given set of bounding boxes.
 *
 * @package Drupal\ai_focal_point\Services
 */
class FocalPointCalculatorService {

  /**
   * Constructor for FocalPointCalculatorService.
   */
  public function __construct() {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static();
  }

  /**
   * Evaluates the detected objects and determines/returns a focal point.
   *
   * @param array $objects
   *   The objects which might contribute to the focal point.
   * @param int $width
   *   The width of the image in pixels.
   * @param int $height
   *   The height of the image in pixels.
   *
   * @return array
   *   The X,Y coordinates as fractions of the image dimensions.
   */
  public static function computeFocalPoint($objects, $width, $height) {
    $x = 0.5;
    $y = 0.5;

    return ['x' => $x, 'y' => $y];
  }

}