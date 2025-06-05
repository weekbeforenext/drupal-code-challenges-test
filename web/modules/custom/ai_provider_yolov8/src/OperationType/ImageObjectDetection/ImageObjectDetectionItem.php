<?php

namespace Drupal\ai_provider_yolov8\OperationType\ImageObjectDetection;

/**
 * One object detection item.
 */
class ImageObjectDetectionItem {

  /**
   * The objects detected in the image.
   *
   * @var array
   */
  private array $detection;

  /**
   * The constructor.
   */
  public function __construct(array $detection) {
    $this->detection = $detection;
  }

  /**
   * Returns the detection.
   *
   * @return array
   *   The objects.
   */
  public function getDetection(): array {
    return $this->detection;
  }

  /**
   * Sets the detection.
   *
   * @param array $detection
   *   The detection.
   */
  public function setDetection(array $detection): void {
    $this->detection = $detection;
  }

}
