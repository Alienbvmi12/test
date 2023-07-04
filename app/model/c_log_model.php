<?php
class C_Log_Model extends Alien_Core_Model
{
    public function __construct()
    {
        $this->tbl = "log";
        parent::__construct();
    }
}
