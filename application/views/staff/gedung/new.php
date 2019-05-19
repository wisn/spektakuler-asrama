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
              <a class="btn btn-primary btn-block" href="/staff/gedung/list">
                Gedung
              </a>
            </div>
            <div class="col-md-3">
              <a class="btn btn-secondary btn-block" href="/staff/kamar/list">
                Kamar
              </a>
            </div>
            <div class="col-md-3">
              <a class="btn btn-secondary btn-block" href="/staff/sr/list">
                Senior Residence
              </a>
            </div>
            <div class="col-md-3">
              <a class="btn btn-secondary btn-block" href="/staff/mahasiswa/list">
                Mahasiswa Baru
              </a>
            </div>
          </div>
        </div>

        <div class="body">
          <div class="row">
            <div class="col-9">
              <h2>Tambah Gedung</h2>
            </div>
            <div class="col-3">
              <a class="btn btn-danger btn-block" href="/staff/gedung/list">
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

            <?php echo form_open('/staff/gedung/new'); ?>
              <input type="text" name="nama" placeholder="Nama Gedung*" class="form-control">
              <select name="kategori" class="form-control">
                <option value="putra">Putra</option>
                <option value="putri">Putri</option>
              </select>
              <input type="number" name="kapasitas" placeholder="Kapasitas*" class="form-control">
              <textarea name="lokasi" placeholder="Lokasi" class="form-control"></textarea>
              <div class="blocked">
                <input type="submit" value="Kirim" class="btn btn-primary btn-block">
              </div>
            <?php echo form_close(); ?>

            <p>*) Wajib diisi</p>
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
