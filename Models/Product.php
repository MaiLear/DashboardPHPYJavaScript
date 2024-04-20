<?php
require_once 'Config/App/Query.php';
class Product extends Query
{
    private $code, $description, $purchase_price, $sale_price, $quantity, $id_measure, $id_category, $image, $id;
    public function __construct()
    {
        parent::__construct();
    }


    public function getProductUsingId(int $id)
    {
        $sql = "SELECT * FROM products WHERE id = '$id'";
        return $this->select($sql);
    }

    public function getAllProducts()
    {
        $sql = "SELECT p.*,m.full_name AS measure,c.name AS category  FROM products p INNER JOIN measures m ON m.id = p.id_measure
        INNER JOIN categories c ON c.id = p.id_category";
        $response = $this->selectAll($sql);
        $data = $response['data'];
        foreach ($data as $key => $value) {
            $data[$key]['renderImage'] =  "<img class='img-thumbnail' src=Assets/img/" . $data[$key]['image'] . ">";
            $data[$key]['nameState'] = $value['state'] == 1 ? "<span class='badge bg-success'>Activo</span>" : "<span class='badge bg-danger'>Inactivo</span>";
            $data[$key]['acciones'] = "
            <div>
            <button class='btn btn-primary' data-id=" . $data[$key]['id'] . " id='btn-open-modal__editProduct'>Editar</button>
            <button class='btn btn-danger' id='btn-product__delete' data-id=" . $data[$key]['id'] . ">Eliminar</button>
            </div>";
        }
        return $data;
    }

    public function getAllMeasures()
    {
        $sql = "SELECT * FROM measures";
        return $this->selectAll($sql);
    }
    public function getAllCategories()
    {
        $sql = "SELECT * FROM categories";
        return $this->selectAll($sql);
    }



    public function saveProduct($code, $description, $purchase_price, $sale_price, $quantity, $id_measure, $id_category, $image)
    {
        $this->code = $code;
        $this->description = $description;
        $this->purchase_price = $purchase_price;
        $this->sale_price = $sale_price;
        $this->quantity = $quantity;
        $this->id_measure = $id_measure;
        $this->id_category = $id_category;
        $this->image = $image;

        $sql = "INSERT INTO products(code,description,purchase_price,sale_price,quantity,id_measure,id_category,image) VALUES(?,?,?,?,?,?,?,?)";
        $values = array($this->code, $this->description, $this->purchase_price, $this->sale_price, $this->quantity, $this->id_measure, $this->id_category, $this->image);


        return $this->save($sql, $values);
    }

    public function updateProduct(string $code, string $description, int $purchase_price, int $sale_price, int $quantity, $id_measure, $id_category, $image, int $id)
    {
        $this->code = $code;
        $this->description = $description;
        $this->purchase_price = $purchase_price;
        $this->sale_price = $sale_price;
        $this->quantity = $quantity;
        $this->id_measure = $id_measure;
        $this->id_category = $id_category;
        $this->image = $image;
        $this->id = $id;
        $sql = "UPDATE products SET code=?,description=?,purchase_price=?,sale_price=?,quantity=?,id_measure=?,id_category=?,image=? WHERE id = ?";
        $values = array($this->code, $this->description, $this->purchase_price, $this->sale_price, $this->quantity, $this->id_measure, $this->id_category, $this->image, $this->id);
        return $this->save($sql, $values);
    }



    public function deleteProduct(int $id)
    {
        $this->id = $id;
        $sql = "UPDATE products SET state=0 WHERE id=?";
        $value = array($this->id);
        return $this->destroy($sql, $value);
    }
}
