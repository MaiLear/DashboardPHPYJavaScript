<?php
require_once 'Config/App/Query.php';
class Box extends Query
{

    private $box, $id;
    public function __construct()
    {
        parent::__construct();
    }


    public function getBox(string $box)
    {
        $sql = "SELECT * FROM boxs WHERE box = '$box'";
        return $this->select($sql);
    }

    public function getBoxUsingId(int $id)
    {
        $sql = "SELECT * FROM boxs WHERE id = '$id'";
        return $this->select($sql);
    }

    public function getAllBoxs()
    {
        $sql = "SELECT *  FROM boxs";
        $response = $this->selectAll($sql);
        $data = $response['data'];
        foreach ($data as $key => $value) {
            $data[$key]['nameState'] = $value['state'] == 1 ? "<span class='badge bg-success'>Activo</span>" : "<span class='badge bg-danger'>Inactivo</span>";
            $data[$key]['acciones'] = "
            <div>
            <button class='btn btn-primary' data-id=" . $data[$key]['id'] . " id='btn-open-modal__editBox'>Editar</button>
            <button class='btn btn-danger' id='btn-box__delete' data-id=" . $data[$key]['id'] . ">Eliminar</button>
            </div>";
        }
        return $data;
    }



    public function saveBox(string $box)
    {
        $this->box = $box;

        $sql = "INSERT INTO boxs(box) VALUES(?)";
        $values = array($this->box);


        return $this->save($sql, $values);
    }

    public function updateBox(string $box, int $id)
    {
        $this->box = $box;
        $this->id = $id;
        $sql = "UPDATE boxs SET box=? WHERE id = ?";
        $values = array($this->box, $this->id);
        return $this->save($sql, $values);
    }



    public function deletebox(int $id)
    {
        $this->id = $id;
        $sql = "UPDATE boxs SET state=0 WHERE id=?";
        $value = array($this->id);
        return $this->destroy($sql, $value);
    }
}
