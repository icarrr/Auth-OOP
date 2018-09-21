<?php
  class User{
    private $db;

    public function __construct()
    {
      $this->db = Database::getInstance();
    }

    public function register_user($fields = array())
    {
      if($this->db->insert('members',$fields)) return true;
      else return false;
    }

    public function login_user($username, $password)
    {
      $data = $this->db->get_info('members','uname',$username);

      if(password_verify($password, $data['passwd']))
        return true;
      else return false;
    }

    public function cek_nama($username)
    {
      $data = $this->db->get_info('members','uname',$username);
      if(empty($data)) return false;
      else return true;
    }

    public function is_admin($username)
    {
      $data = $this->db->get_info('members','uname',$username);
      if($data['role'] == 1) return true;
      else return false;
    }

    public function is_loggin()
    {
      if(Session::exist('uname')) return true;
      else return false;
    }

    public function get_data($username)
    {
      if($this->cek_nama($username))
        return $this->db->get_info('members','uname',$username);
      else die('nama user tidak terdaftar');
    }

    public function updateUser($fields = array(), $id)
    {
      if($this->db->update('members', $fields, $id)) return true;
      else return false;
    }

    public function get_users()
    {
      return $this->db->get_info('members');
    }
  }
?>
