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
                Mahasiswa
              </a>
            </div>
          </div>
        </div>

        <div class="body">
          <div class="row">
            <div class="col-9">
              <h2>Daftar Gedung</h2>
            </div>
            <div class="col-3">
              <a class="btn btn-success btn-block" href="/staff/gedung/new">
                Tambah Gedung
              </a>
            </div>
          </div>

          <?php if (!is_object($json)): ?>
            <div class="nonexistance">
              Tidak ada data gedung. Sepertinya terjadi masalah dengan server.
            </div>
          <?php elseif (empty($json->data)): ?>
            <div class="nonexistance"> 
              Tidak ada data gedung.
              <a href="/staff/gedung/new">Tambahkan</a> sekarang!
            </div>
          <?php else: ?>
            <div class="existance">
              <?php foreach($json->data as $g): ?>
                <div class="row">
                  <div class="col-md-8">
                    <div class="name">Gedung <?php echo $g->nama; ?></div>
                    <div class="addition">
                      <span class="label"><?php echo ucfirst($g->kategori); ?></span>
                      Kapasitas (<?php echo $g->tersisa; ?>/<?php echo $g->kapasitas; ?>)
                    </div>
                  </div>
                  <div class="col-md-4 action">
                    <div class="row">
                      <div class="col-md-6">
                        <a class="btn btn-secondary btn-sm btn-block" href="/staff/gedung/edit/<?php echo $g->id_gedung; ?>">
                          Sunting
                        </a>
                      </div>
                      <div class="col-md-6">
                        <a class="btn btn-danger btn-sm btn-block" href="/staff/gedung/remove/<?php echo $g->id_gedung; ?>">Hapus</a>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
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
