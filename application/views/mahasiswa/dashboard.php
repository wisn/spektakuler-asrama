<?php
$mahasiswa = $json['mahasiswa'];
$penghunian = $json['penghunian'];
$kamar = @$penghunian->kamar[0];
$penghuni = @$penghunian->penghuni;
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
        Kamu menghuni gedung <strong><?php echo $kamar->nama_gedung; ?></strong>
        dengan nomor kamar <strong><?php echo $kamar->no_kamar; ?></strong>.

        <?php if (count($penghuni) > 1): ?>
          <br>
          Bersama dengan:
          <ol>
            <?php foreach($penghuni as $p): ?>
              <?php if ($p->nim != $mahasiswa->nim): ?>
                <li><?php echo $p->nim; ?></li>
              <?php endif; ?>
            <?php endforeach; ?>
          </ol>
        <?php endif; ?>
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
