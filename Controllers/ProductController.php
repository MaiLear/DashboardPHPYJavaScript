<?php

require_once 'Config/App/Controller.php';
require_once 'Config/Config.php';
class ProductController extends Controller
{


    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = [];
        $data['measures'] = $this->model->getAllMeasures();
        $data['categories'] = $this->model->getAllCategories();
        $this->views->getView($this, 'index', $data);
    }


    public function dataList()
    {
        $data = $this->model->getAllProducts();
        //JSON_UNESCAPED_UNICODE permite que los caracteres especiales Ññ se interpreten correctamente
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function store()
    {
        $code = $_POST['code'];
        $description = $_POST['description'];
        $purchase_price = $_POST['purchase_price'];
        $sale_price = $_POST['sale_price'];
        $quantity = $_POST['quantity'];
        $id_measure = $_POST['id_measure'];
        $id_category = $_POST['id_category'];
        //Recuperando un archivo enviado al servidor
        $image = $_FILES['image'];
        $nameImage = $image['name'];
        $tmpName = $image['tmp_name'];
        $urlDestination = "Assets/img/$nameImage";
        if (empty($nameImage)) {
            $nameImage = "default.png";
        }
        //Mueve la imagen a la ruta especificada, recibe dos parametros el
        //nombre temporal y la ruta de destino
        move_uploaded_file($tmpName, $urlDestination);

        $response = $this->model->saveProduct($code, $description, $purchase_price, $sale_price, $quantity, $id_measure, $id_category, $nameImage);
        $response['msg'] = $response['ok']
            ?  'Producto guardado correctamente'
            : 'No se pudo guardar el producto';
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        // echo json_encode($_POST, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function edit(int $id)
    {
        $response = $this->model->getProductUsingId($id);
        echo json_encode($response);
        die();
    }

    public function update(int $id)
    {
        $code = $_POST['code'];
        $description = $_POST['description'];
        $purchase_price = $_POST['purchase_price'];
        $sale_price = $_POST['sale_price'];
        $quantity = $_POST['quantity'];
        $id_measure = $_POST['id_measure'];
        $id_category = $_POST['id_category'];
        $old_image = explode('/', $_POST['old_image']);
        $name_old_image = end($old_image);
        $image = $_FILES['image'];
        $imageName = $image['name'];
        $tmpName = $image['tmp_name'];
        $urlDestination = "Assets/img/";

        if (empty($tmpName)) {
            $defaultImg =  'default.png';

            if (file_exists($urlDestination . $name_old_image) && $name_old_image != $defaultImg) {

                unlink($urlDestination . $name_old_image);
            }
            $imageName = $defaultImg;
        } else {

            $imageName = $imageName != $name_old_image ? $imageName : $name_old_image;
        }

        move_uploaded_file($tmpName, $urlDestination . $imageName);






        $response = $this->model->updateProduct($code, $description, $purchase_price, $sale_price, $quantity, $id_measure, $id_category, $imageName, $id);
        $response['msg'] = $response['ok']
            ?  'El producto fue actualizadoa correctamente'
            : 'El producto no se pudo actualizar';

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    public function destroy(int $id)
    {
        $response = $this->model->deleteProduct($id);
        $response['msg'] = $response['ok'] ? 'Producto eliminado correctamente' : 'No se pudo eliminar el producto';
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}
