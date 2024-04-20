<?php
require_once 'Config/App/Query.php';
class Category extends Query
{
    private  $name, $type_document, $number_document, $phone, $address, $id;

    public function __construct()
    {
        //Se ejecuta el constructor de la clase padre
        parent::__construct();
    }

 

    public function getCategoryUsingId(int $id)
    {
        $sql = "SELECT * FROM categories WHERE id = '$id'";
        return $this->select($sql);
    }

    public function getAllCategories()
    {
        $sql = "SELECT *  FROM categories";
        $response = $this->selectAll($sql);
        $data = $response['data'];
        foreach ($data as $key => $value) {
            $data[$key]['nameState'] = $value['state'] == 1 ? "<span class='badge bg-success'>Activo</span>" : "<span class='badge bg-danger'>Inactivo</span>";
            $data[$key]['acciones'] = "
            <div>
            <button class='btn btn-primary' data-id=" . $data[$key]['id'] . " id='btn-open-modal__editCategory'>Editar</button>
            <button class='btn btn-danger' id='btn-category__delete' data-id=" . $data[$key]['id'] . ">Eliminar</button>
            </div>";
        }
        return $data;
    }



    public function saveCategory(string $name)
    {
        $this->name = $name;
        $sql = "INSERT INTO categories(name) VALUES(?)";
        $values = array($this->name);


        return $this->save($sql, $values);
    }

    public function updateCategory(string $name, int $id)
    {
        $this->name = $name;
        $this->id = $id;
        $sql = "UPDATE categories SET name=? WHERE id = ?";
        $values = array($this->name, $this->id);
        return $this->save($sql, $values);
    }



    public function deleteCategory(int $id)
    {
        $this->id = $id;
        $sql = "UPDATE categories SET state=0 WHERE id=?";
        $value = array($this->id);
        return $this->destroy($sql, $value);
    }
}
