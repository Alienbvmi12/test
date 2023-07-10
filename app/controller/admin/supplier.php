<?php
class Supplier extends Alien_Core_Controller
{
    private $none;
    public function __construct()
    {
        parent::__construct();
        $this->setTheme('front');
        $this->load('b_user_model', 'tbl_user');
        $this->load('b_supplier_model', 'tbl_supplier');
        $this->load('c_log_model', 'tbl_log');
        $this->lib("sene_json_engine", "json");
    }
    public function index()
    {
        if ($this->isAuth()) {
            $this->userTypeFilter(0);
            $data = array();
            $this->setUpHeader(
                "Kelola Supplier", //title
                "Pengelolaan Supplier", //descriptions
                "Murni alien toko pengelolaan toko", //keyword
                "Muhammad Rayhan Fathurrakhman" //author
            );

            $data['sess'] = $this->getKey();

            $this->putThemeContent("page/b_admin/kelola_supplier", $data); //pass data to view
            $this->putJsReady("page/b_admin/bottom/kelola_supplier.bottom", $data); //pass data to view
            $this->loadLayout("layout1", $data);
            $this->render();
        }
    }
    public function detail($id)
    {
        if ($this->isAuth()) {
            $data = array();
            $this->setUpHeader(
                "User detail", //title
                "User", //descriptions
                "Murni alien toko user", //keyword
                "Muhammad Rayhan Fathurrakhman" //author
            );

            $data['sess'] = $this->getKey();
            $data['data'] = $this->tbl_supplier->getById($id);

            $this->putThemeContent("page/detail", $data); //pass data to view
            $this->loadLayout("layout1.nonav", $data);
            $this->render();
        }
    }

    public function create()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $this->validate($request, $this, $this->tbl_supplier, 'create', [
            'nama_supplier' => ['required', 'max:50'],
            'alamat' => ['required'],
            'telepon' => ['required', 'max:50']
        ]);
        try {
            $create = $this->tbl_supplier->create($request);
            $this->tbl_log->create([
                'waktu' => $this->timestamp(),
                'aktivitas' => 'create',
                'id_user' => $this->getKey()->user->id,
                'detail' => 'Membuat suppplier baru, supplier.id: ' . $create
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
        $column = $this->tbl_supplier->getColumnName($_GET['order'][0]['column'])[0]->COLUMN_NAME;
        $dir = $_GET['order'][0]['dir'];
        if ($dir === 'asc') {
            $dir = '';
        }
        $data['data'] = $this->tbl_supplier->query("
            select * from {$this->tbl_supplier->tbl} 
            where (nama_supplier like '%$search%' or id like '%$search%' or
            telepon like '%$search%' or alamat like '%$search%') 
            and deleted_at is null 
            order by $column $dir 
            limit $start,$length");
        $count = $this->tbl_supplier->countAll();
        $data['recordsTotal'] = $count;
        $data['recordsFiltered'] = $count;
        $this->json->out($data);
    }

    public function update()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $this->validate($request, $this, $this->tbl_supplier, 'update', [
            'id' => ['required'],
            'nama_supplier' => ['required', 'max:50'],
            'alamat' => ['required'],
            'telepon' => ['required', 'max:50']
        ]);
        try {
            $this->tbl_supplier->update($request['id'], $request);
            $this->tbl_log->create([
                'waktu' => $this->timestamp(),
                'aktivitas' => 'update',
                'id_user' => $this->getKey()->user->id,
                'detail' => 'Mengubah data supplier, supplier.id: ' . $request['id']
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
            $this->tbl_supplier->moveToTrash($request['id']);
            $this->tbl_log->create([
                'waktu' => $this->timestamp(),
                'aktivitas' => 'delete',
                'id_user' => $this->getKey()->user->id,
                'detail' => 'Menghapus data supplier, supplier.id: ' . $request['id']
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
