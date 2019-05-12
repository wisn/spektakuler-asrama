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
      <?php if ($json->success): ?>
        <?php if (count($json->data) > 0): ?>
          <ul>
            <?php foreach($json->data as $gedung): ?>
              <li>Gedung <?php echo $gedung->nama; ?></li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          Tidak ada data!
        <?php endif; ?>
      <?php endif; ?>
    </main>

    <footer>
      <?php $this->view('partial/footer'); ?>
    </footer>
  </body>
</html>
