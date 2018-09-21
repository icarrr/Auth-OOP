<?php
  require_once 'core/init.php';

  if($user->is_loggin())
  {
    Redirect::to('profile');
  }

  $errors = array();

  // mengirim data ke database
  if(Input::get('submit'))
  {
    if(Token::check(Input::get('token')))
    {
      // mencegah pengiriman kosong
      // 1. Panggil fungsi validasi
      $validation = new Validation();

      // 2. Metode validasi
      $validation = $validation->check(array(
        'username' => array(
                        'required'  => true,
                        'min'       => 4,
                        'max'       => 10,
                          ),
        'password' => array(
                        'required'  => true,
                        'min'       => 4,
                          ),
        'password_ver' => array(
                        'required'  => true,
                        'match'     => 'password',
                          )
      ));

      // mencegah input  username yang sama
      if($user->cek_nama(Input::get('username')))
      {
        $errors[] = 'sudah terdaftar';
      }else{
        // 3. lolos pengecekan
        if($validation->passed())
        {
          $user->register_user(array(
            'uname'   => Input::get('username'),
            'passwd'  => password_hash(Input::get('password'), PASSWORD_DEFAULT)
          ));

          Session::flash('profile', 'Selamat, anda berhasil mendaftar');

          Session::set('uname', Input::get('username'));
          Redirect::to('profile');

        }else{
          $errors = $validation->errors();
          // die ('Ada masalah penginputan');

          // untuk debug
          // print_r('<pre>');
          // print_r($validation->errors());
        }
      }
    }
  }

  // memanggil header
  require_once 'templates/header.php';
?>

<h2>Please register</h2>
<form action="register.php" method="post">
  <table>
    <tr>
      <td>Username</td>
      <td><input type="text" name="username"> </td>
    </tr>
    <tr>
      <td>Password</td>
      <td><input type="password" name="password"> </td>
    </tr>
    <tr>
      <td>Repeat Password</td>
      <td><input type="password" name="password_ver"> </td>
    </tr>
  </table>
  <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
  <input type="submit" name="submit" value="Submit">
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
