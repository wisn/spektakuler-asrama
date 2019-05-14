<?php
$mahasiswa = $json['mahasiswa'];
$penghunian = $json['penghunian'];
$pendampingan = $json['pendampingan'];
?>

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
      Halo, <?php echo $json['mahasiswa']->nama; ?> (<?php echo $json['mahasiswa']->nim; ?>)!
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <a href="/index.php/mahasiswa/logout">Logout</a>
      <br>
      <br>
      <?php if ($penghunian != null) : ?>
        Kamu menghuni gedung <strong><?php echo $penghunian->nama_gedung; ?></strong>
        dengan nomor kamar <strong><?php echo $penghunian->no_kamar; ?></strong>.
      <?php else: ?>
        Kamu belum menghuni gedung mananpun.
      <?php endif; ?>
      <?php if ($mahasiswa->angkatan != date('Y')): ?>
        <br>
        <br>
        <?php if (count($pendampingan) == 0): ?>
          Kamu tidak mendampingi kamar manapun.
        <?php else: ?>
          <?php foreach ($pendampingan as $p): ?>
            Kamu mendampingi kamar <strong><?php echo $p->no_kamar; ?></strong>
            di gedung <strong><?php echo $p->nama_gedung; ?></strong><br>
          <?php endforeach; ?>
        <?php endif; ?>
      <?php endif; ?>
    </main>

    <footer>
      <?php $this->view('partial/footer'); ?>
    </footer>
  </body>
</html>
