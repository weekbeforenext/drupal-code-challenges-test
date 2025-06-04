<?php

namespace Drupal\ai_provider_yolov8\OperationType\ImageObjectDetection;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\ai\Attribute\OperationType;
use Drupal\ai\OperationType\OperationTypeInterface;

/**
 * Interface for image object detection models.
 */
#[OperationType(
  id: 'image_object_detection',
  label: new TranslatableMarkup('Image Object Detection'),
)]
interface ImageObjectDetectionInterface extends OperationTypeInterface {

  /**
   * Detect objects in an image.
   *
   * @param string|array|\Drupal\ai_provider_yolov8\OperationType\ImageObjectDetection\ImageObjectDetectionInput $input
   *   The image object detection input.
   * @param string $model_id
   *   The model id to use.
   * @param array $tags
   *   Extra tags to set.
   *
   * @return \Drupal\ai_provider_yolov8\OperationType\ImageObjectDetection\ImageObjectDetectionOutput
   *   The image object detection output.
   */
  public function imageObjectDetection(string|array|ImageObjectDetectionInput $input, string $model_id, array $tags = []): ImageObjectDetectionOutput;

}
