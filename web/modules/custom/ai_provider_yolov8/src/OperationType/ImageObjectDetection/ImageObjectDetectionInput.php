<?php

namespace Drupal\ai_provider_yolov8\OperationType\ImageObjectDetection;

use Drupal\ai\OperationType\GenericType\ImageFile;
use Drupal\ai\OperationType\InputBase;
use Drupal\ai\OperationType\InputInterface;

/**
 * Input object for image object detection.
 */
class ImageObjectDetectionInput extends InputBase implements InputInterface {

  /**
   * The image file to detect objects.
   *
   * @var \Drupal\ai\OperationType\GenericType\ImageFile
   */
  private ImageFile $file;

  /**
   * The (in certain cases optional) objects to filter the object detection.
   *
   * @var string[]
   */
  private array $objects = [];

  /**
   * The constructor.
   *
   * @param \Drupal\ai\OperationType\GenericType\ImageFile $file
   *   The image file to classify.
   * @param array $objects
   *   The (in certain cases optional) objects to filter the object detection.
   */
  public function __construct(ImageFile $file, array $objects = []) {
    $this->file = $file;
    $this->objects = $objects;
  }

  /**
   * Get the image that will be classify.
   *
   * @return \Drupal\ai\OperationType\GenericType\ImageFile
   *   The binary.
   */
  public function getImageFile(): ImageFile {
    return $this->file;
  }

  /**
   * Get the objects to filter the object detection.
   *
   * @return array
   *   The objects to filter the object detection.
   */
  public function getObjects(): array {
    return $this->objects;
  }

  /**
   * Set the image file to detect objects.
   *
   * @param \Drupal\ai\OperationType\GenericType\ImageFile $file
   *   The image file to classify.
   */
  public function setImageFile(ImageFile $file) {
    $this->file = $file;
  }

  /**
   * Set the objects to filter the object detection.
   *
   * @param array $objects
   *   The labels to filter the object detection.
   */
  public function setObjects(array $objects) {
    $this->objects = $objects;
  }

  /**
   * {@inheritdoc}
   */
  public function toString(): string {
    return $this->file->getFilename();
  }

}
