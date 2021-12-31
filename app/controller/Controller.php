<?php

namespace App\Controller;

use Nl_controller;

use System\Core\DB;

class Controller extends NL_Controller{
    public DB $db;
    public function __construct()
    {
        $this->db = new DB();
    }
}