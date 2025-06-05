<?php

namespace Drupal\ai_focal_point\Services;

/**
 * Computes the focal point from a given set of bounding boxes.
 *
 * @package Drupal\ai_focal_point\Services
 */
class FocalPointCalculatorService {

  const OBJECT_WEIGHTS = [
    'person' => 10,
    'handbag' => 0,
    'chair' => 0,
  ];

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
    // We'll do all our focal point computation with (0,0) as the middle,
    // (-.5,-.5) as the top left, and (.5,.5) as the bottom right.
    // This treats the center of the image as the default position.
    $x = 0;
    $y = 0;

    // Iterate through all objects and add in their contributions.
    $to_return = [];
    $weight_counter = 0;
    foreach ($objects as $object) {
      $weight = static::OBJECT_WEIGHTS[$object['class_name']] ?? 1;
      if ($weight) {
        // Get the center of the bounding box relative to the image center.
        $box_center = static::centerCoordinates($object['box'], $width, $height);

        // @todo Remove this, it's just so we can see which objects are being considered
        $to_return[] = $box_center;

        // Add the contributions for this object.
        $x += ($box_center['x'] * $weight);
        $y += ($box_center['y'] * $weight);

        $weight_counter += $weight;
      }
    }

    // Divide by the number of objects so we're getting an average, not a sum.
    $x /= $weight_counter;
    $y /= $weight_counter;

    // Add 0.5 so the top left is 0,0 and the bottom right is 1,1 again.
    $x += 0.5;
    $y += 0.5;
    return ['x' => $x, 'y' => $y, 'objects' => $to_return];
  }

  /**
   * Computes and returns the centerpoint of a bounding box relative
   * to the center of the image.
   *
   * The top left corner is (-0.5,-0.5) and the bottom right is (0.5,0.5).
   *
   * @param array $box
   *   An array with x1, x2, y1 and y2 coordinates.
   * @param int $width
   *   The width of the full image.
   * @param int $height
   *   The height of the full image.
   *
   * @return array
   *   The coordinates of the bounding box center relative to the image center.
   */
  private static function centerCoordinates($box, $width, $height) {
    // Compute the bounding box center when the top left corner is 0,0.
    $box_x_center = ($box['x1'] + $box['x2'])/2;
    $box_y_center = ($box['y1'] + $box['y2'])/2;

    // Express as a fraction of the image width and height.
    $box_x_center /= $width;
    $box_y_center /= $height;

    // Subtract 0.5 to move the 0 point from the top left to the middle.
    return ['x' => $box_x_center - 0.5, 'y' => $box_y_center - 0.5];
  }

}
