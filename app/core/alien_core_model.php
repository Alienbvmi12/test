<?php
class Alien_Core_Model extends SENE_Model{
  public $tbl = '';
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
  public function getAllOnly($cond=true){
    if($cond){
      $cond='is null';
    }
    else{
      $cond='is not null';
    }
    return $this->query("select * from {$this->tbl} where deleted_at $cond");
  }
  public function countAll(){
    $this->db->select_as('COUNT(*)','total',0);
    $this->db->from($this->tbl,$this->tbl_as);
    $d = $this->db->get_first();
    if(isset($d->total)) return $d->total;
    return 0;
  }
  public function countAllOnly(){
    $this->db->select_as('COUNT(*)','total',0);
    $this->db->from($this->tbl,$this->tbl_as);
    $d = $this->db->get_first();
    if(isset($d->total)) return $d->total;
    return 0;
  }
  public function countWhere($val, $col = "id"){
    $this->db->where($col,$val);
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
  public function create($di=array()){
    $this->db->insert($this->tbl,$di);
    return $this->db->last_id;
  }
  public function update($id,$du=array(), $col = "id"){
    $this->db->where($col, $id);
    return $this->db->update($this->tbl,$du);
  }
  public function delete($id, $col = "id"){
    $this->db->where($col,$id);
    return $this->db->delete($this->tbl);
  }
  public function moveToTrash($id, $col = "id"){
    return $this->db->query("update {$this->tbl} set deleted_at='".date("Y-m-d", time())."' where $col='$id'");
  }
  public function recover($id, $col = "id"){
    return $this->db->query("update {$this->tbl} set deleted_at='0000-00-00' where $col='$id'");
  }
  public function getByEmail($email){
    $this->db->where('email',$email);
    return $this->db->get_first();
  }
  public function getColumnName($pos){
    $pos++;
    return $this->db->query(
      "SELECT COLUMN_NAME
      FROM information_schema.columns
      WHERE TABLE_SCHEMA = 'pkl_toko'
      AND TABLE_NAME = '$this->tbl' AND 
      ORDINAL_POSITION = $pos;"
    );
  }
}