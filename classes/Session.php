<?php
  class Session{
    public static function exist($nama)
    {
      return (isset($_SESSION[$nama])) ? true : false;
    }

    public static function set($nama, $nilai)
    {
      return $_SESSION[$nama] = $nilai;
    }

    public static function get($nama)
    {
      return $_SESSION[$nama];
    }

    public static function flash($nama, $pesan = '')
    {
      if(self::exist($nama))
      {
        $session = self::get($nama);
        self::delete($nama);
        return $session;
      }else{
        self::set($nama, $pesan);
      }
    }

    public static function delete($nama)
    {
      if(self::exist($nama)){
        unset($_SESSION[$nama]);
      }
    }
  }
?>
