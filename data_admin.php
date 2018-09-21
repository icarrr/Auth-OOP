<?php
  require_once 'core/init.php';
  // jika tidak ada username yang diset, maka akan diredirect ke form login
  if(!$user->is_loggin())
  {
    Session::flash('login', 'Anda harus login terlebih dahulu');
    Redirect::to('login');
  }

  if(!$user->is_admin(Session::get('uname')))
  {
    Session::flash('profile', 'Halaman ini khusus admin');
    Redirect::to('profile');
  }

  $users = $user->get_users();

  require_once 'templates/header.php';
?>
<h2>Halaman admin</h2>
<?php foreach ($users as $_users): ?>
  <div class="">
    <a href="profile.php?nama=<?= $_users['uname'] ?>">
      <?= $_users['uname'] ?>
    </a>
  </div>
<?php endforeach; ?>

<?php
require_once 'templates/footer.php';
?>
