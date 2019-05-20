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
      <div class="login container">
        <div class="title">
          <p>Masuk Sebagai</p>
          <h1>Senior Residence</h1>
        </div>

        <?php if (isset($json) && !@$json->success): ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $json->message; ?>
          </div>
        <?php endif; ?>

        <div class="input-group">
          <?php echo form_open('sr/login'); ?>
            <input class="form-control" name="username" type="text" placeholder="Nama Pengguna">
            <input class="form-control" name="password" type="password" placeholder="Kata Sandi">
            <div class="blocked">
              <input class="btn btn-primary btn-block" type="submit" value="Masuk">
            </div>
          <?php echo form_close(); ?>
        </div>

        <div class="divider"></div>
        <div align="center">
          Bukan senior residence?<br>
          Masuk sebagai
          <a href="/staff/login">Staff</a>
          atau
          <a href="/mahasiswa/login">Mahasiswa</a>.
        </div>
      </div>
    </main>

    <footer>
      <?php $this->view('partial/footer'); ?>
    </footer>
  </body>
</html>
