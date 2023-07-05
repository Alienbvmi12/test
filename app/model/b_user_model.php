<?php
class B_User_Model extends Alien_Core_Model
{
  public function __construct()
  {
    $this->tbl = "user";
    parent::__construct();
  }
  public function getByCredential($cred){
    return $this->db->query("select * from user where username='$cred' or email='$cred' or telepon='$cred'");
  }
}

