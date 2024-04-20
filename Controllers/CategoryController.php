<?php
require_once 'Config/App/Controller.php';
class CategoryController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->views->getView($this, 'index');
    }


    public function dataList()
    {
        $data = $this->model->getAllCategories();
        //JSON_UNESCAPED_UNICODE permite que los caracteres especiales Ññ se interpreten correctamente
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function store()
    {
        $name = $_POST['name'];
        $response = $this->model->saveCategory($name);
        $response['msg'] = $response['ok']
            ?  'Categoria guardada correctamente'
            : 'No se pudo guardar la categoria';
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function edit(int $id)
    {
        $response = $this->model->getCategoryUsingId($id);
        echo json_encode($response);
        die();
    }

    public function update(int $id)
    {
        $name = $_POST['name'];
        $response = $this->model->updateCategory($name, $id);
        $response['msg'] = $response['ok']
            ?  'La categoria fue actualizada correctamente'
            : 'La categoria no se pudo actualizar';

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    public function destroy(int $id)
    {
        $response = $this->model->deleteCategory($id);
        $response['msg'] = $response['ok'] ? 'Categoria eliminada correctamente' : 'No se pudo eliminar la categoria';
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}
