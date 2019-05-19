<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require __DIR__ . '/../helpers/Api.php';

class Staff extends CI_Controller {
  public function index()
  {
    echo 'StaffController';
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
          'title' => 'Masuk Sebagai Staff',
      ];

      $this->load->view('staff/login', $data);
    } else if ($this->input->method() == 'post') {
      $input = $this->input->post(null, true);
      $username = @$input['username'] ?: '';
      $password = @$input['password'] ?: '';

      $json = json_encode(['username' => $username, 'password' => $password]);
      $login = (new Api('asrama/staff/login'))->post($json);
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

  public function dashboard() {
    redirect('/staff/gedung/list');
  }

  public function logout() {
    $this->session->unset_userdata('type');
    redirect('/staff/login');
  }

  public function gedung($action, $params = null) {
    if (isset($this->session->type)) {
      if ($this->session->type == 'mahasiswa') {
        redirect('/mahasiswa/dashboard');
      } else if ($this->session->type == 'sr') {
        redirect('/sr/dashboard');
      }
    } else {
      redirect('/staff/login');
    }

    switch($action) {
      case 'list':
        $this->gedungList();
        break;
      case 'remove':
        $this->gedungDelete($params);
        break;
      case 'new':
        $this->gedungNew();
        break;
      case 'edit':
        $this->gedungEdit($params);
        break;
    }
  }

  private function gedungList() {
    if ($this->input->method() == 'get') {
      $data = [
        'title' => 'Daftar Gedung',
        'json' => (new Api('asrama/gedung/list'))->get(),
      ];

      $this->load->view('staff/gedung/list', $data);
    }
  }

  private function gedungDelete($params) {
    if ($this->input->method() == 'get') {
      $data = [
        'title' => 'Hapus Gedung',
        'json' => (new Api('asrama/gedung/' . $params . '/show'))->get(),
      ];

      $this->load->view('staff/gedung/remove', $data);
    } else if ($this->input->method() == 'post') {
      (new Api('asrama/gedung/' . $params . '/remove'))->delete();
      redirect('/staff/gedung/list');
    }
  }

  private function gedungNew() {
    if ($this->input->method() == 'get') {
      $data = [
        'title' => 'Tambah Gedung',
      ];

      $this->load->view('staff/gedung/new', $data);
    } else if ($this->input->method() == 'post') {
      $input = $this->input->post(null, true);
      $nama = @$input['nama'] ?: '';
      $kategori = @$input['kategori'] ?: '';
      $kapasitas = @$input['kapasitas'] ?: '';
      $lokasi = @$input['lokasi'] ?: '';

      $json = json_encode([
        'nama' => $nama,
        'kategori' => $kategori,
        'kapasitas' => $kapasitas,
        'lokasi' => $lokasi,
      ]);

      $submit = (new Api('asrama/gedung/new'))->post($json);
      if ($submit->success) {
        redirect('/staff/gedung/list');
      } else {
        $data = [
          'title' => 'Tambah Gedung',
          'json' => $submit,
        ];

        $this->load->view('staff/gedung/new', $data);
      }
    }
  }

  private function gedungEdit($params) {
    if ($this->input->method() == 'get') {
      $data = [
        'title' => 'Sunting Gedung',
        'gedung' => (new Api('asrama/gedung/' . $params . '/show'))->get(),
      ];

      $this->load->view('staff/gedung/edit', $data);
    } else if ($this->input->method() == 'post') {
      $input = $this->input->post(null, true);
      $nama = @$input['nama'] ?: null;
      $kategori = @$input['kategori'] ?: null;
      $kapasitas = @$input['kapasitas'] ?: null;
      $lokasi = @$input['lokasi'] ?: null;

      $json = json_encode([
        'nama' => $nama,
        'kategori' => $kategori,
        'kapasitas' => $kapasitas,
        'lokasi' => $lokasi,
      ]);

      $submit = (new Api('asrama/gedung/' . $params . '/update'))->put($json);
      if ($submit->success) {
        redirect('/staff/gedung/list');
      } else {
        $data = [
          'title' => 'Sunting Gedung',
          'gedung' => (new Api('asrama/gedung/' . $params . '/show'))->get(),
          'json' => $submit,
        ];

        $this->load->view('staff/gedung/edit', $data);
      }
    }
  }

  public function kamar($action, $params = null) {
    if (isset($this->session->type)) {
      if ($this->session->type == 'mahasiswa') {
        redirect('/mahasiswa/dashboard');
      } else if ($this->session->type == 'sr') {
        redirect('/sr/dashboard');
      }
    } else {
      redirect('/staff/login');
    }

    switch($action) {
      case 'list':
        $this->kamarList();
        break;
      case 'remove':
        $this->kamarDelete($params);
        break;
      case 'new':
        $this->kamarNew($params);
        break;
      case 'edit':
        $this->kamarEdit($params);
        break;
    }
  }

  private function kamarList() {
    if ($this->input->method() == 'get') {
      $data = [
        'title' => 'Daftar Kamar',
        'json' => [
          'putra' => (new Api('asrama/gedung/list/putra'))->get(),
          'putri' => (new Api('asrama/gedung/list/putri'))->get(),
        ],
      ];

      if (is_object($data['json']['putra'])) {
        for ($i = 0; $i < count($data['json']['putra']->data); $i++) {
          $id_gedung = $data['json']['putra']->data[$i]->id_gedung;
          $data['json']['putra']->data[$i]->kamar = (new Api('asrama/gedung/list/' . $id_gedung . '/kamar'))->get();
        }
      }

      if (is_object($data['json']['putri'])) {
        for ($i = 0; $i < count($data['json']['putri']->data); $i++) {
          $id_gedung = $data['json']['putri']->data[$i]->id_gedung;
          $data['json']['putri']->data[$i]->kamar = (new Api('asrama/gedung/list/' . $id_gedung . '/kamar'))->get();
        }
      }

      $this->load->view('staff/kamar/list', $data);
    }
  }

  private function kamarNew($id_gedung) {
    if ($this->input->method() == 'get') {
      $data = [
        'title' => 'Tambah Kamar',
        'id_gedung' => $id_gedung,
      ];

      $this->load->view('staff/kamar/new', $data);
    } else if ($this->input->method() == 'post') {
      $input = $this->input->post(null, true);
      $no_kamar = @$input['no_kamar'] ?: '';
      $kategori = @$input['kategori'] ?: '';
      $kapasitas = @$input['kapasitas'] ?: '';
      $tersisa = $kapasitas;

      $json = json_encode([
        'no_kamar' => $no_kamar,
        'id_gedung' => $id_gedung,
        'kategori' => $kategori,
        'kapasitas' => $kapasitas,
        'tersisa' => $tersisa,
      ]);

      $submit = (new Api('asrama/kamar/new'))->post($json);
      if ($submit->success) {
        redirect('/staff/kamar/list');
      } else {
        $data = [
          'title' => 'Tambah Kamar',
          'id_gedung' => $id_gedung,
          'json' => $submit,
        ];

        $this->load->view('staff/kamar/new' , $data);
      }
    }
  }

  private function kamarDelete($params) {
    if ($this->input->method() == 'get') {
      $data = [
        'title' => 'Hapus Kamar',
        'json' => (new Api('asrama/kamar/' . $params . '/show'))->get(),
      ];

      $this->load->view('staff/kamar/remove', $data);
    } else if ($this->input->method() == 'post') {
      (new Api('asrama/kamar/' . $params . '/remove'))->delete();
      redirect('/staff/kamar/list');
    }
  }

  private function kamarEdit($params) {
    if ($this->input->method() == 'get') {
      $data = [
        'title' => 'Sunting Kamar',
        'kamar' => (new Api('asrama/kamar/' . $params . '/show'))->get(),
      ];

      $this->load->view('staff/kamar/edit', $data);
    } else if ($this->input->method() == 'post') {
      $input = $this->input->post(null, true);
      $no_kamar = @$input['no_kamar'] ?: null;
      $kategori = @$input['kategori'] ?: null;
      $kapasitas = @$input['kapasitas'] ?: null;

      $json = json_encode([
        'no_kamar' => $no_kamar,
        'kategori' => $kategori,
        'kapasitas' => $kapasitas,
      ]);

      $submit = (new Api('asrama/kamar/' . $params . '/update'))->put($json);
      if ($submit->success) {
        redirect('/staff/kamar/list');
      } else {
        $data = [
          'title' => 'Sunting Kamar',
          'kamar' => (new Api('asrama/kamar/' . $params . '/show'))->get(),
          'json' => $submit,
        ];

        $this->load->view('staff/kamar/edit', $data);
      }
    }
  }
}
