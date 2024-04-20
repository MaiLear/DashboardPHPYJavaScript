<?php
require_once 'Config/App/Controller.php';
class MeasureController extends Controller{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $this->views->getView($this,'index');
    }

    public function dataList()
    {
        $data = $this->model->getAllMeasures();
        //JSON_UNESCAPED_UNICODE permite que los caracteres especiales Ññ se interpreten correctamente
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function store()
    {
        $full_name = $_POST['full_name'];
        $short_name = $_POST['short_name'];
      
        $response = $this->model->savemeasure($full_name,$short_name);
        $response['msg'] = $response['ok']
            ?  'Medida guardada correctamente'
            : 'No se pudo guardar la medida';
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function edit(int $id)
    {
        $response = $this->model->getMeasureUsingId($id);
        echo json_encode($response);
        die();
    }

    public function update(int $id)
    {
        $full_name = $_POST['full_name'];
        $short_name = $_POST['short_name'];
        $response = $this->model->updateMeasure($full_name,$short_name, $id);
        $response['msg'] = $response['ok']
            ?  'La medida fue actualizadoa correctamente'
            : 'La medida no se pudo actualizar';

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    public function destroy(int $id)
    {
        $response = $this->model->deleteMeasure($id);
        $response['msg'] = $response['ok'] ? 'Medida eliminada correctamente' : 'No se pudo eliminar la medida';
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}