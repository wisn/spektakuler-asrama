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
              <a class="btn btn-primary btn-block" href="/staff/kamar/list">
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
              <h2>Daftar Kamar</h2>
            </div>
          </div>

          <?php
            $putra = $json['putra'];
            $putri = $json['putri'];
          ?>

          <h5>Asrama Putra</h5>
          <?php if (!is_object($putra)): ?>
            <div class="nonexistance">
              Tidak ada data gedung. Sepertinya terjadi masalah dengan server.
            </div>
          <?php elseif (empty($putra->data)): ?>
           <div class="nonexistance"> 
              Tidak ada data gedung.
              <a href="/staff/gedung/new">Tambahkan</a> sekarang!
            </div>
          <?php else: ?>
            <?php foreach ($putra->data as $p): ?>
              <div class="gedung">
                <div class="title row">
                  <div class="col-md-9">
                    <h6>
                      Gedung <?php echo $p->nama; ?>
                      (<?php echo $p->tersisa; ?>/<?php echo $p->kapasitas; ?>)
                    </h6>
                  </div>
                  <div class="col-md-3">
                    <a class="btn btn-sm btn-block btn-secondary" href="/staff/kamar/new/<?php echo $p->id_gedung; ?>">Tambah Kamar</a>
                  </div>
                </div>

                <div class="content">
                  <?php if (!is_object($p->kamar)): ?>
                    Tidak ada data kamar. Sepertinya terjadi masalah dengan server.
                  <?php elseif (empty($p->kamar->data)): ?>
                    Tidak ada data kamar.
                    <a href="/staff/kamar/new/<?php echo $p->id_gedung; ?>">Tambahkan</a> sekarang!
                  <?php else: ?>
                    <?php foreach ($p->kamar->data as $k): ?>
                      <div class="row">
                        <div class="col-md-8">
                          <div class="name">Kamar <?php echo $k->no_kamar; ?></div>
                          <div class="addition">
                            <span class="label"><?php echo ($k->kategori == 'sr' ? 'Senior Residence' : 'Mahasiswa'); ?></span>
                            Kapasitas (<?php echo $k->tersisa; ?>/<?php echo $k->kapasitas; ?>)
                          </div>
                        </div>
                        <div class="col-md-4 action">
                          <div class="row">
                            <div class="col-md-6">
                              <a class="btn btn-secondary btn-sm btn-block" href="/staff/kamar/edit/<?php echo $k->id_kamar; ?>">
                                Sunting
                              </a>
                            </div>
                            <div class="col-md-6">
                            <a class="btn btn-danger btn-sm btn-block" href="/staff/kamar/remove/<?php echo $k->id_kamar; ?>">Hapus</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>

          <h5>Asrama Putri</h5>
          <?php if (!is_object($putri)): ?>
            <div class="nonexistance">
              Tidak ada data gedung. Sepertinya terjadi masalah dengan server.
            </div>
          <?php elseif (empty($putri->data)): ?>
           <div class="nonexistance"> 
              Tidak ada data gedung.
              <a href="/staff/gedung/new">Tambahkan</a> sekarang!
            </div>
          <?php else: ?>
            <?php foreach ($putri->data as $p): ?>
              <div class="gedung">
                <div class="title row">
                  <div class="col-md-9">
                    <h6>
                      Gedung <?php echo $p->nama; ?>
                      (<?php echo $p->tersisa; ?>/<?php echo $p->kapasitas; ?>)
                    </h6>
                  </div>
                  <div class="col-md-3">
                    <a class="btn btn-sm btn-block btn-secondary" href="/staff/kamar/new/<?php echo $p->id_gedung; ?>">Tambah Kamar</a>
                  </div>
                </div>

                <div class="content">
                  <?php if (!is_object($p->kamar)): ?>
                    Tidak ada data kamar. Sepertinya terjadi masalah dengan server.
                  <?php elseif (empty($p->kamar->data)): ?>
                    Tidak ada data kamar.
                    <a href="/staff/kamar/new/<?php echo $p->id_gedung; ?>">Tambahkan</a> sekarang!
                  <?php else: ?>
                    <?php foreach ($p->kamar->data as $k): ?>
                      <div class="row">
                        <div class="col-md-8">
                          <div class="name">Kamar <?php echo $k->no_kamar; ?></div>
                          <div class="addition">
                            <span class="label"><?php echo ($k->kategori == 'sr' ? 'Senior Residence' : 'Mahasiswa'); ?></span>
                            Kapasitas (<?php echo $k->tersisa; ?>/<?php echo $k->kapasitas; ?>)
                          </div>
                        </div>
                        <div class="col-md-4 action">
                          <div class="row">
                            <div class="col-md-6">
                              <a class="btn btn-secondary btn-sm btn-block" href="/staff/kamar/edit/<?php echo $k->id_kamar; ?>">
                                Sunting
                              </a>
                            </div>
                            <div class="col-md-6">
                              <?php echo form_open('/staff/kamar/remove/' . $k->id_kamar); ?>
                                <input class="btn btn-danger btn-sm btn-block" type="submit" value="Hapus">
                              <?php echo form_close(); ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </div>
              </div>
            <?php endforeach; ?>
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
