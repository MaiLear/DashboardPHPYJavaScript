<?php
require_once 'Config/App/Controller.php';
class BuyController extends Controller
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }

    public function index()
    {
        $data['total'] = $this->model->getBuyTotal();
        $this->views->getView($this, 'index', $data);
    }

    public function pdf()
    {
        $data['pdf'] = $this->model->getDetailBuy();
        $this->views->getView($this, 'pdf', $data);
    }


    public function getProduct(int $code)
    {

        $response = $this->model->getProduct($code);
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function store()
    {
        $code_product = $_POST['code'];
        $product = $this->model->getProduct($code_product);
        $id_product = $product['data']['id'];
        $id_user =  $_SESSION['id_user'];
        $price = $product['data']['purchase_price'];
        $quantity = $_POST['quantity'];
        $subtotal = $quantity * $price;



        $data = $this->model->saveOrUpdateDetails($id_product, $id_user, $price, $quantity, $subtotal);

        $totalBuy = $this->model->getBuyTotal()['data'];

        $data['data'] = $totalBuy;

        $data['msg'] = $data['ok'] ? 'Se insertaron o actualizaron los datos correctamente' : 'No se pudieron insetar o actualizar los datos';

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function dataList()
    {
        $response = $this->model->getAllDetails();
        echo json_encode($response['data'], JSON_UNESCAPED_UNICODE);
        die();
    }

    public function makeToBuy()
    {
        $total_product = $_POST['total'];
        $responseBuy = $this->model->saveBuy($total_product);

        $details  = $this->model->getAllDetails()['data'];
        $id_buy = $this->model->getIdBuy()['data']['id'];
        foreach ($details as $key => $value) {
            $quantity = $details[$key]['quantity'];
            $price = $details[$key]['price'];
            $subtotal = $details[$key]['subtotal'];
            $responseDetailBuy = $this->model->saveDetailBuy($id_buy, $quantity, $price, $subtotal);
        }
        if (!$responseBuy['ok'] || !$responseDetailBuy['ok']) {
            $responseBuy['msg'] = 'La compra no se pudo realizar correctamente';
        } else {
            $responseBuy['msg'] = 'Compra realizadad exitosamente';
        }

        echo json_encode($responseBuy, JSON_UNESCAPED_UNICODE);
    }






    public function destroy()
    {
        $response = $this->model->destroyDetail();

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
    }
}
