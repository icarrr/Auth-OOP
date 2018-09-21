<?php
  require_once 'core/init.php';
  // jika tidak ada username yang diset, maka akan diredirect ke form login
  if(!$user->is_loggin())
  {
    Session::flash('login', 'Anda harus login terlebih dahulu');
    Redirect::to('login');
  }

  $user_data = $user->get_data(Session::get('uname'));
  $errors = array();

  if(Input::get('submit'))
  {
    if(Token::check(Input::get('token')))
    {
      // mencegah pengiriman kosong
      // 1. Panggil fungsi validasi
      $validation = new Validation();

      // 2. Metode validasi
      $validation = $validation->check(array(
        'passwordLama'  => array(
                                'required'  => true
                                ),
        'passwordBaru'  => array(
                                'required'  => true,
                                'min'       => 4,
                                ),
        'passwordVer'   => array(
                                'required'  => true,
                                'match'     => 'passwordBaru',
                                )
      ));

      // 3. lolos pengecekan
      if($validation->passed())
      {
        if(password_verify(Input::get('passwordLama'), $user_data['passwd'])){
          $user->updateUser(array(
            'passwd'  => password_hash(Input::get('passwordBaru'), PASSWORD_DEFAULT)
          ), $user_data['id']);

          Session::flash('profile', 'Selamat, anda berhasil mengganti password');
          Redirect::to('profile');
        }else{
          $errors[] = 'password lama anda salah';
        }
      }else{
        $errors = $validation->errors();
      }
    }
  }

  require_once 'templates/header.php';
?>
<h1>Ganti Password</h1>
<h2>Hai, <?= $user_data['uname']; ?></h2>
<form action="change_pass.php" method="post">
  <table>
    <tr>
      <td>Password</td>
      <td><input type="password" name="passwordLama"> </td>
    </tr>
    <tr>
      <td>Password Baru</td>
      <td><input type="password" name="passwordBaru"> </td>
    </tr>
    <tr>
      <td>Verifikasi Password</td>
      <td><input type="password" name="passwordVer"> </td>
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
require_once 'templates/footer.php';
?>
