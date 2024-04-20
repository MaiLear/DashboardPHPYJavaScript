<?php
require_once 'Config/App/Controller.php';
require_once 'Config/Config.php';

class HomeController extends Controller
{

    public function __construct()
    {
        session_start();
        if (!empty($_SESSION['active'])) {
            header('Location:' . BASEROUTE . '/User');
        }

        parent::__construct();
    }

    public function index()
    {
        $this->views->getView($this, 'index');
    }
}
