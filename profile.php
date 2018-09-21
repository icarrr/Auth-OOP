<?php
  require_once 'core/init.php';
  // jika tidak ada username yang diset, maka akan diredirect ke form login
  if(!$user->is_loggin())
  {
    Session::flash('login', 'Anda harus login terlebih dahulu');
    Redirect::to('login');
  }

  if(Session::exist('profile'))
  {
    echo Session::flash('profile');
  }

  if(Input::get('nama'))
  {
    $user_data = $user->get_data(Input::get('nama'));
  }else{
    $user_data = $user->get_data(Session::get('uname'));
  }

  require_once 'templates/header.php';
?>
<h2>Hai, <?= $user_data['uname'] ?></h2>
<?php if($user_data['uname'] == Session::get('uname')){ ?>
  <a href="change_pass.php">Ganti Password</a>
  <?php if($user->is_admin(Session::get('uname'))){ ?>
    <a href="data_admin.php">Cek user</a>
  <?php } ?>
<?php } ?>

<?php
require_once 'templates/footer.php';
?>
