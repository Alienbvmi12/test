<?php
class Barang extends Alien_Core_Controller
{
    private $none;
    public function __construct()
    {
        parent::__construct();
        $this->setTheme('front');
        $this->load('b_barang_model', 'tbl_barang');
        $this->load('b_supplier_model', 'tbl_supplier');
        $this->load('c_log_model', 'tbl_log');
        $this->load('c_kategori_model', 'tbl_kategori');
        $this->load('c_satuan_model', 'tbl_satuan');
        $this->load('c_log_stok_model', 'tbl_log_stok');
        $this->lib("sene_json_engine", "json");
    }
    public function index()
    {
        if ($this->isAuth()) {
            $this->userTypeFilter(1);
            $data = array();
            $this->setUpHeader(
                "Kelola Barang", //title
                "Pengelolaan Barang", //descriptions
                "Murni alien toko pengelolaan barang", //keyword
                "Muhammad Rayhan Fathurrakhman" //author
            );

            $data['sess'] = $this->getKey();
            $data['kategori'] = $this->tbl_kategori->getAll();
            $data['satuan'] = $this->tbl_satuan->getAll();
            $data['supplier'] = $this->tbl_supplier->getAll();

            $this->putThemeContent("page/b_gudang/kelola_barang", $data); //pass data to view
            $this->putJsReady("page/b_gudang/bottom/kelola_barang.bottom", $data); //pass data to view
            $this->loadLayout("layout1", $data);
            $this->render();
        }
    }
    public function detail($id)
    {
        if ($this->isAuth()) {
            $data = array();
            $this->setUpHeader(
                "Barang detail", //title
                "Barang", //descriptions
                "Murni alien toko barang", //keyword
                "Muhammad Rayhan Fathurrakhman" //author
            );

            $data['sess'] = $this->getKey();
            $data['data'] =  $this->tbl_barang->query("
            select 
                {$this->tbl_barang->tbl}.id as id,
                {$this->tbl_kategori->tbl}.nama_kategori as kategori,
                {$this->tbl_satuan->tbl}.nama_satuan as satuan,
                {$this->tbl_barang->tbl}.kode_barang as kode_barang,
                {$this->tbl_barang->tbl}.nama_barang as nama_barang,
                {$this->tbl_barang->tbl}.jumlah_barang as jumlah_barang,
                {$this->tbl_barang->tbl}.stok as stok,
                {$this->tbl_barang->tbl}.harga_satuan as harga_satuan,
                {$this->tbl_supplier->tbl}.nama_supplier as supplier,
                {$this->tbl_barang->tbl}.tanggal_masuk as tanggal_masuk,
                {$this->tbl_barang->tbl}.expired_date as expired_date 
            from 
                {$this->tbl_barang->tbl},
                {$this->tbl_kategori->tbl},
                {$this->tbl_satuan->tbl} ,
                {$this->tbl_supplier->tbl}
            where 
                {$this->tbl_barang->tbl}.id_kategori = {$this->tbl_kategori->tbl}.id and 
                {$this->tbl_barang->tbl}.id_satuan = {$this->tbl_satuan->tbl}.id and 
                {$this->tbl_barang->tbl}.id_supplier = {$this->tbl_supplier->tbl}.id and 
                {$this->tbl_barang->tbl}.id = '$id'
            ")[0];

            $data['data']->harga_satuan = "Rp. " . number_format((int) $data['data']->harga_satuan, 2, '.', ',');

            $this->putThemeContent("page/detail", $data); //pass data to view
            $this->loadLayout("layout1.nonav", $data);
            $this->render();
        }
    }

    public function dataForEdit($id){
        $data = $this->tbl_barang->query("
        select 
            {$this->tbl_barang->tbl}.id as id,
            {$this->tbl_kategori->tbl}.nama_kategori as kategori,
            {$this->tbl_kategori->tbl}.id as id_kategori,
            {$this->tbl_satuan->tbl}.nama_satuan as satuan,
            {$this->tbl_satuan->tbl}.id as id_satuan,
            {$this->tbl_barang->tbl}.kode_barang as kode_barang,
            {$this->tbl_barang->tbl}.nama_barang as nama_barang,
            {$this->tbl_barang->tbl}.jumlah_barang as jumlah_barang,
            {$this->tbl_barang->tbl}.stok as stok,
            {$this->tbl_barang->tbl}.harga_satuan as harga_satuan,
            {$this->tbl_supplier->tbl}.nama_supplier as supplier,
            {$this->tbl_supplier->tbl}.id as id_supplier,
            {$this->tbl_barang->tbl}.tanggal_masuk as tanggal_masuk,
            {$this->tbl_barang->tbl}.expired_date as expired_date 
        from 
            {$this->tbl_barang->tbl},
            {$this->tbl_kategori->tbl},
            {$this->tbl_satuan->tbl} ,
            {$this->tbl_supplier->tbl}
        where 
            {$this->tbl_barang->tbl}.id_kategori = {$this->tbl_kategori->tbl}.id and 
            {$this->tbl_barang->tbl}.id_satuan = {$this->tbl_satuan->tbl}.id and 
            {$this->tbl_barang->tbl}.id_supplier = {$this->tbl_supplier->tbl}.id and 
            {$this->tbl_barang->tbl}.id = '$id'
        ")[0];

        $this->json->out($data);
    }

    public function create()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $this->validate($request, $this, $this->tbl_barang, 'create', [
            'kode_barang' => ['unique', 'required', 'max:50'],
            'nama_barang' => ['required', 'max:255'],
            'id_kategori' => ['required'],
            'id_satuan' => ['required'],
            'jumlah_barang' => ['required', 'max:11'],
            'stok' => ['required', 'max:11'],
            'harga_satuan' => ['required', 'max:20'],
            'tanggal_masuk' => ['required'],
            'expired_date' => ['required']
        ]);
        try {
            $create = $this->tbl_barang->create($request);
            $this->tbl_log->create([
                'waktu' => $this->timestamp(),
                'aktivitas' => 'create',
                'id_user' => $this->getKey()->user->id,
                'detail' => 'Menambah barang baru, barang.id: ' . $create
            ]);
            $data = array();
            $data['status'] = 200;
            $data['type'] = true;
            $data['message'] = 'Update Success';
            $this->json->out($data);
        } catch (Exception $e) {
            $data['status'] = 500;
            $data['message'] = 'Error';
            $data['exception'] = $e;
            $this->json->out($data);
        }
    }

    public function read()
    {
        $data = array();
        $data['status'] = 200;
        $data['message'] = 'request success';
        $search = $_GET['search']['value'];
        $order = $_GET['order'];
        $start = ((int)$_GET['start']);
        $length = $_GET['length'];
        $column = $this->tbl_barang->getColumnName($_GET['order'][0]['column'])[0]->COLUMN_NAME;
        $dir = $_GET['order'][0]['dir'];
        if ($dir === 'asc') {
            $dir = '';
        }
        $data['data'] = $this->tbl_barang->query("
            select 
                {$this->tbl_barang->tbl}.id as id,
                {$this->tbl_kategori->tbl}.nama_kategori as kategori,
                {$this->tbl_satuan->tbl}.nama_satuan as satuan,
                {$this->tbl_supplier->tbl}.nama_supplier as supplier,
                {$this->tbl_barang->tbl}.kode_barang as kode_barang,
                {$this->tbl_barang->tbl}.nama_barang as nama_barang,
                {$this->tbl_barang->tbl}.jumlah_barang as jumlah_barang,
                {$this->tbl_barang->tbl}.stok as stok,
                {$this->tbl_barang->tbl}.harga_satuan as harga_satuan,
                {$this->tbl_barang->tbl}.tanggal_masuk as tanggal_masuk,
                {$this->tbl_barang->tbl}.expired_date as expired_date
            from 
                {$this->tbl_barang->tbl},
                {$this->tbl_kategori->tbl},
                {$this->tbl_satuan->tbl},
                {$this->tbl_supplier->tbl}
            where 
                {$this->tbl_barang->tbl}.id_kategori = {$this->tbl_kategori->tbl}.id and 
                {$this->tbl_barang->tbl}.id_satuan = {$this->tbl_satuan->tbl}.id and 
                {$this->tbl_barang->tbl}.id_supplier = {$this->tbl_supplier->tbl}.id and 
                (
                    {$this->tbl_barang->tbl}.id like '%$search%' or
                    {$this->tbl_kategori->tbl}.nama_kategori like '%$search%' or
                    {$this->tbl_satuan->tbl}.nama_satuan like '%$search%' or 
                    {$this->tbl_supplier->tbl}.nama_supplier like '%$search%' or 
                    {$this->tbl_barang->tbl}.kode_barang like '%$search%' or 
                    {$this->tbl_barang->tbl}.nama_barang like '%$search%' or 
                    {$this->tbl_barang->tbl}.jumlah_barang like '%$search%' or 
                    {$this->tbl_barang->tbl}.stok like '%$search%' or 
                    {$this->tbl_barang->tbl}.harga_satuan like '%$search%' or 
                    {$this->tbl_barang->tbl}.tanggal_masuk like '%$search%' or 
                    {$this->tbl_barang->tbl}.expired_date like '%$search%'
                ) 
            order by $column $dir 
            limit $start,$length");

        foreach($data['data'] as $dat){
            $dat->sisa_stok = array();
            $dat->sisa_stok['jumlah_barang'] = $dat->jumlah_barang;
            $dat->sisa_stok['stok'] = $dat->stok;
        }
        $count = $this->tbl_barang->countAll();
        $data['recordsTotal'] = $count;
        $data['recordsFiltered'] = $count;
        $this->json->out($data);
    }

    public function update()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $this->validate($request, $this, $this->tbl_barang, 'update', [
            'id' => ['required'],
            'kode_barang' => ['unique', 'required', 'max:50'],
            'nama_barang' => ['required', 'max:255'],
            'id_kategori' => ['required'],
            'id_satuan' => ['required'],
            'jumlah_barang' => ['required', 'max:11'],
            'stok' => ['required', 'max:11'],
            'harga_satuan' => ['required', 'max:20'],
            'tanggal_masuk' => ['required'],
            'expired_date' => ['required']
        ]);
        try {
            $this->tbl_barang->update($request['id'], $request);
            $this->tbl_log->create([
                'waktu' => $this->timestamp(),
                'aktivitas' => 'update',
                'id_user' => $this->getKey()->user->id,
                'detail' => 'Mengubah data barang, barang.id: ' . $request['id']
            ]);
            $data = array();
            $data['status'] = 200;
            $data['type'] = true;
            $data['message'] = 'Update Success';
            $this->json->out($data);
        } catch (Exception $e) {
            $data['status'] = 500;
            $data['message'] = 'Error';
            $data['exception'] = $e;
            $this->json->out($data);
        }
    }

    public function delete()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        try {
            $this->tbl_barang->delete($request['id']);
            $this->tbl_log->create([
                'waktu' => $this->timestamp(),
                'aktivitas' => 'delete',
                'id_user' => $this->getKey()->user->id,
                'detail' => 'Menghapus data barang, barang.id: ' . $request['id']
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

    public function addStock()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        try {
            $barang = $this->tbl_barang->getById($request['id']);
            $this->tbl_barang->query(
                "update {$this->tbl_barang->tbl} 
                set 
                    jumlah_barang=$request[stok],
                    stok=stok + $request[stok],
                    tanggal_masuk='".date('Y-m-d', time())."',
                    expired_date='$request[expired_date]'
                where 
                    id='$request[id]'"
                );
            $this->tbl_log->create([
                'waktu' => $this->timestamp(),
                'aktivitas' => 'put',
                'id_user' => $this->getKey()->user->id,
                'detail' => 'Menambah Stok Barang, stok '.$barang->stok.' -> '.((int)$barang->stok) + ((int)$request['stok']).' barang.id: ' . $request['id']
            ]);
            $this->tbl_log_stok->create([
                'id_barang' => $barang->id,
                'jumlah_barang' => $barang->jumlah_barang,
                'stok' => $barang->stok,
                'tanggal_stok_masuk' => $barang->tanggal_masuk,
                'tanggal_stok_keluar' => date('Y-m-d', time()),
                'expired_date' => $barang->expired_date
            ]);
            $data = array();
            $data['status'] = 200;
            $data['message'] = 'Put Success';
            $this->json->out($data);
        } catch (Exception $e) {
            $data['status'] = 500;
            $data['message'] = 'Error';
            $data['exception'] = $e;
            $this->json->out($data);
        }
    }
}
