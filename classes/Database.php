<?php
  class Database{
    private $mysqli,
            $HOST   = 'localhost',
            $USER   = 'root',
            $PASS   = 'resistance',
            $DBNAME = 'OOP';

    private static $INSTANCE = null;

    // cek koneksi ke database
    public function __construct()
    {
      $this->mysqli = new mysqli($this->HOST, $this->USER, $this->PASS, $this->DBNAME);

      if(mysqli_connect_error())
      {
        echo "Connection error";
      }
    }

    /*
      singleton pattern,
      menguji koneksi agar tidak berulang(double)
    */
    public static function getInstance()
    {
      // self = koneksi kita sendiri/classnya sendiri yang akan mengakses variabelnya
      if(!isset(self::$INSTANCE))
      {
        self::$INSTANCE = new Database(); // karena $INSTANCE belum ada isinya(masih null), maka akan diisi dengan koneksi database
      }
      return self::$INSTANCE;
    }

    public function insert($table, $fields = array())
    {
      // mengambil kolom
      $kolom = implode(", ", array_keys($fields));

      // mengambil nilai
      $valueArray = array();
      $i = 0;
      foreach ($fields as $key => $nilai)
      {
        if(is_int($nilai))
        {
          $valueArray[$i] = $this->escape($nilai);
        }else
        {
          $valueArray[$i] = "'" . $this->escape($nilai) . "'";
        }
        $i++;
      }

      // menyatukannya setelah dipisah
      $nilai = implode(", ", $valueArray);

      $query = "INSERT INTO $table ($kolom) VALUES ($nilai)";

      // kirim data ke database
      return $this->run_query($query, 'Anda melanggar aturan pengiriman data');
    }

    public function get_info($table, $column = '', $value = '')
    {
      if(!is_int($value))
        $value = "'" . $value . "'";

      if($column != '')
      {
        $query  = "SELECT * FROM $table WHERE $column = $value";
        $result = $this->mysqli->query($query);

        while ($row = $result->fetch_assoc()) {
          return $row;
        }
      }else{
        $query  = "SELECT * FROM $table";
        $result = $this->mysqli->query($query);

        while ($row = $result->fetch_assoc()) {
          $results[] = $row;
        }
        return $results;
      }
    }

    public function update($table, $fields, $id)
    {
      // mengambil nilai
      $valueArray = array();
      $i = 0;
      foreach ($fields as $key => $nilai)
      {
        if(is_int($nilai))
        {
          $valueArray[$i] = $key . "=" . $this->escape($nilai);
        }else
        {
          $valueArray[$i] = $key . "='" . $this->escape($nilai) . "'";
        }
        $i++;
      }

      // menyatukannya setelah dipisah
      $nilai = implode(", ", $valueArray);
      $query = "UPDATE $table SET $nilai WHERE id = $id";

      // kirim data ke database
      return $this->run_query($query, 'Masalah update data');
    }

    // untuk mencegah injection
    public function escape($name)
    {
      return $this->mysqli->real_escape_string($name);
    }

    // fungsi pengirim ke Database
    public function run_query($query, $msg)
    {
      if($this->mysqli->query($query)) return true;
      else die($msg);
    }


  }

  // mengakses database secara langsung, dan dapat berulang
  // new Database();

  // koneksi ke database
  // $db = Database::getInstance();

  // debugging
  // print_r('<pre>');
  // print_r($db);
?>
