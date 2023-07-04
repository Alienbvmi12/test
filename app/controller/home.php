<?php
class Home extends Alien_Core_Controller
{
  private $none;
  public function __construct()
  {
    parent::__construct();
    $this->setTheme('front');
  }
  public function index()
  {
    if ($this->isAuth()) {
      $data = array();
      $this->setUpHeader(
        "Welcome to Alien_bvmi12", //title
        "Please register before you can login.", //descriptions
        "Alien_bvmi12", //keyword
        "Muhammad Rayhan Fathurrakhman" //author
      );

      $noun = "user";
      $role = [
        'Admin',
        'Gudang',
        'Kasir'
      ];

      $data['sess'] = $this->getKey();
      $data['hello'] = "Welcome " . $role[$data['sess']->user->tipe_user] . " " . $data['sess']->user->nama;

      $this->putThemeContent("page/a_home/home", $data); //pass data to view
      $this->putJsContent("page/a_home/home_bottom", $data); //pass data to view
      $this->loadLayout("layout1", $data);
      $this->render();
    }
  }
}
