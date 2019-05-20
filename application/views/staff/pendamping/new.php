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
              <h2>Tambah Pendampingan SR</h2>
            </div>
            <div class="col-3">
              <a class="btn btn-danger btn-block" href="/staff/sr/list">
                Kembali
              </a>
            </div>
          </div>

          <div class="form">
            <?php if (isset($json) && !$json->success): ?>
              <div class="alert alert-danger" role="alert">
                <?php echo $json->message; ?>
              </div>
            <?php endif; ?>

            <?php if (!is_object($sr)): ?>
              <div class="nonexistance">
                Mahasiswa yang dicari tidak ada. Sepertinya terjadi masalah dengan server.
              </div>
            <?php elseif (!$sr->success): ?>
              <div class="nonexistance">
                Mahasiswa yang dicari tidak ada.
              </div>
            <?php else: ?>
              <?php $sr = $sr->data; ?>
              <?php echo form_open('/staff/pendamping/' . $sr->id_sr . '/' . $id_gedung . '/new'); ?>
                <p align="center">
                  Assign pendampingan senior residence <strong><?php echo $sr->nama; ?></strong>
                  (<strong><?php echo $sr->nim; ?></strong>) ke kamar:
                </p>

                <select name="id_kamar" class="form-control">
                  <option value="">Pilih Kamar</option>
                  <?php if (is_object($kamar) && $kamar->success): ?>
                    <?php foreach ($kamar->data as $k): ?>
                      <?php if ($k->tersisa > 0): ?>
                        <option value="<?php echo $k->id_kamar; ?>">Kamar <?php echo $k->no_kamar; ?></option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
                <div class="blocked">
                  <input type="submit" value="Kirim" class="btn btn-primary btn-block">
                </div>
              <?php echo form_close(); ?>

              <p>*) Wajib diisi</p>
            <?php endif; ?>
          </div>
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
