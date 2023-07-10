<?php
class User extends Alien_Core_Controller
{
    private $none;
    public function __construct()
    {
        parent::__construct();
        $this->setTheme('front');
        $this->load('b_user_model', 'tbl_user');
        $this->load('c_log_model', 'tbl_log');
        $this->lib("sene_json_engine", "json");
    }
    public function index()
    {
        if ($this->isAuth()) {
            $this->userTypeFilter(0);
            $data = array();
            $this->setUpHeader(
                "Kelola User", //title
                "Pengelolaan User", //descriptions
                "Murni alien toko pengelolaan toko", //keyword
                "Muhammad Rayhan Fathurrakhman" //author
            );

            $data['sess'] = $this->getKey();

            $this->putThemeContent("page/b_admin/kelola_user", $data); //pass data to view
            $this->putJsReady("page/b_admin/bottom/kelola_user.bottom", $data); //pass data to view
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

            $role = array(
                'admin',
                'gudang',
                'kasir'
            );

            $data['sess'] = $this->getKey();
            $data['data'] = $this->tbl_user->getById($id);
            $data['data']->tipe_user = $role[$data['data']->tipe_user];
            $data['data']->password = "xxxxxxxxxxx";

            $this->putThemeContent("page/detail", $data); //pass data to view
            $this->loadLayout("layout1.nonav", $data);
            $this->render();
        }
    }

    public function create()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $this->validate($request, $this, $this->tbl_user, 'create', [
            'tipe_user' => ['required'],
            'nama' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'min:6', 'unique'],
            'telepon' => ['required', 'max:50', 'min:6', 'unique'],
            'username' => ['required', 'max:50', 'min:3', 'unique'],
            'password' => ['required', 'max:50', 'min:6']
        ]);
        $request['password'] = password_hash($request['password'], PASSWORD_BCRYPT);
        $role = array(
            'admin' => 0,
            'gudang' => 1,
            'kasir' => 2
        );
        $request['tipe_user'] = $role[$request['tipe_user']];
        try {
            $create = $this->tbl_user->create($request);
            $this->tbl_log->create([
                'waktu' => $this->timestamp(),
                'aktivitas' => 'create',
                'id_user' => $this->getKey()->user->id,
                'detail' => 'Membuat user baru, user.id: ' . $create
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
        $column = $this->tbl_user->getColumnName($_GET['order'][0]['column'])[0]->COLUMN_NAME;
        $dir = $_GET['order'][0]['dir'];
        if ($dir === 'asc') {
            $dir = '';
        }
        $data['data'] = $this->tbl_user->query("select id, if(tipe_user = 0, 'admin', 
            if(tipe_user = 1, 'gudang', if(tipe_user = 2, 'kasir', 'unknown'))) 
            as tipe_user, nama, email, telepon, username 
            from {$this->tbl_user->tbl} 
            where (tipe_user like '%$search%' or id like '%$search%' or
            nama like '%$search%' or email like '%$search%' or
            telepon like '%$search%' or username like '%$search%') 
            and deleted_at is null 
            order by $column $dir 
            limit $start,$length");
        $count = $this->tbl_user->countAll();
        $data['recordsTotal'] = $count;
        $data['recordsFiltered'] = $count;
        $this->json->out($data);
    }

    public function update()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        $this->validate($request, $this, $this->tbl_user, 'update', [
            'id' => ['required'],
            'tipe_user' => ['required'],
            'nama' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'min:6', 'unique'],
            'telepon' => ['required', 'max:50', 'min:6', 'unique'],
            'username' => ['required', 'max:50', 'min:3', 'unique'],
            'password' => ['max:50']
        ]);
        if ($request['password'] == '' or $request['password'] == null) {
            unset($request['password']);
        } else {
            $request['password'] = password_hash($request['password'], PASSWORD_BCRYPT);
        }
        $role = array(
            'admin' => 0,
            'gudang' => 1,
            'kasir' => 2
        );
        $request['tipe_user'] = $role[$request['tipe_user']];
        try {
            $this->tbl_user->update($request['id'], $request);
            $this->tbl_log->create([
                'waktu' => $this->timestamp(),
                'aktivitas' => 'update',
                'id_user' => $this->getKey()->user->id,
                'detail' => 'Mengubah data user, user.id: ' . $request['id']
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
    public function gantiPassword()
    {
        $request = json_decode(file_get_contents('php://input'), true);
        try {
            if ($request['type'] === "ganti") {
                if ($request['password_baru'] != $request['konfirmasi_password_baru']) {
                    $data['status'] = 200;
                    $data['type'] = false;
                    $data['message'] = 'Password tidak sama';
                } else {
                    $this->tbl_user->update($request['id'], [
                        'password' => password_hash($request['password_baru'], PASSWORD_BCRYPT)
                    ]);
                    $this->tbl_log->create([
                        'waktu' => $this->timestamp(),
                        'aktivitas' => 'update',
                        'id_user' => $this->getKey()->user->id,
                        'detail' => 'Mengganti password, user.id: ' . $request['id']
                    ]);
                }
            } elseif ($request['type'] == "reset") {
                $this->tbl_user->update($request['id'], [
                    'password' => password_hash($request['password_baru'], PASSWORD_BCRYPT)
                ]);
                $this->tbl_log->create([
                    'waktu' => $this->timestamp(),
                    'aktivitas' => 'update',
                    'id_user' => $this->getKey()->user->id,
                    'detail' => 'Mengganti password, user.id: ' . $request['id']
                ]);
            }
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
            $this->tbl_log->query("delete from {$this->tbl_log->tbl} where id_user='$request[id]'");
            $this->tbl_user->moveToTrash($request['id']);
            $this->tbl_log->create([
                'waktu' => $this->timestamp(),
                'aktivitas' => 'delete',
                'id_user' => $this->getKey()->user->id,
                'detail' => 'Menghapus data user, user.id: ' . $request['id']
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
