<?php
/**
 * Controller class for throw 404 response code
 *
 * @package SemeFramework
 * @since SemeFramework 1.0
 *
 * @codeCoverageIgnore
 */
class NotFound extends SENE_Controller
{
    private $none;
    public function __construct()
    {
        parent::__construct();
        $this->setTheme('front');
    }
    public function index()
    {
        $data = array();
        header("HTTP/1.0 404 Not Found");
        $this->setTitle('Notfound - Error 404');
        $this->loadLayout("notfound",$data);
        $this->render();
    }
}