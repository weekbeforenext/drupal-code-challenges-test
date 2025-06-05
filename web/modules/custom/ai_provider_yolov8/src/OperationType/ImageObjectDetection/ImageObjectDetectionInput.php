<?php

namespace Drupal\ai_provider_yolov8\OperationType\ImageObjectDetection;

use Drupal\ai\OperationType\GenericType\ImageFile;
use Drupal\ai\OperationType\InputBase;
use Drupal\ai\OperationType\InputInterface;
use Drupal\file\Entity\File;

/**
 * Input object for image object detection.
 */
class ImageObjectDetectionInput extends InputBase implements InputInterface {

  /**
   * The image file to detect objects.
   *
   * @var \Drupal\file\Entity\File
   */
  private File $file;

  /**
   * The (in certain cases optional) objects to filter the object detection.
   *
   * @var string[]
   */
  private array $objects = [];

  /**
   * The constructor.
   *
   * @param \Drupal\file\Entity\File $file
   *   The image file to classify.
   * @param array $objects
   *   The (in certain cases optional) objects to filter the object detection.
   */
  public function __construct(File $file, array $objects = []) {
    $this->file = $file;
    $this->objects = $objects;
  }

  /**
   * Get the image that will be classify.
   *
   * @return \Drupal\file\Entity\File
   *   The file entity.
   */
  public function getImageFile(): File {
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
   * @param \Drupal\file\Entity\File $file
   *   The image file to classify.
   */
  public function setImageFile(File $file) {
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
