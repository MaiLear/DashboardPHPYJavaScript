<?php
require_once 'Config/App/Query.php';
class Client extends Query
{
    private  $name, $type_document, $number_document, $phone, $address, $id;

    public function __construct()
    {
        //Se ejecuta el constructor de la clase padre
        parent::__construct();
    }

    public function getClient(string $client)
    {
        $sql = "SELECT * FROM clients WHERE user = '$client'";
        return $this->select($sql);
    }

    public function getClientUsingId(int $id)
    {
        $sql = "SELECT * FROM clients WHERE id = '$id'";
        return $this->select($sql);
    }

    public function getAllClients()
    {
        $sql = "SELECT *  FROM clients";
        $response = $this->selectAll($sql);
        $data = $response['data'];
        foreach ($data as $key => $value) {
            $data[$key]['nameState'] = $value['state'] == 1 ? "<span class='badge bg-success'>Activo</span>" : "<span class='badge bg-danger'>Inactivo</span>";
            $data[$key]['acciones'] = "
            <div>
            <button class='btn btn-primary' data-id=" . $data[$key]['id'] . " id='btn-open-modal__editClient'>Editar</button>
            <button class='btn btn-danger' id='btn-client__delete' data-id=" . $data[$key]['id'] . ">Eliminar</button>
            </div>";
        }
        return $data;
    }



    public function saveClient(string $name, string $type_document, int $number_document, int  $phone, string $address)
    {
        $this->name = $name;
        $this->type_document = $type_document;
        $this->number_document = $number_document;
        $this->phone = $phone;
        $this->address = $address;
        $sql = "INSERT INTO clients(name,type_document,number_document,phone,address) VALUES(?,?,?,?,?)";
        $values = array($this->name, $this->type_document, $this->number_document, $this->phone, $this->address);


        return $this->save($sql, $values);
    }

    public function updateClient(string $name, string $type_document, string $number_document, string $phone, string $address, int $id)
    {
        $this->name = $name;
        $this->type_document = $type_document;
        $this->number_document = $number_document;
        $this->phone = $phone;
        $this->address = $address;
        $this->id = $id;
        $sql = "UPDATE clients SET name=?,type_document=?,number_document=?,phone=?,address=? WHERE id = ?";
        $values = array($this->name, $this->type_document, $this->number_document, $this->phone, $this->address, $this->id);
        return $this->save($sql, $values);
    }



    public function deleteClient(int $id)
    {
        $this->id = $id;
        $sql = "UPDATE clients SET state=0 WHERE id=?";
        $value = array($this->id);
        return $this->destroy($sql, $value);
    }
}
