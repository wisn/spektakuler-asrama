<!DOCTYPE html>
<html>
  <head>
    <?php $this->view('partial/head'); ?>
  </head>
  <body>
    <header>
      <?php $this->view('partial/header'); ?>
    </header>

    <main>
      <div class="dashboard container">
        <div class="title">
          <p>Dashboard</p>
          <h1>Staff</h1>
        </div>

        <div class="menu">
          <div class="top row">
            <div class="col-md-3">
              <a class="btn btn-secondary btn-block" href="/staff/gedung/list">
                Gedung
              </a>
            </div>
            <div class="col-md-3">
              <a class="btn btn-secondary btn-block" href="/staff/kamar/list">
                Kamar
              </a>
            </div>
            <div class="col-md-3">
              <a class="btn btn-primary btn-block" href="/staff/sr/list">
                Senior Residence
              </a>
            </div>
            <div class="col-md-3">
              <a class="btn btn-secondary btn-block" href="/staff/mahasiswa/list">
                Mahasiswa
              </a>
            </div>
          </div>
        </div>

        <div class="body">
          <div class="row">
            <div class="col-9">
              <h2>Unassign Pendampingan SR</h2>
            </div>
          </div>

          <?php if (!is_object($sr)): ?>
            <div class="nonexistance">
              Tidak dapat meneruskan aksi. Sepertinya terjadi masalah dengan server.
            </div>
          <?php elseif (!$sr->success): ?>
            <div class="nonexistance">
              Tidak dapat meneruskan aksi. Data yang ingin dihapus tidak ada.
            </div>
          <?php else: ?>
            <div class="confirm">
              <p>
                Apakah Anda yakin melakukan unassign
                <strong>Kamar <?php echo $kamar->data->no_kamar; ?></strong> untuk SR
                <strong><?php echo $sr->data->nama; ?> (<?php echo $sr->data->nim; ?>)</strong>?
              </p>
              <div align="center">
                <?php echo form_open('/staff/pendamping/' . $sr->data->id_sr . '/' . $kamar->data->id_kamar . '/remove'); ?>
                  <input type="submit" class="btn btn-danger" value="Unassign">
                  <a href="/staff/sr/list" class="btn btn-primary">Batal</a>
                <?php echo form_close(); ?>
              </div>
            </div>
          <?php endif; ?>
        </div>

        <div class="logout">
          <a href="/staff/logout">Keluar</a>
        </div>
      </div>
    </main>

    <footer>
      <?php $this->view('partial/footer'); ?>
    </footer>
  </body>
</html>
