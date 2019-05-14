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
      <h2>Mahasiswa</h2>

      <?php if (isset($json) && !$json->success): ?>
        <?php echo $json->message; ?>
      <?php endif; ?>

      <?php echo form_open('mahasiswa/login'); ?>
        <input name="username" type="text" placeholder="username">
        <input name="password" type="password" placeholder="password">
        <input type="submit">
      <?php echo form_close(); ?>
      <br>
      <a href="/staff/login">Masuk sebagai Staff</a>
    </main>

    <footer>
      <?php $this->view('partial/footer'); ?>
    </footer>
  </body>
</html>
