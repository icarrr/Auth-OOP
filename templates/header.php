<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login | Register OOP</title>
    <link rel="stylesheet" href="assets/master.css">
  </head>
  <body>
    <header>
      <h1>Hello world</h1>
      <nav>
        <?php if(Session::exist('uname')){ ?>
          <a href="logout.php">Logout</a>
        <?php }else{ ?>
          <a href="login.php">Login</a>
          <a href="register.php">Register</a>
        <?php } ?>
        <a href="profile.php">Profile</a>
      </nav>
    </header>
