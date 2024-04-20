<?php
require_once 'Config/App/Controller.php';
require_once 'Config/Config.php';
class UserController extends Controller
{
    public function __construct()
    {
        session_start();


        //Se ejecuta el constructor padre
        parent::__construct();
    }

    public function index()
    {
        if (empty($_SESSION['active'])) {
            header("Location:" . BASEROUTE);
        }

        $data['boxs'] = $this->model->getAllBoxs();
        $this->views->getView($this, 'index', $data);
    }

    public function validate()
    {
        if (empty($_POST['user']) || empty($_POST['password'])) {
            $msg = 'The inputs are empty.';
        } else {
            $user = $_POST['user'];
            $key_user = $_POST['password'];
            $response = $this->model->getUser($user);
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
        $data = $this->model->getAllUsers();
        //JSON_UNESCAPED_UNICODE permite que los caracteres especiales Ññ se interpreten correctamente
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function store()
    {
        $user = $_POST['user'];
        $name = $_POST['name'];
        $state = $_POST['state'];
        $id_box = $_POST['id_box'];
        $key_user = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $response = $this->model->saveUser($user, $name, $state, $id_box, $key_user);
        $response['msg'] = $response['ok']
            ?  'Usuario guardado correctamente'
            : 'No se pudo guardar el usuario';
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function edit(int $id)
    {
        $response = $this->model->getUserUsingId($id);
        echo json_encode($response);
        die();
    }

    public function update(int $id)
    {
        $user = $_POST['user'];
        $name = $_POST['name'];
        $state = $_POST['state'];
        $id_box = $_POST['id_box'];
        $response = $this->model->updateUser($user, $name, $state, $id_box, $id);

        $response['msg'] = $response['ok']
            ?  'El usuario fue actualizado correctamente'
            : 'El usuario no se pudo actualizar';

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function destroy(int $id)
    {
        $response = $this->model->deleteUser($id);
        $response['msg'] = $response['ok'] ? 'Usuario eliminado correctamente' : 'No se pudo eliminar el usuario';
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    public function logout()
    {
        session_destroy();
        header('Location:' . BASEROUTE);
    }
}
