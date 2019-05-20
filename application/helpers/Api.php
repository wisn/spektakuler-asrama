<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api {
  private $url = 'http://localhost:8000/api/v1/';
  private $path = '';
  private $error_response;

  public function __construct($path) {
    $this->path = $path;
    $this->error_response = (object) [
      'http_code' => 500,
      'success' => false,
      'message' => 'Terjadi kesalahan di server utama. Tidak dapat mengirim permintaan.',
    ];
  }

  public function post($data = '') {
    $api = curl_init();
    curl_setopt($api, CURLOPT_URL, $this->url . $this->path);
    curl_setopt($api, CURLOPT_POST, true);
    curl_setopt($api, CURLOPT_POSTFIELDS, $data);
    curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($api, CURLOPT_HTTPHEADER, [
      'Content-Type: application/json',
    ]);

    $response = curl_exec($api);
    $info = curl_getinfo($api);

    $result;
    if (empty($response)) {
      $result = $this->error_response;
    } else {
      $result = json_decode($response);
      $result->http_code = $info['http_code'];
    }

    curl_close($api);

    return $result;
  }

  public function get($path = '') {
    $api = curl_init();
    curl_setopt($api, CURLOPT_URL, $this->url . $this->path . $path);
    curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($api, CURLOPT_HEADER, false);

    $response = curl_exec($api);
    $info = curl_getinfo($api);

    $result;
    if (empty($response)) {
      $result = $this->error_response;
    } else {
      $result = json_decode($response);
      $result->http_code = $info['http_code'];
    }

    curl_close($api);

    return $result;
  }

  public function delete($path = '') {
    $api = curl_init();
    curl_setopt($api, CURLOPT_URL, $this->url . $this->path . $path);
    curl_setopt($api, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($api, CURLOPT_HEADER, false);

    $response = curl_exec($api);
    $info = curl_getinfo($api);

    $result;
    if (empty($response)) {
      $result = $this->error_response;
    } else {
      $result = json_decode($response);
      $result->http_code = $info['http_code'];
    }

    curl_close($api);

    return $result;
  }

  public function put($data = '') {
    $api = curl_init();
    curl_setopt($api, CURLOPT_URL, $this->url . $this->path);
    curl_setopt($api, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($api, CURLOPT_POSTFIELDS, $data);
    curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($api, CURLOPT_HEADER, false);
    curl_setopt($api, CURLOPT_HTTPHEADER, [
      'Content-Type: application/json',
    ]);

    $response = curl_exec($api);
    $info = curl_getinfo($api);

    $result;
    if (empty($response)) {
      $result = $this->error_response;
    } else {
      $result = json_decode($response);
      $result->http_code = $info['http_code'];
    }

    curl_close($api);

    return $result;
  }
}
