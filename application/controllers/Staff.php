<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {
  private $url = 'http://localhost:8000/api/v1';

  public function index()
  {
    echo 'StaffController';
  }

  public function login()
  {
    if (isset($this->session->type)) {
      if ($this->session->type == 'mahasiswa') {
        redirect('mahasiswa/dashboard');
      } else if ($this->session->type == 'staff') {
        redirect('staff/dashboard');
      }
    }

    if ($this->input->method() == 'get') {
      $data = [
          'title' => 'Masuk Sebagai Staff',
      ];

      $this->load->view('staff/login', $data);
    } else if ($this->input->method() == 'post') {
      $input = $this->input->post(null, true);
      $username = @$input['username'] ?: '';
      $password = @$input['password'] ?: '';

      $login = $this->api_login($username, $password);
      if ($login->success) {
        $this->session->set_userdata([
          'type' => 'staff',
          'staff' => $login->data[0],
        ]);
        redirect('/staff/dashboard');
      } else {
          $data = [
            'title' => 'Masuk Sebagai Staff',
            'json' => $login,
          ];
          $this->load->view('staff/login', $data);
      }
    }
  }

  private function api_login($username, $password) {
    $json = json_encode(['username' => $username, 'password' => $password]);

    $api = curl_init();
    curl_setopt($api, CURLOPT_URL, $this->url . '/hr/staff/login');
    curl_setopt($api, CURLOPT_POST, true);
    curl_setopt($api, CURLOPT_POSTFIELDS, $json);
    curl_setopt($api, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($api, CURLOPT_HTTPHEADER, [
      'Content-Type: application/json',
    ]);

    $response = curl_exec($api);

    $result = json_decode($response);
    curl_close($api);

    return $result;
  }

  public function dashboard() {
    if (isset($this->session->type)) {
      if ($this->session->type == 'mahasiswa') {
        redirect('mahasiswa/dashboard');
      }
    } else {
      redirect('mahasiswa/login');
    }

    if ($this->input->method() == 'get') {
      $data = [
        'title' => 'Dashboard Mahasiswa',
        'json' => [
        ],
      ];

      $this->load->view('staff/dashboard', $data);
    }
  }

  public function logout() {
    $this->session->unset_userdata('type');
    redirect('staff/login');
  }
}
