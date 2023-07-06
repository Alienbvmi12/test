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
        }
        else{
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
        }
        else{
            return true;
        }
    }

    public function timestamp()
    {
        $currentTimestamp = time();
        $currentDateTime = date('Y-m-d H:i:s', $currentTimestamp);
        return $currentDateTime;
    }

    public function userTypeFilter($type){
        // 0 for admin, 1 for gudang, and 2 for kasir
        $user = $this->getKey()->user;
        if($user->tipe_user != $type){
            redir(base_url());
        }
    }

    public function index()
    {
    }
}
