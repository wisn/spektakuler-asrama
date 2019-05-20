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
        $mahasiswa = $login->data[0];
        $this->session->set_userdata([
          'type' => 'mahasiswa',
          'mahasiswa' => $mahasiswa,
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

    $id_mahasiswa = $this->session->mahasiswa->id_mahasiswa;
    if ($this->input->method() == 'get') {
      $data = [
        'title' => 'Dashboard Mahasiswa',
        'hunian' => (new Api('asrama/penghuni/detail/' . $id_mahasiswa))->get(),
        'pendamping' => (new Api('asrama/pendamping/mahasiswa/' . $id_mahasiswa))->get(),
        'penghuni' => (new Api('asrama/penghuni/list/mahasiswa/' . $id_mahasiswa))->get(),
      ];

      $this->load->view('mahasiswa/dashboard', $data);
    }
  }

  public function logout() {
    $this->session->unset_userdata('type');
    $this->session->unset_userdata('mahasiswa');
    redirect('/mahasiswa/login');
  }
}
