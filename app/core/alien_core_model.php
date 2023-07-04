<?php
class Alien_Core_Model extends SENE_Model{
  protected $tbl = '';
  protected $tbl_as = '';

  public function __construct(){
    parent::__construct();
    $this->tbl_as = $this->tbl;
    $this->db->from($this->tbl,$this->tbl_as);
  }
  public function query($sql){
    return $this->db->query($sql);
  }
  public function getAll(){
    $this->db->from($this->tbl,$this->tbl_as);
    return $this->db->get();
  }
  public function countAll(){
    $this->db->select_as('COUNT(*)','total',0);
    $this->db->from($this->tbl,$this->tbl_as);
    $d = $this->db->get_first();
    if(isset($d->total)) return $d->total;
    return 0;
  }
  public function getById($id){
    $this->db->where('id',$id);
    $this->db->from($this->tbl,$this->tbl_as);
    return $this->db->get_first();
  }
  public function set($di=array()){
    $this->db->insert($this->tbl,$di);
    return $this->db->last_id;
  }
  public function update($id,$du=array()){
    $this->db->where('id',$id);
    return $this->db->update($this->tbl,$du);
  }
  public function del($id){
    $this->db->where("id",$id);
    return $this->db->delete($this->tbl);
  }
  public function getByEmail($email){
    $this->db->where('email',$email);
    return $this->db->get_first();
  }
}