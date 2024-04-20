<?php
require_once 'Config/App/Controller.php';
class BoxController extends Controller{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->views->getView($this,'index');
    }

    public function dataList()
    {
        $data = $this->model->getAllBoxs();
        //JSON_UNESCAPED_UNICODE permite que los caracteres especiales Ññ se interpreten correctamente
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function store()
    {
        $box = $_POST['box'];
        $response = $this->model->saveBox($box);
        $response['msg'] = $response['ok']
            ?  'Caja guardada correctamente'
            : 'No se pudo guardar la caja';
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function edit(int $id)
    {
        $response = $this->model->getBoxUsingId($id);
        echo json_encode($response);
        die();
    }

    public function update(int $id)
    {
        $box = $_POST['box'];
        $response = $this->model->updateBox($box, $id);
        $response['msg'] = $response['ok']
            ?  'La caja fue actualizada correctamente'
            : 'La caja no se pudo actualizar';

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    public function destroy(int $id)
    {
        $response = $this->model->deleteBox($id);
        $response['msg'] = $response['ok'] ? 'Caja eliminada correctamente' : 'No se pudo eliminar la caja';
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }

}