<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require __DIR__ . '/../helpers/Api.php';

class Sr extends CI_Controller {
  public function index()
  {
    echo 'SeniorResidenceController';
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
          'title' => 'Masuk Sebagai Senior Residence',
      ];

      $this->load->view('sr/login', $data);
    } else if ($this->input->method() == 'post') {
      $input = $this->input->post(null, true);
      $username = @$input['username'] ?: '';
      $password = @$input['password'] ?: '';

      $json = json_encode(['username' => $username, 'password' => $password]);
      $login = (new Api('asrama/sr/login'))->post($json);
      if ($login->success) {
        $sr = $login->data;
        $this->session->set_userdata([
          'type' => 'sr',
          'sr' => $sr,
        ]);

        redirect('/sr/dashboard');
      } else {
          $data = [
            'title' => 'Masuk Sebagai Senior Residence',
            'json' => $login,
          ];

          $this->load->view('sr/login', $data);
      }
    }
  }

  public function dashboard() {
    if (isset($this->session->type)) {
      if ($this->session->type == 'staff') {
        redirect('/staff/dashboard');
      } else if ($this->session->type == 'mahasiswa') {
        redirect('/mahasiswa/dashboard');
      }
    } else {
      redirect('/sr/login');
    }

    $id_mahasiswa = $this->session->sr->id_mahasiswa;
    $id_gedung = $this->session->sr->id_gedung;
    $id_sr = $this->session->sr->id_sr;
    if ($this->input->method() == 'get') {
      $data = [
        'title' => 'Dashboard Senior Residence',
        'gedung' => (new Api('asrama/gedung/' . $id_gedung . '/show'))->get(),
        'hunian' => (new Api('asrama/penghuni/detail/' . $id_mahasiswa))->get(),
        'pendampingan' => (new Api('asrama/pendamping/' . $id_sr . '/list'))->get(),
        'penghuni' => (new Api('asrama/penghuni/list/mahasiswa/' . $id_mahasiswa))->get(),
      ];

      $this->load->view('sr/dashboard', $data);
    }
  }

  public function show($id_kamar) {
    if (isset($this->session->type)) {
      if ($this->session->type == 'staff') {
        redirect('/staff/dashboard');
      } else if ($this->session->type == 'mahasiswa') {
        redirect('/mahasiswa/dashboard');
      }
    } else {
      redirect('/sr/login');
    }

    if ($this->input->method() == 'get') {
      $data = [
        'title' => 'Daftar Mahasiswa',
        'kamar' => (new Api('asrama/kamar/' . $id_kamar . '/show'))->get(),
        'penghuni' => (new Api('asrama/penghuni/list/kamar/' . $id_kamar))->get(),
      ];

      $this->load->view('sr/show', $data);
    }
  }

  public function logout() {
    $this->session->unset_userdata('type');
    $this->session->unset_userdata('sr');
    redirect('/sr/login');
  }
}
