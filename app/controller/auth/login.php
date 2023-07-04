<?php
class Login extends Alien_Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->setTheme('front');
        $this->load('b_user_model', 'bum');
        $this->load('c_log_model', 'tb_log');
    }
    public function index()
    {
        $this->isGuest();

        $data = array();
        $data['sess'] = flash();

        $this->setUpHeader(
            "Login", //title
            "Please register before you can login.", //descriptions
            "Murni Alien Toko", //keyword
            "Muhammad Rayhan Fathurrakhman" //author
          );

        $this->putThemeContent("page/a_login/index", $data); //pass data to view
        $this->loadLayout("layout1.nonav", $data);
        $this->render();
    }
    public function proses()
    {
        $this->cred = $this->input->post('cred');
        $this->password = $this->input->post('password');

        $cred = $this->cred;
        $password = $this->password;

        if (strlen($cred) >= 1 && strlen($password) >= 1) {
            $bum = $this->bum->getByCredential($cred);
            if (isset($bum[0])) {

                //update password if still md5
                $bum = $bum[0];
                $this->password = password_hash($this->password, PASSWORD_BCRYPT);
                if (md5($password) == $bum->password) {
                    $du = array();
                    $du['password'] = password_hash($password, PASSWORD_BCRYPT);
                    $this->bum->update($bum->id, $du);
                    $password = $du['password'];
                    $bum->password = $password;
                }

                if (password_verify($password, $bum->password)) {
                    //set to session
                    $sess = $this->getKey();
                    if (!is_object($sess)) $sess = new stdClass();
                    if (!isset($sess->user)) $sess->user = new stdClass();
                    $sess->user = $bum;
                    $this->setKey($sess);
                    $this->tb_log->set([
                        'waktu' => $this->timestamp(),
                        'aktivitas' => 'login',
                        'id_user' => $sess->user->id,
                    ]);

                    // redirect to dashboard
                    redir(base_url('/home'), 1);
                    return;
                } else {
                    flash('Invalid username/email/phone or password');
                    redir(base_url('/auth/login'), 1);
                }
            } else {
                flash('Invalid username/email/phone or password');
                redir(base_url('/auth/login'), 1);
            }
        } else {
            flash('Invalid username/email/phone or password');
            redir(base_url('/auth/login'), 1);
        }
    }

    public function logout()
    {
        $data = array();
        $sess = $this->getKey();
        $this->tb_log->set([
            'waktu' => $this->timestamp(),
            'aktivitas' => 'logout',
            'id_user' => $sess->user->id,
        ]);
        if (!is_object($sess)) {
            $sess = new stdClass();
        }
        $sess->user = new stdClass();
        $this->setKey($sess);
        redir(base_url("/auth/login"), 0);
    }
}