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
   * The confidence score of the image object detection.
   *
   * @var float|null
   */
  private float|NULL $confidenceScore;

  /**
   * The constructor.
   */
  public function __construct(array $detection, float|NULL $confidence_score = NULL) {
    $this->detection = $detection;
    $this->confidenceScore = $confidence_score;
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

  /**
   * Returns the confidence score as a percentage.
   *
   * @return float|null
   *   The confidence score as a percentage.
   */
  public function getConfidenceScorePercentage(): string {
    return $this->confidenceScore ? round($this->confidenceScore * 100, 2) : '0';
  }

}
