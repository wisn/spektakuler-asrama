<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gedung extends CI_Controller {
  private $url = 'http://localhost:8000/api/v1/asrama/gedung';

	public function index()
	{
		echo 'GedungController';
  }

  public function list()
  {
    if ($this->input->method() == 'get') {
      $gedung = $this->retrieve_list();
      $data = [
        'title' => 'Daftar Gedung',
        'json' => $gedung,
      ];

      $this->load->view('gedung/list', $data);
    }
  }

  private function retrieve_list() {
    $api = curl_init();
    curl_setopt($api, CURLOPT_URL, $this->url . '/list');
    curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($api, CURLOPT_HEADER, false);

    $result = curl_exec($api);
    $result = json_decode($result);
    curl_close($api);

    return $result;
  }
}
