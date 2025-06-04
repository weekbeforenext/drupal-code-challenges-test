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
  private array $objects;

  /**
   * The confidence score of the image object detection.
   *
   * @var float|null
   */
  private float|NULL $confidenceScore;

  /**
   * The constructor.
   */
  public function __construct(array $objects, float|NULL $confidence_score = NULL) {
    $this->objects = $objects;
    $this->confidenceScore = $confidence_score;
  }

  /**
   * Returns the objects.
   *
   * @return array
   *   The objects.
   */
  public function getObjects(): array {
    return $this->objects;
  }

  /**
   * Sets the objects.
   *
   * @param array $objects
   *   The objects.
   */
  public function setObjects(array $objects): void {
    $this->objects = $objects;
  }

  /**
   * Returns the confidence score.
   *
   * @return float|null
   *   The confidence score.
   */
  public function getConfidenceScore(): float|NULL {
    return $this->confidenceScore;
  }

  /**
   * Sets the confidence score.
   *
   * @param float|null $confidence_score
   *   The confidence score.
   */
  public function setConfidenceScore(float|NULL $confidence_score): void {
    $this->confidenceScore = $confidence_score;
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
