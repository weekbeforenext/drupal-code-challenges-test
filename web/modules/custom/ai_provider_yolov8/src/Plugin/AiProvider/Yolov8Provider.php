<?php

namespace Drupal\ai_provider_yolov8\Plugin\AiProvider;

use Drupal\Core\Config\ImmutableConfig;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\ai\Attribute\AiProvider;
use Drupal\ai\Base\AiProviderClientBase;
use Drupal\ai\Exception\AiResponseErrorException;
use Drupal\ai_provider_yolov8\OperationType\ImageObjectDetection\ImageObjectDetectionInput;
use Drupal\ai_provider_yolov8\OperationType\ImageObjectDetection\ImageObjectDetectionInterface;
use Drupal\ai_provider_yolov8\OperationType\ImageObjectDetection\ImageObjectDetectionItem;
use Drupal\ai_provider_yolov8\OperationType\ImageObjectDetection\ImageObjectDetectionOutput;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Plugin implementation of the 'ai_yolov8' provider.
 */
#[AiProvider(
  id: 'ai_yolov8',
  label: new TranslatableMarkup('ai_yolov8'),
)]
class Yolov8Provider extends AiProviderClientBase implements
  ContainerFactoryPluginInterface,
  ImageObjectDetectionInterface {

  /**
   * The client for API calls.
   *
   * @var \Drupal\ai_provider_yolov8\Yolov8Api
   */
  protected $client;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Dependency Injection for the YOLOv8 API.
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = parent::create($container, $configuration, $plugin_id, $plugin_definition);
    $instance->client = $container->get('ai_provider_yolov8.api');
    $instance->currentUser = $container->get('current_user');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function getConfiguredModels(?string $operation_type = NULL, array $capabilities = []): array {
    return [
      'image_object_detection' => 'yolov8',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function isUsable(?string $operation_type = NULL, array $capabilities = []): bool {
    if (!$this->getBaseHost()) {
      return FALSE;
    }
    if ($operation_type) {
        return in_array($operation_type, $this->getSupportedOperationTypes());
    }
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function getSupportedOperationTypes(): array {
    return [
      'image_object_detection',
    ];
  }
  
  /**
   * {@inheritdoc}
   */
  public function getConfig(): ImmutableConfig {
    return $this->configFactory->get('ai_provider_yolov8.settings');
  }

  /**
   * {@inheritdoc}
   */
  public function getApiDefinition(): array {
    // Load the configuration.
    $definition = Yaml::parseFile($this->moduleHandler->getModule('ai_provider_yolov8')->getPath() . '/definitions/api_defaults.yml');
    return $definition;
  }

  /**
   * {@inheritdoc}
   */
  public function getModelSettings(string $model_id, array $generalConfig = []): array {
    return $generalConfig;
  }

  /**
   * {@inheritdoc}
   */
  public function setAuthentication(mixed $authentication): void {
    // Doesn't do anything.
    $this->client = NULL;
  }
  
  /**
   * Gets the base host.
   *
   * @return string
   *   The base host.
   */
  protected function getBaseHost(): string {
    $host = rtrim($this->getConfig()->get('host_name'), '/');
    if ($this->getConfig()->get('port')) {
      $host .= ':' . $this->getConfig()->get('port');
    }
    return $host;
  }

  /**
   * {@inheritdoc}
   */
  public function imageObjectDetection(string|array|ImageObjectDetectionInput $input, string $model_id, array $tags = []): ImageObjectDetectionOutput {
    $info = $this->getModelInfo('image_object_detection', $model_id);

    // Normalize the input if needed.
    if ($input instanceof ImageObjectDetectionInput) {
      $input = $input->getImageFile()->getBinary();
    }
    // Store temporary file.
    $temp_file = tempnam(sys_get_temp_dir(), 'ai_image_object_detection');
    file_put_contents($temp_file, $input);
    // Send the request.
    $response = json_decode($this->client->imageObjectDetection($temp_file), TRUE);
    // Remove the temporary file.
    unlink($temp_file);
    $objectds = [];
    if (is_array($response)) {
      foreach ($response as $row) {
        $objects[] = new ImageObjectDetectionItem($row['objects'], $row['score']);
      }
    }
    else {
      throw new AiResponseErrorException('Invalid response from YOLOv8.');
    }

    return new ImageObjectDetectionOutput($objects, $response, []);
  }


}
