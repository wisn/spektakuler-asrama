<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require __DIR__ . '/../helpers/Api.php';

class Mahasiswa extends CI_Controller {
  public function index()
  {
    echo 'MahasiswaController';
  }

  public function login()
  {
    if (isset($this->session->type)) {
      if ($this->session->type == 'mahasiswa') {
        redirect('/mahasiswa/dashboard');
      } else if ($this->session->type == 'staff') {
        redirect('/staff/dashboard');
      } else if ($this->session->type == 'sr') {
        redirect('/sr/dashboard');
      }
    }

    if ($this->input->method() == 'get') {
      $data = [
          'title' => 'Masuk Sebagai Mahasiswa',
      ];

      $this->load->view('mahasiswa/login', $data);
    } else if ($this->input->method() == 'post') {
      $input = $this->input->post(null, true);
      $username = @$input['username'] ?: '';
      $password = @$input['password'] ?: '';

      $json = json_encode(['username' => $username, 'password' => $password]);
      $login = (new Api('asrama/mahasiswa/login'))->post($json);
      if ($login->success) {
        $this->session->set_userdata([
          'type' => 'mahasiswa',
          'mahasiswa' => $login->data[0],
        ]);
        redirect('/mahasiswa/dashboard');
      } else {
          $data = [
            'title' => 'Masuk Sebagai Mahasiswa',
            'json' => $login,
          ];
          $this->load->view('mahasiswa/login', $data);
      }
    }
  }

  public function dashboard() {
    if (isset($this->session->type)) {
      if ($this->session->type == 'staff') {
        redirect('/staff/dashboard');
      } else if ($this->session->type == 'sr') {
        redirect('/sr/dashboard');
      }
    } else {
      redirect('/mahasiswa/login');
    }

    if ($this->input->method() == 'get') {
      $penghunian = $this->api_penghunian($this->session->mahasiswa->nim);
      $pendampingan = $this->api_pendampingan($this->session->mahasiswa->nim);
      $data = [
        'title' => 'Dashboard Mahasiswa',
        'json' => [
          'mahasiswa' => $this->session->mahasiswa,
          'penghunian' => $penghunian->data,
          'pendampingan' => $pendampingan->data,
        ],
      ];

      $this->load->view('mahasiswa/dashboard', $data);
    }
  }

  private function api_pendampingan($nim) {
    $api = curl_init();
    curl_setopt($api, CURLOPT_URL, $this->url . '/asrama/pendamping/' . $nim . '/assigned');
    curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($api, CURLOPT_HEADER, false);

    $response = curl_exec($api);
    $result = json_decode($response);

    curl_close($api);

    return $result;
  }

  private function api_penghunian($nim) {
    $api = curl_init();
    curl_setopt($api, CURLOPT_URL, $this->url . '/asrama/penghuni/' . $nim . '/assigned');
    curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($api, CURLOPT_HEADER, false);

    $response = curl_exec($api);
    $result = json_decode($response);

    curl_close($api);

    return $result;
  }

  public function logout() {
    $this->session->unset_userdata('type');
    redirect('/mahasiswa/login');
  }
}
