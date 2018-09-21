<?php
  require_once 'core/init.php';

  if($user->is_loggin())
  {
    Redirect::to('profile');
  }

  if(Session::exist('login')){
    echo Session::flash('login');
  }

  $errors = array();

  // mengirim data ke database
  if(Input::get('masuk'))
  {
    if(Token::check(Input::get('token')))
    {
      // mencegah pengiriman kosong
      // 1. Panggil fungsi validasi
      $validation = new Validation();

      // 2. Metode validasi
      $validation = $validation->check(array(
        'username' => array('required'  => true),
        'password' => array('required'  => true)
      ));

      // 3. lolos pengecekan
      if($validation->passed())
      {
        if($user->cek_nama(Input::get('username'))) //mengecek apakah username yang diinput ada di database atau tidak
        {
          if($user->login_user(Input::get('username'), Input::get('password'))) // mengecek username dan password jika username ditemukan didatabase
          {
            Session::set('uname', Input::get('username'));
            Redirect::to('profile');
          }else {
            $errors[] = "Login gagal";
          }
        }else {
          $errors[] = "Akun anda belum terdaftar";
        }
      }else{
        $errors = $validation->errors();
        // die ('Ada masalah penginputan');

        // untuk debug
        // print_r('<pre>');
        // print_r($validation->errors());
      }
    }
  }

  // memanggil header
  require_once 'templates/header.php';
?>

<h2>Please login</h2>
<form action="login.php" method="post">
  <table>
    <tr>
      <td>Username</td>
      <td><input type="text" name="username"> </td>
    </tr>
    <tr>
      <td>Password</td>
      <td><input type="password" name="password"> </td>
    </tr>
  </table>
  <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
  <input type="submit" name="masuk" value="Masuk">
  <br><br><br>
  <?php if(!empty($errors)){?>
    <div id="errors">
      <?php foreach ($errors as $error) { ?>
        <li>
          <?= $error; ?>
        </li>
      <?php } ?>
    </div>
  <?php } ?>
</form>

<?php
  // memanggil footer
  require_once 'templates/footer.php';
?>
