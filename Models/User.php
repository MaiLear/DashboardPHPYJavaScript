<?php
require_once 'Config/App/Query.php';
class User extends Query
{
    private $user, $name, $state, $key_user, $id_box, $id;

    public function __construct()
    {
        //Se ejecuta el constructor de la clase padre
        parent::__construct();
    }

    public function getUser(string $user)
    {
        $sql = "SELECT * FROM users WHERE user = '$user'";
        return $this->select($sql);
    }

    public function getUserUsingId(int $id)
    {
        $sql = "SELECT * FROM users WHERE id = '$id'";
        return $this->select($sql);
    }

    public function getAllUsers()
    {
        $sql = "SELECT u.*,b.box AS box FROM users u LEFT JOIN boxs b ON u.id_box = b.id";
        $response = $this->selectAll($sql);
        $data = $response['data'];
        foreach ($data as $key => $value) {
            $data[$key]['nameState'] = $value['state'] == 1 ? "<span class='badge bg-success'>Activo</span>" : "<span class='badge bg-danger'>Inactivo</span>";
            $data[$key]['acciones'] = "
            <div>
            <button class='btn btn-primary' data-id=" . $data[$key]['id'] . " id='btn-open-modal__editar'>Editar</button>
            <button class='btn btn-danger' id='btn-user__delete' data-id=" . $data[$key]['id'] . ">Eliminar</button>
            </div>";
        }
        return $data;
    }

    public function getAllBoxs()
    {
        $sql = "SELECT * FROM boxs";
        $response = $this->selectAll($sql);
        return $response['data'];
    }

    public function saveUser(string $user, string $name, string $state, string $id_box, string $key_user)
    {
        $this->user = $user;
        $this->name = $name;
        $this->state = $state;
        $this->id_box = $id_box;
        $this->key_user = $key_user;
        $sql = "INSERT INTO users(user,name,state,id_box,key_user) VALUES(?,?,?,?,?)";
        $values = array($this->user, $this->name, $this->state, $this->id_box, $this->key_user);


        return $this->save($sql, $values);
    }

    public function updateUser(string $user, string $name, string $state, string $id_box, int $id)
    {
        $this->user = $user;
        $this->name = $name;
        $this->state = $state;
        $this->id_box = $id_box;
        $this->id = $id;
        $sql = "UPDATE IGNORE users SET user=?,name=?,state=?,id_box=? WHERE id = ?";
        $values = array($this->user, $this->name, $this->state, $this->id_box, $this->id);
        return $this->save($sql, $values);
    }



    public function deleteUser(int $id)
    {
        $this->id = $id;
        $sql = "UPDATE users SET state=0 WHERE id=?";
        $value = array($this->id);
        return $this->destroy($sql, $value);
    }
}
