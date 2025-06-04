<?php

namespace Drupal\ai_provider_yolov8\OperationType\ImageObjectDetection;

use Drupal\ai\OperationType\OutputInterface;

/**
 * Data transfer output object for image object detection output.
 */
class ImageObjectDetectionOutput implements OutputInterface {

  /**
   * An array of ImageObjectDetectionItem objects.
   *
   * @var \Drupal\ai\OperationType\ImageObjectDetection\ImageObjectDetectionItem[]
   */
  private array $normalized;

  /**
   * The raw output from the AI provider.
   *
   * @var mixed
   */
  private mixed $rawOutput;

  /**
   * The metadata from the AI provider.
   *
   * @var mixed
   */
  private mixed $metadata;

  /**
   * The constructor.
   *
   * @param \Drupal\ai_provider_yolov8\OperationType\ImageObjectDetection\ImageObjectDetectionItem[] $normalized
   *   The image object detection items.
   * @param mixed $rawOutput
   *   The raw output from the AI provider.
   * @param mixed $metadata
   *   The metadata from the AI provider.
   */
  public function __construct(array $normalized, mixed $rawOutput, mixed $metadata) {
    $this->normalized = $normalized;
    $this->rawOutput = $rawOutput;
    $this->metadata = $metadata;
  }

  /**
   * Returns a array of ImageObjectDetectionItem objects.
   *
   * @return \Drupal\ai_provider_yolov8\OperationType\ImageObjectDetection\ImageObjectDetectionItem[]
   *   The image file object.
   */
  public function getNormalized(): array {
    return $this->normalized;
  }

  /**
   * Gets the raw output from the AI provider.
   *
   * @return mixed
   *   The raw output.
   */
  public function getRawOutput(): mixed {
    return $this->rawOutput;
  }

  /**
   * Gets the metadata from the AI provider.
   *
   * @return mixed
   *   The metadata.
   */
  public function getMetadata(): mixed {
    return $this->metadata;
  }

  /**
   * {@inheritdoc}
   */
  public function toArray(): array {
    return [
      'normalized' => $this->normalized,
      'rawOutput' => $this->rawOutput,
      'metadata' => $this->metadata,
    ];
  }

}
