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
      $search = $_GET['search']['value'];
      $order = $_GET['order'];
      $start = ((int)$_GET['start']);
      $length = $_GET['length'];
      $column = $this->tbl_log->getColumnName($_GET['order'][0]['column'])[0]->COLUMN_NAME;
      $dir = $_GET['order'][0]['dir'];
      if($dir === 'asc'){
        $dir = '';
      }
      $data['data'] = $this->tbl_log->query("select log.id as id, aktivitas, waktu, user.nama as nama,
          if(detail is null, '-', detail) as detail 
          from log join user on user.id=log.id_user 
          where (log.id like '%$search%' or aktivitas like '%$search%' or
          waktu like '%$search%' or user.nama like '%$search%' or
          detail like '%$search%') 
          and date(log.waktu)='$date' 
          order by $column $dir 
          limit $start,$length");
      $count = $this->tbl_log->countWhere($date, 'date(waktu)');
      $data['recordsTotal'] = $count;
      $data['recordsFiltered'] = $count;
      $this->json->out($data);
    } else {
      $data = array();
      $data['status'] = 800;
      $data['message'] = 'invalid Params';
      $this->json->out($data);
    }
  }

  public function delete()
  {
    $request = json_decode(file_get_contents('php://input'), true);
    if ($request['type'] !== 'all') {
      $dataToDel = "(";
      for ($i = 0; $i < count($request['data']); $i++) {
        if ($i !== 0) {
          $dataToDel .= "," . $request['data'][$i];
        } else {
          $dataToDel .= $request['data'][$i];
        }
      }
      $dataToDel .= ")";
      try {
        $this->tbl_log->query("delete from log where id in $dataToDel");
        $data = array();
        $data['status'] = 200;
        $data['message'] = 'Delete Success';
        $this->json->out($data);
      } catch (Exception $e) {
        $data['status'] = 500;
        $data['message'] = 'Error';
        $data['exception'] = $e;
        $this->json->out($data);
      }
    } else {
      try {
        $this->tbl_log->query("delete from log where date(waktu)='$request[date]'");
        $data = array();
        $data['status'] = 200;
        $data['message'] = 'Delete Success';
        $data['c'] = $request['date'];
        $this->json->out($data);
      } catch (Exception $e) {
        $data['status'] = 500;
        $data['message'] = 'Error';
        $data['exception'] = $e;
        $this->json->out($data);
      }
    }
  }
}
