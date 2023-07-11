<?php
class Alien_Core_Controller extends SENE_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->setTheme('front');
    }
    /* protected function __flash($message = '', $type = 'info')
    {
        $s = $this->getKey();
        if (!is_object($s)) $s = new stdClass();
        if (!isset($s->flash)) $s->flash = '';
        if (strlen($message) > 0) {
            $s->flash = $message;
        }
        $this->setKey($s);
        return $s;
    }
    protected function __flashClear()
    {
        $s = $this->getKey();
        if (!is_object($s)) $s = new stdClass();
        if (!isset($s->flash)) $s->flash = '';
        $s->flash = '';
        $this->setKey($s);
        return $s;
    } */

    // untuk verifikasi login di auth page

    public function isAuth()
    {
        $data = array();
        $data['sess'] = $this->getKey();
        if (!isset($data['sess']->user->id)) {
            redir(base_url('/auth/login'));
            return false;
        } else {
            return true;
        }
    }

    //Untuk verifikasi login di login page

    public function isGuest()
    {
        $data = array();
        $data['sess'] = $this->getKey();
        if (isset($data['sess']->user->id)) {
            redir(base_url('/home'));
            return false;
        } else {
            return true;
        }
    }

    public function timestamp()
    {
        $currentTimestamp = time();
        $currentDateTime = date('Y-m-d H:i:s', $currentTimestamp);
        return $currentDateTime;
    }

    public function userTypeFilter($type)
    {
        // 0 for admin, 1 for gudang, and 2 for kasir
        $user = $this->getKey()->user;
        if ($user->tipe_user != $type) {
            redir(base_url());
        }
    }

    public function validate($data, $context, $model, $purpose,  $rules)
    {
        foreach ($rules as $key => $value) {
            $param = $data[$key];
            foreach ($value as $rule) {
                $tmp = explode(':', $rule);
                if ($tmp[0] === 'required') {
                    $space = 0;
                    foreach (str_split((string)$param) as $u) {
                        if ($u == ' ') $space++;
                    }
                    if (strlen((string)$param) === 0 or strlen((string)$param) === $space) {
                        $splitKey = explode('_', $key);
                        if ($splitKey[0] == 'id') {
                            if (isset($splitKey[1])) {
                                $key = $splitKey[1];
                            }
                        }
                        $data = array();
                        $data['status'] = 200;
                        $data['type'] = false;
                        $data['message'] = $key . ' wajib diisi';
                        $context->json->out($data);
                        die;
                    }
                }
                if ($tmp[0] === 'max') {
                    if (strlen((string)$param) > $tmp[1]) {
                        $splitKey = explode('_', $key);
                        if ($splitKey[0] == 'id') {
                            if (isset($splitKey[1])) {
                                $key = $splitKey[1];
                            }
                        }
                        $data = array();
                        $data['status'] = 200;
                        $data['type'] = false;
                        $data['message'] = 'Panjang karakter "' . $key . '" tidak boleh lebih dari ' . $tmp[1];
                        $context->json->out($data);
                        die;
                    }
                }
                if ($tmp[0] === 'min') {
                    if (strlen((string)$param) < $tmp[1]) {
                        $splitKey = explode('_', $key);
                        if ($splitKey[0] == 'id') {
                            if (isset($splitKey[1])) {
                                $key = $splitKey[1];
                            }
                        }
                        $data = array();
                        $data['status'] = 200;
                        $data['type'] = false;
                        $data['message'] = 'Panjang karakter "' . $key . '" tidak boleh kurang dari ' . $tmp[1];
                        $context->json->out($data);
                        die;
                    }
                }
                if ($tmp[0] === 'unique') {
                    $sql = '';
                    if ($purpose === 'update') {
                        $sql = "select count(*) as count from {$model->tbl} where $key='$param' and id!='$data[id]'";
                    } else {
                        $sql = "select count(*) as count from {$model->tbl} where $key='$param'";
                    }
                    $checkTbl = (int) $model->query($sql)[0]->count;
                    if ($checkTbl > 0) {
                        $splitKey = explode('_', $key);
                        if ($splitKey[0] == 'id') {
                            if (isset($splitKey[1])) {
                                $key = $splitKey[1];
                            }
                        }
                        $data = array();
                        $data['status'] = 200;
                        $data['type'] = false;
                        $data['message'] = $key . ' tidak boleh sama dengan ' . $key . ' yang lain';
                        $context->json->out($data);
                        die;
                    }
                }
            }
        }
    }

    public function index()
    {
    }
}
