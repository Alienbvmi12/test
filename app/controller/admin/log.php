<?php
class Log extends Alien_Core_Controller
{
  private $none;
  public function __construct()
  {
    parent::__construct();
    $this->setTheme('front');
    $this->load('c_log_model', 'tbl_log');
    $this->lib("sene_json_engine", "json");
  }
  public function index()
  {
    if ($this->isAuth()) {
      $data = array();
      $this->setUpHeader(
        "Log History", //title
        "Pengelolaan histori log", //descriptions
        "Murni alien toko histori log", //keyword
        "Muhammad Rayhan Fathurrakhman" //author
      );

      $data['sess'] = $this->getKey();
      $data['log'] = json_encode($this->tbl_log->query("select log.id as id, aktivitas, waktu, user.nama as nama, detail from log join user on user.id=log.id_user"));


      $this->putThemeContent("page/b_admin/histori_log", $data); //pass data to view
      $this->putJsReady("page/b_admin/bottom/histori_log", $data); //pass data to view
      $this->loadLayout("layout1", $data);
      $this->render();
    }
  }

  public function getLogByDate($date)
  {
    if (isset($date)) {
      $data = array();
      $data['status'] = 200;
      $data['message'] = 'request success';
      $data['data'] = $this->tbl_log->query("select log.id as id, aktivitas, waktu, user.nama as nama, if(detail is null, '-', detail) as detail from log join user on user.id=log.id_user where date(log.waktu)='$date'");
      $this->json->out($data);
    } else {
      $data = array();
      $data['status'] = 800;
      $data['message'] = 'invalid Params';
      $this->json->out($data);
    }
  }
}
