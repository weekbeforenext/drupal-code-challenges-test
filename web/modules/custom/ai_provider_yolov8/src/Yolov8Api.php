<?php

namespace Drupal\ai_provider_yolov8;

use Drupal\Component\Serialization\Json;
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
   * The base host.
   */
  protected string $baseHost;

  /**
   * Constructs a new YOLOv8 object.
   *
   * @param \GuzzleHttp\Client $client
   *   Http client.
   */
  public function __construct(Client $client, FileSystemInterface $file_system) {
    $this->client = $client;
    $this->fileSystem = $file_system;
  }

  /**
   * Sets connect data.
   *
   * @param string $baseUrl
   *   The base url.
   */
  public function setConnectData($baseUrl) {
    $this->baseHost = $baseUrl;
  }

  /**
   * Get objects for a given image file.
   *
   * @param \Drupal\file\Entity\File $file
   *   The file entity.
   *
   * @return array
   *   The response.
   */
  public function objects($file_entity) {
    $real_path = $this->fileSystem
      ->realpath($file_entity->getFileUri());

    $multipart = [
      [
        'name'=> 'file',
        'contents' => fopen($real_path, 'r'),
        'filename' => $file_entity->getFilename(),
        'headers'  => [
          'Content-Type' => $file_entity->getMimeType(),
        ],
      ],
    ];
    $result = Json::decode($this->makeRequest("predict", [], 'POST', $multipart));
    return $result;
  }

  /**
   * Make YOLOv8 call.
   *
   * @param string $path
   *   The path.
   * @param array $query_string
   *   The query string.
   * @param string $method
   *   The method.
   * @param array $multipart
   *   Data to attach if POST/PUT/PATCH.
   * @param array $options
   *   Extra headers.
   *
   * @return string|object
   *   The return response.
   */
  protected function makeRequest($path, array $query_string = [], $method = 'POST', array $multipart, array $options = []) {
      $options['connect_timeout'] = 120;
      $options['read_timeout'] = 120;
      $options['timeout'] = 120;
      $options['headers']['accept'] = 'application/json';
      $options['headers']['Content-Type'] = 'multipart/form-data';
      $options['multipart'] = $multipart;

    $new_url = rtrim($this->baseHost, '/') . '/' . $path;
    $new_url .= count($query_string) ? '?' . http_build_query($query_string) : '';

    $res = $this->client->request($method, $new_url, $options);

    return $res->getBody()->getContents();
  }

}
