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
              <a class="btn btn-secondary btn-block" href="/staff/sr/list">
                Senior Residence
              </a>
            </div>
            <div class="col-md-3">
              <a class="btn btn-primary btn-block" href="/staff/mahasiswa/list">
                Mahasiswa
              </a>
            </div>
          </div>
        </div>

        <div class="body">
          <div class="row">
            <div class="col-9">
              <h2>Daftar Mahasiswa</h2>
            </div>
          </div>

          <?php if (!is_object($json)): ?>
            <div class="nonexistance">
              Tidak ada data mahasiswa. Sepertinya terjadi masalah dengan server.
            </div>
          <?php elseif (empty($json->data)): ?>
            <div class="nonexistance"> 
              Tidak ada data mahasiswa.
            </div>
          <?php else: ?>
            <div class="existance">
              <?php foreach($json->data as $m): ?>
                <?php if (is_object($m->is_sr) && !$m->is_sr->data): ?>
                  <div class="row">
                    <div class="col-9">
                      <div class="name"><?php echo $m->nama; ?> (<?php echo $m->nim; ?>)</div>
                      <div class="addition">
                        <span class="label"><?php echo ($m->gender == 'L' ? 'Laki-Laki' : 'Perempuan'); ?></span>
                        <?php if (is_object($m->kamar) && $m->kamar->success): ?>
                          <span class="label">Kamar <?php echo $m->kamar->data[0]->no_kamar; ?></span>
                        <?php else: ?>
                          <span class="label">Belum Menghuni Kamar</span>
                        <?php endif; ?>
                      </div>
                    </div>
                    <div class="col-3 action">
                      <div class="row">
                        <div class="col-12">
                          <?php if (is_object($m->kamar) && $m->kamar->success): ?>
                            <a class="btn btn-danger btn-sm btn-block" href="/staff/mahasiswa/remove/<?php echo $m->id_mahasiswa; ?>">
                              Unassign Kamar
                            </a>
                          <?php else: ?>
                            <a class="btn btn-secondary btn-sm btn-block" href="/staff/mahasiswa/edit/<?php echo $m->id_mahasiswa; ?>">
                              Assign Kamar
                            </a>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
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
