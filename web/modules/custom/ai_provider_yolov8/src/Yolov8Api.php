<?php

namespace Drupal\ai_provider_yolov8;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ImmutableConfig;
use Drupal\Core\File\FileSystemInterface;
use GuzzleHttp\Client;

/**
 * Ollama Control API.
 */
class Yolov8Api {

  /**
   * The http client.
   */
  protected Client $client;
  
  /**
   * The file system service.
   */
  protected FileSystemInterface $fileSystem;

  /**
   * The module config.
   */
  protected ImmutableConfig $config;

  /**
   * Constructs a new YOLOv8 object.
   *
   * @param \GuzzleHttp\Client $client
   *   Http client.
   */
  public function __construct(
    Client $client,
    FileSystemInterface $file_system,
    ConfigFactoryInterface $config_factory,
    ) {
    $this->client = $client;
    $this->fileSystem = $file_system;
    $this->config = $config_factory->get('ai_provider_yolov8.settings');
  }
  
  /**
   * Makes a Object Detection task call.
   *
   * @param string $endpoint
   *   The endpoint url or model name.
   * @param string $filePath
   *   The image file path to look at.
   *
   * @return string
   *   The return response undecoded.
   */
  public function imageObjectDetection($filePath) {
    $apiEndPoint = $this->finalEndpoint('predict');
    return $this->makeRequest($apiEndPoint, NULL, $filePath);
  }
  
  /**
   * Is endpoint a serverless endpoint or a dedicated url.
   *
   * @param string $endpoint
   *   The endpoint url or model name.
   *
   * @return string
   *   The final endpoint.
   */
  protected function finalEndpoint($endpoint) {
    return rtrim($this->config->get('host_name'), '/') . ':' . $this->config->get('port') . '/' . $endpoint;
  }

  /**
   * Make Huggingface call.
   *
   * @param string $apiEndPoint
   *   The api endpoint.
   * @param string $json
   *   JSON params.
   * @param string $file
   *   A (real) filepath.
   * @param string $method
   *   The http method.
   *
   * @return string|object
   *   The return response.
   */
  protected function makeRequest($apiEndPoint, $json = NULL, $file = NULL, $method = 'POST') {
    // We can wait some.
    $options['connect_timeout'] = 120;
    $options['read_timeout'] = 120;
    // Set authorization header.

    if ($json) {
      $options['body'] = json_encode($json);
      $options['headers']['Content-Type'] = 'application/json';
    }

    if ($file) {
      $options['body'] = fopen($file, 'r');
    }

    $res = $this->client->request($method, $apiEndPoint, $options);
    return $res->getBody();
  }

}
