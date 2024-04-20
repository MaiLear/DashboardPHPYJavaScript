<?php
require_once 'Config/App/Query.php';
class Measure extends Query
{
    private  $full_name,$short_name, $id;

    public function __construct()
    {
        //Se ejecuta el constructor de la clase padre
        parent::__construct();
    }

   

    public function getMeasureUsingId(int $id)
    {
        $sql = "SELECT * FROM measures WHERE id = '$id'";
        return $this->select($sql);
    }

    public function getAllMeasures()
    {
        $sql = "SELECT *  FROM measures";
        $response = $this->selectAll($sql);
        $data = $response['data'];
        foreach ($data as $key => $value) {
            $data[$key]['nameState'] = $value['state'] == 1 ? "<span class='badge bg-success'>Activo</span>" : "<span class='badge bg-danger'>Inactivo</span>";
            $data[$key]['acciones'] = "
            <div>
            <button class='btn btn-primary' data-id=" . $data[$key]['id'] . " id='btn-open-modal__editMeasure'>Editar</button>
            <button class='btn btn-danger' id='btn-measure__delete' data-id=" . $data[$key]['id'] . ">Eliminar</button>
            </div>";
        }
        return $data;
    }



    public function saveMeasure(string $full_name,string $short_name)
    {
        $this->full_name = $full_name;
        $this->short_name = $short_name;
        
        $sql = "INSERT INTO measures(full_name,short_name) VALUES(?,?)";
        $values = array($this->full_name, $this->short_name,);


        return $this->save($sql, $values);
    }

    public function updateMeasure(string $full_name, string $short_name, int $id)
    {
        $this->full_name = $full_name;
        $this->short_name = $short_name;
        $this->id = $id;
        $sql = "UPDATE measures SET full_name=?,short_name=? WHERE id = ?";
        $values = array($this->full_name, $this->short_name, $this->id);
        return $this->save($sql, $values);
    }



    public function deleteMeasure(int $id)
    {
        $this->id = $id;
        $sql = "UPDATE measures SET state=0 WHERE id=?";
        $value = array($this->id);
        return $this->destroy($sql, $value);
    }
}
