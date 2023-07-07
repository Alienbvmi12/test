<?php
class Stok extends Alien_Core_Controller
{
  private $none;
  public function __construct()
  {
    parent::__construct();
    $this->setTheme('front');
    $this->load('c_log_stok_model', 'tbl_stok');
    $this->load('c_log_model', 'tbl_log');
    $this->load('b_barang_model', 'tbl_barang');
    $this->lib("sene_json_engine", "json");
  }
  public function index()
  {
    if ($this->isAuth()) {
      $this->userTypeFilter(1);
      $data = array();
      $this->setUpHeader(
        "Log History", //title
        "Pengelolaan histori log", //descriptions
        "Murni alien toko histori log", //keyword
        "Muhammad Rayhan Fathurrakhman" //author
      );

      $data['sess'] = $this->getKey();
      $data['barang'] = $this->tbl_barang->getAll();

      $this->putThemeContent("page/b_gudang/log_stok", $data); //pass data to view
      $this->putJsReady("page/b_gudang/bottom/log_stok.bottom", $data); //pass data to view
      $this->loadLayout("layout1", $data);
      $this->render();
    }
  }

  public function getStokByBarang($barang)
  {
    if (isset($barang)) {
      $data = array();
      $data['status'] = 200;
      $data['message'] = 'request success';
      $search = $_GET['search']['value'];
      $order = $_GET['order'];
      $start = ((int)$_GET['start']);
      $length = $_GET['length'];
      $column = $this->tbl_stok->getColumnName($_GET['order'][0]['column'])[0]->COLUMN_NAME;
      $dir = $_GET['order'][0]['dir'];
      if ($dir === 'asc') {
        $dir = '';
      }
      $data['data'] = $this->tbl_stok->query("
          select 
            {$this->tbl_stok->tbl}.id as id,
            {$this->tbl_barang->tbl}.nama_barang as barang,
            {$this->tbl_stok->tbl}.jumlah_barang as jumlah_barang,
            {$this->tbl_stok->tbl}.stok as stok,
            {$this->tbl_stok->tbl}.tanggal_stok_masuk as tanggal_stok_masuk,
            {$this->tbl_stok->tbl}.tanggal_stok_keluar as tanggal_stok_keluar,
            {$this->tbl_stok->tbl}.expired_date as expired_date 
          from
            {$this->tbl_stok->tbl},
            {$this->tbl_barang->tbl} 
          where 
            (
              {$this->tbl_stok->tbl}.id like '%$search%' or 
              {$this->tbl_barang->tbl}.nama_barang like '%$search%' or 
              {$this->tbl_stok->tbl}.jumlah_barang like '%$search%' or 
              {$this->tbl_stok->tbl}.stok like '%$search%' or 
              {$this->tbl_stok->tbl}.tanggal_stok_masuk like '%$search%' or 
              {$this->tbl_stok->tbl}.tanggal_stok_keluar like '%$search%' or 
              {$this->tbl_stok->tbl}.expired_date like '%$search%'
            ) 
          and {$this->tbl_stok->tbl}.id_barang={$this->tbl_barang->tbl}.id 
          and {$this->tbl_stok->tbl}.id_barang='$barang' 
          order by $column $dir 
          limit $start,$length");
      $count = (int) $this->tbl_stok->query("select count(id) as count from {$this->tbl_stok->tbl} where id_barang='$barang'")[0]->count;
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
        $this->tbl_stok->query("delete from {$this->tbl_stok->tbl} where id in $dataToDel");
        $this->tbl_log->create([
          'waktu' => $this->timestamp(),
          'aktivitas' => 'delete',
          'id_user' => $this->getKey()->user->id,
          'detail' => 'Menghapus histori stok, stok.id: ' . implode(', ', $request['data'])
        ]);
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
        $this->tbl_stok->query("delete from {$this->tbl_stok->tbl} where id_barang='$request[id_barang]'");
        $this->tbl_log->create([
          'waktu' => $this->timestamp(),
          'aktivitas' => 'massive delete',
          'id_user' => $this->getKey()->user->id,
          'detail' => 'Menghapus histori stok dengan stok.id_barang: ' . $request['id_barang']
        ]);
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
    }
  }
}
