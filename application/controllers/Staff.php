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

  public function sr($action, $params = null) {
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
        $this->srList();
        break;
      case 'remove':
        $this->srDelete($params);
        break;
      case 'new':
        $this->srNew();
        break;
      case 'edit':
        $this->srEdit($params);
        break;
      case 'unassign':
        $this->srUnassign($params);
        break;
    }
  }

  private function srList() {
    if ($this->input->method() == 'get') {
      $data = [
        'title' => 'Daftar Kamar',
        'json' => [
          'unassigned' => (new Api('asrama/sr/list/unassigned'))->get(),
          'assigned' => (new Api('asrama/sr/list/assigned'))->get(),
        ],
      ];

      if (is_object($data['json']['assigned'])) {
        for ($i = 0; $i < count($data['json']['assigned']->data); $i++) {
          $id_gedung = $data['json']['assigned']->data[$i]->id_gedung;
          $id_mahasiswa = $data['json']['assigned']->data[$i]->id_mahasiswa;
          $data['json']['assigned']->data[$i]->gedung = (new Api('asrama/gedung/' . $id_gedung . '/show'))->get();
          $data['json']['assigned']->data[$i]->kamar = (new Api('asrama/penghuni/kamar/' . $id_mahasiswa))->get();
        }
      }

      $this->load->view('staff/sr/list', $data);
    }
  }

  private function srDelete($params) {
    if ($this->input->method() == 'get') {
      $data = [
        'title' => 'Hapus SR',
        'json' => (new Api('asrama/sr/' . $params . '/show'))->get(),
      ];

      $this->load->view('staff/sr/remove', $data);
    } else if ($this->input->method() == 'post') {
      (new Api('asrama/sr/' . $params . '/remove'))->delete();
      redirect('/staff/sr/list');
    }
  }

  private function srNew() {
    if ($this->input->method() == 'get') {
      $data = [
        'title' => 'Tambah SR',
      ];

      $this->load->view('staff/sr/new', $data);
    } else if ($this->input->method() == 'post') {
      $input = $this->input->post(null, true);
      $nim = @$input['nim'] ?: null;
      $username = @$input['username'] ?: null;
      $password = @$input['password'] ?: null;

      $json = json_encode([
        'nim' => $nim,
        'username' => $username,
        'password' => $password,
      ]);

      $submit = (new Api('asrama/sr/new'))->post($json);
      if ($submit->success) {
        redirect('/staff/sr/list');
      } else {
        $data = [
          'title' => 'Tambah SR',
          'json' => $submit,
        ];

        $this->load->view('staff/sr/new' , $data);
      }
    }
  }

  private function srEdit($params) {
    if ($this->input->method() == 'get') {
      $sr = (new Api('asrama/sr/' . $params . '/show'))->get();
      $gender = $sr->data->gender == 'L' ? 'putra' : 'putri';

      $data = [
        'title' => 'Assign Gedung',
        'sr' => $sr,
        'gedung' => (new Api('asrama/gedung/list/' . $gender))->get(),
      ];

      $this->load->view('staff/sr/edit', $data);
    } else if ($this->input->method() == 'post') {
      $input = $this->input->post(null, true);
      $id_gedung = @$input['id_gedung'] ?: null;

      $json = json_encode([
        'id_gedung' => $id_gedung,
      ]);

      $submit = (new Api('asrama/sr/' . $params . '/update'))->put($json);
      if ($submit->success) {
        redirect('/staff/sr/list');
      } else {
        $sr = (new Api('asrama/sr/' . $params . '/show'))->get();
        $gender = $sr->data->gender == 'L' ? 'putra' : 'putri';

        $data = [
          'title' => 'Assign Gedung',
          'sr' => $sr,
          'gedung' => (new Api('asrama/gedung/list/' . $gender))->get(),
          'json' => $submit,
        ];

        $this->load->view('staff/sr/edit', $data);
      }
    }
  }

  private function srUnassign($params) {
    if ($this->input->method() == 'get') {
      $data = [
        'title' => 'Unassign Gedung',
        'json' => (new Api('asrama/sr/' . $params . '/show'))->get(),
      ];

      $this->load->view('staff/sr/unassign', $data);
    } else if ($this->input->method() == 'post') {
      $json = json_encode([
        'id_gedung' => 0,
      ]);
      (new Api('asrama/sr/' . $params . '/update'))->put($json);

      redirect('/staff/sr/list');
    }
  }

  public function penghuni($category = null, $id_mahasiswa = null, $id_gedung = null, $action = null) {
    if (isset($this->session->type)) {
      if ($this->session->type == 'mahasiswa') {
        redirect('/mahasiswa/dashboard');
      } else if ($this->session->type == 'sr') {
        redirect('/sr/dashboard');
      }
    } else {
      redirect('/staff/login');
    }

    switch ($category) {
      case 'sr':
        $this->penghuniSr($id_mahasiswa, $id_gedung, $action);
        break;
    }
  }

  private function penghuniSr($id_mahasiswa, $id_gedung, $action) {
    switch ($action) {
      case 'new':
        $this->penghuniSrNew($id_mahasiswa, $id_gedung);
        break;
      case 'remove':
        $this->penghuniSrDelete($id_mahasiswa, $id_gedung);
        break;
    }
  }

  private function penghuniSrNew($id_mahasiswa, $id_gedung) {
    if ($this->input->method() == 'get') {
      $kamar = (new Api('asrama/gedung/list/' . $id_gedung . '/kamar/sr'))->get();
      $mahasiswa = (new Api('asrama/mahasiswa/' . $id_mahasiswa . '/show'))->get();
      $data = [
        'title' => 'Assign Hunian SR',
        'mahasiswa' => $mahasiswa,
        'id_gedung' => $id_gedung,
        'kamar' => $kamar,
      ];

      $this->load->view('staff/penghuni/new', $data);
    } else if ($this->input->method() == 'post') {
      $input = $this->input->post(null, true);
      $id_kamar = $input['id_kamar'] ?: null;

      $json = json_encode([
        'id_mahasiswa' => $id_mahasiswa,
        'id_kamar' => $id_kamar,
      ]);

      $submit = (new Api('asrama/penghuni/new'))->post($json);
      if ($submit->success) {
        redirect('/staff/sr/list');
      } else {
        $kamar = (new Api('asrama/gedung/list/' . $id_gedung . '/kamar/sr'))->get();
        $mahasiswa = (new Api('asrama/mahasiswa/' . $id_mahasiswa . '/show'))->get();
        $data = [
          'title' => 'Assign Hunian SR',
          'mahasiswa' => $mahasiswa,
          'id_gedung' => $id_gedung,
          'kamar' => $kamar,
          'json' => $submit,
        ];

        $this->load->view('staff/penghuni/new', $data);
      }
    }
  }

  private function penghuniSrDelete($id_mahasiswa, $id_kamar) {
    if ($this->input->method() == 'get') {
      $data = [
        'title' => 'Unassign Kamar',
        'id_mahasiswa' => $id_mahasiswa,
        'id_kamar' => $id_kamar,
        'json' => (new Api('asrama/mahasiswa/' . $id_mahasiswa . '/show'))->get(),
      ];

      $this->load->view('staff/penghuni/remove', $data);
    } else if ($this->input->method() == 'post') {
      (new Api('asrama/penghuni/' . $id_mahasiswa . '/remove'))->delete();

      redirect('/staff/sr/list');
    }
  }
}
