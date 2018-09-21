<?php
  class Redirect{
    public static function to($lokasi)
    {
      header('location: '. $lokasi.'.php');
    }
  }
?>
