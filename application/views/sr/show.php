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
          <h1>Senior Residence</h1>
        </div>

        <div class="menu">
          <div class="top row">
          </div>
        </div>

        <div class="body">
          <div class="row">
            <div class="col-9">
              <h2>Daftar Mahasiswa</h2>
            </div>
            <div class="col-3">
              <a class="btn btn-danger btn-block" href="/sr/dashboard">
                Kembali
              </a>
            </div>
          </div>

          <div style="margin: 6em"></div>
          <div class="row">
            <div class="col-12">
              <h5>Kamar <?php echo $kamar->data->no_kamar; ?></h5>

              <?php if (!is_object($penghuni)): ?>
                <div class="nonexistance">
                  Tidak ada data penghuni. Sepertinya terjadi masalah dengan server.
                </div>
              <?php elseif (count($penghuni->data) < 2): ?>
                <div class="nonexistance"> 
                  Tidak ada data penghuni.
                </div>
              <?php else: ?>
                <div class="existance">
                  <?php foreach ($penghuni->data as $p): ?>
                    <div class="row">
                      <div class="col-12">
                        <div class="name">
                          <?php echo $p->nama; ?> (<?php echo $p->nim; ?>)
                        </div>
                        <div class="addition">
                          <span class="label"><?php echo $p->program_studi; ?></span>
                          <span class="label"><?php echo $p->angkatan; ?></span>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <div class="logout">
          <a href="/mahasiswa/logout">Keluar</a>
        </div>
      </div>
    </main>

    <footer>
      <?php $this->view('partial/footer'); ?>
    </footer>
  </body>
</html>
