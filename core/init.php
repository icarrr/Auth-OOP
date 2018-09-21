<?php
  session_start();

  /*
  meload kelas secara otomatis, tanpa menginput nama file kelasnya secara manual
  yang akan mengakses classes bukan file init, namun file di luar folder core
  */
  spl_autoload_register(function($class)
  {
    require_once 'classes/' .$class. '.php';
  });

  $user = new User();
?>
