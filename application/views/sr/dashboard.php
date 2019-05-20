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
            <div class="col-12">
              <h5>Data Hunian</h5>

              <?php if (!is_object($hunian)): ?>
                <div class="nonexistance">
                  Tidak ada data hunian. Sepertinya terjadi masalah dengan server.
                </div>
              <?php elseif (empty($hunian->data)): ?>
                <div class="nonexistance"> 
                  Tidak ada data hunian. Hubungi staff untuk menambahkan data hunian Anda.
                </div>
              <?php else: ?>
                <div class="existance" align="center">
                  <?php $mahasiswa = $hunian->data->mahasiswa; ?>
                  <?php $kamar = $hunian->data->kamar; ?>
                  Anda, <strong><?php echo $mahasiswa->nama; ?></strong>
                  (<strong><?php echo $mahasiswa->nim; ?></strong>)
                  ditempatkan di <strong>Gedung <?php echo $kamar->nama; ?></strong>
                  dengan <strong>Kamar <?php echo $kamar->no_kamar; ?></strong>.
                </div>
              <?php endif; ?>
            </div>
          </div>

          <div style="margin: 6em"></div>
          <div class="row">
            <div class="col-12">
              <?php $gdg = ''; ?>
              <?php if (is_object($gedung) && $gedung->success) $gdg = ' Gedung ' . $gedung->data->nama; ?>
              <h5>Daftar Pendampingan<?php echo $gdg; ?></h5>

              <?php if (!is_object($pendampingan)): ?>
                <div class="nonexistance">
                  Tidak ada data pendampingan. Sepertinya terjadi masalah dengan server.
                </div>
              <?php elseif (empty($pendampingan->data)): ?>
                <div class="nonexistance"> 
                  Tidak ada data pendampingan. Hubungi staff untuk menambahkan data pendampingan Anda.
                </div>
              <?php else: ?>
                <div class="existance">
                  <?php $sr = $pendampingan->data; ?>
                  <?php foreach ($pendampingan->data as $p): ?>
                    <div class="row">
                      <div class="col-8">
                        <div class="name">
                          Kamar <?php echo $p->no_kamar; ?>
                        </div>
                        <div class="addition">
                          Kapasitas (<?php echo $p->tersisa; ?>/<?php echo $p->kapasitas; ?>)
                        </div>
                      </div>
                      <div class="col-4 action">
                        <a class="btn btn-secondary btn-small btn-block" href="/sr/show/<?php echo $p->id_kamar; ?>">
                          Lihat Daftar Mahasiswa
                        </a>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <div style="margin: 6em"></div>
          <div class="row">
            <div class="col-12">
              <h5>Daftar Penghuni Kamar</h5>

              <?php if (!is_object($penghuni)): ?>
                <div class="nonexistance">
                  Tidak ada data penghuni. Sepertinya terjadi masalah dengan server.
                </div>
              <?php elseif (count($penghuni->data) < 2): ?>
                <div class="nonexistance"> 
                  Tidak ada data penghuni. Anda tinggal sendirian.
                </div>
              <?php else: ?>
                <div class="existance">
                  <?php foreach ($penghuni->data as $p): ?>
                    <?php if ($p->id_mahasiswa != $mahasiswa->id_mahasiswa): ?>
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
                    <?php endif; ?>
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
