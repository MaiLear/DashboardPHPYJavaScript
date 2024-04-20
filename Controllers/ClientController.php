<?php
require_once 'Config/App/Controller.php';
class ClientController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->views->getView($this, 'index');
    }

    public function validate()
    {
        if (empty($_POST['user']) || empty($_POST['password'])) {
            $msg = 'The inputs are empty.';
        } else {
            $user = $_POST['user'];
            $key_user = $_POST['password'];
            $response = $this->model->getClient($user);
            $userData = $response['data'];
            if ($userData && password_verify($key_user, $userData['key_user'])) {
                $_SESSION['id_user'] = $userData['id'];
                $_SESSION['user'] = $userData['user'];
                $_SESSION['name'] = $userData['name'];
                $_SESSION['active'] = true;
                $msg = 'ok';
            } else {
                $msg = 'User or password invalid';
            }
        }
        $response['msg'] = $msg;

        echo json_encode($response);
        die();
    }

    public function dataList()
    {
        $data = $this->model->getAllClients();
        //JSON_UNESCAPED_UNICODE permite que los caracteres especiales Ññ se interpreten correctamente
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function store()
    {
        $name = $_POST['name'];
        $type_document = $_POST['type_document'];
        $number_document = $_POST['number_document'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $response = $this->model->saveClient($name, $type_document, $number_document, $phone, $address);
        $response['msg'] = $response['ok']
            ?  'Cliente guardado correctamente'
            : 'No se pudo guardar el cliente';
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function edit(int $id)
    {
        $response = $this->model->getClientUsingId($id);
        echo json_encode($response);
        die();
    }

    public function update(int $id)
    {
        $name = $_POST['name'];
        $type_document = $_POST['type_document'];
        $number_document = $_POST['number_document'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $response = $this->model->updateClient($name, $type_document, $number_document, $phone, $address, $id);
        $response['msg'] = $response['ok']
            ?  'El cliente fue actualizado correctamente'
            : 'El cliente no se pudo actualizar';

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    public function destroy(int $id)
    {
        $response = $this->model->deleteClient($id);
        $response['msg'] = $response['ok'] ? 'Cliente eliminado correctamente' : 'No se pudo eliminar el cliente';
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}
