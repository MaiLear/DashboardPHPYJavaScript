<?php
require_once 'Config/App/Views.php';

class Controller
{

    protected $views, $model;
    public function __construct()
    {
        $this->loadModels();
        $this->views = new Views();
    }
    public function loadModels()
    {
        //get_class recibe como parametro un objeto y devulve el nombre de la clase el objeto
        $model = get_class($this);
        $model = str_replace('Controller', '', $model);
        $routeModel = "Models/$model" . ".php";
        if (file_exists($routeModel)) {
            require_once $routeModel;
            $this->model = new $model();
        }
    }
}
