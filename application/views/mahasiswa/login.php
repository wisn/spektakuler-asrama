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
      <?php if (isset($json) && !$json->success): ?>
        <?php echo $json->message; ?>
      <?php endif; ?>

      <?php echo form_open('mahasiswa/login'); ?>
        <input name="username" type="text">
        <input name="password" type="password">
        <input type="submit">
      <?php echo form_close(); ?>
    </main>

    <footer>
      <?php $this->view('partial/footer'); ?>
    </footer>
  </body>
</html>
