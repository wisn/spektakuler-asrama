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
              <h2>Daftar Senior Residence</h2>
            </div>
            <div class="col-3">
              <a class="btn btn-success btn-block" href="/staff/sr/new">Tambah SR</a>
            </div>
          </div>

          <?php
            $unassigned = $json['unassigned'];
            $assigned = $json['assigned'];
          ?>

          <h5>Unassigned SR</h5>
          <?php if (!is_object($unassigned)): ?>
            <div class="nonexistance">
              Tidak ada data senior residence. Sepertinya terjadi masalah dengan server.
            </div>
          <?php elseif (empty($unassigned->data)): ?>
           <div class="nonexistance"> 
              Tidak ada data senior residence.
            </div>
          <?php else: ?>
            <div class="existance" style="margin-top: -.5em">
            <?php foreach ($unassigned->data as $s): ?>
              <div class="row">
                <div class="col-md-8">
                  <div class="name"><?php echo $s->nama; ?> (<?php echo $s->nim; ?>)</div>
                  <div class="addition">
                    <span class="label"><?php echo $s->gender == 'L' ? 'Laki-Laki' : 'Perempuan'; ?></span>
                    <span class="label">Angkatan <?php echo $s->angkatan; ?></span>
                  </div>
                </div>
                <div class="col-md-4 action">
                  <div class="row">
                    <div class="col-6">
                      <a class="btn btn-secondary btn-sm btn-block" href="/staff/sr/edit/<?php echo $s->id_sr; ?>">
                        Assign Gedung
                      </a>
                    </div>
                    <div class="col-6">
                      <a class="btn btn-danger btn-sm btn-block" href="/staff/sr/remove/<?php echo $s->id_sr; ?>">
                        Hapus
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
            </div>
          <?php endif; ?>

          <div style="margin: 6em"></div>
          <h5>Assigned SR</h5>
          <?php if (!is_object($assigned)): ?>
            <div class="nonexistance">
              Tidak ada data senior residence. Sepertinya terjadi masalah dengan server.
            </div>
          <?php elseif (empty($assigned->data)): ?>
           <div class="nonexistance"> 
              Tidak ada data senior residence.
            </div>
          <?php else: ?>
            <div class="existance" style="margin-top: -.5em">
            <?php foreach ($assigned->data as $s): ?>
              <div class="row">
                <div class="col-7">
                  <div class="name"><?php echo $s->nama; ?> (<?php echo $s->nim; ?>)</div>
                  <div class="addition">
                    <span class="label"><?php echo $s->gender == 'L' ? 'Laki-Laki' : 'Perempuan'; ?></span>
                    <span class="label">Angkatan <?php echo $s->angkatan; ?></span>
                    <span class="label">Gedung <?php echo (is_object($s->gedung) && $s->gedung->success ? $s->gedung->data->nama : '?'); ?></span>
                    <?php if (is_object($s->kamar) && $s->kamar->success): ?>
                      <span class="label">Kamar <?php echo $s->kamar->data[0]->no_kamar; ?></span>
                    <?php else: ?>
                      <span class="label">Belum Menghuni Kamar</span>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="col-5 action">
                  <div class="row">
                    <div class="col-4">
                      <?php if (is_object($s->kamar) && $s->kamar->success): ?>
                        <a class="btn btn-danger btn-sm btn-block" href="/staff/penghuni/sr/<?php echo $s->id_mahasiswa; ?>/<?php echo $s->id_gedung; ?>/remove">
                          Unassign Hunian
                        </a>
                      <?php else: ?>
                        <a class="btn btn-secondary btn-sm btn-block" href="/staff/penghuni/sr/<?php echo $s->id_mahasiswa; ?>/<?php echo $s->id_gedung; ?>/new">
                          Assign Hunian
                        </a>
                      <?php endif; ?>
                    </div>
                    <div class="col-4">
                      <a class="btn btn-secondary btn-sm btn-block" href="/staff/pendamping/<?php echo $s->id_sr; ?>/<?php echo $s->id_gedung; ?>/new">
                        Assign Kamar
                      </a>
                    </div>
                    <div class="col-4">
                      <a class="btn btn-danger btn-sm btn-block" href="/staff/sr/unassign/<?php echo $s->id_sr; ?>">
                        Unassign Gedung
                      </a>
                    </div>
                  </div>
                </div>
                <?php if (is_object($s->pendampingan) && count($s->pendampingan->data) > 0): ?>
                  <div class="labelous col-12">
                    <hr>
                    Mendampingi kamar
                    <?php foreach ($s->pendampingan->data as $p): ?>
                      <a class="label" href="/staff/pendamping/<?php echo $s->id_sr; ?>/<?php echo $p->id_kamar; ?>/remove" title="Unassign Kamar"><?php echo $p->no_kamar; ?></a>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
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
