<?php
require_once 'Config/App/Query.php';
class Buy extends Query
{
    private $id_product, $id_user, $price, $quantity, $subtotal;
    public function __construct()
    {
        parent::__construct();
    }

    public function  getProduct(string $code)
    {
        $sql = "SELECT * FROM products WHERE code = '$code'";
        return $this->select($sql);
    }


    public function getAllDetails()
    {
        $sql = "SELECT d.*,p.description FROM details d INNER JOIN products p ON p.id = d.id_product";
        return $this->selectAll($sql);
    }

    public function saveOrUpdateDetails(int $id_product, int $id_user, int $price, int $quantity, int $subtotal)
    {
        $this->id_product = $id_product;
        $this->id_user = $id_user;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->subtotal = $subtotal;
        $sqlOfProduct = "SELECT * FROM details WHERE id_product = $id_product AND id_user = $id_user";
        $productResponse = $this->select($sqlOfProduct);

        if ($productResponse['data']) {
            $this->quantity += $productResponse['data']['quantity'];
            $this->subtotal = $this->quantity * $this->price;
            $sql = "UPDATE details SET quantity=?,subtotal=? WHERE id_product=? AND id_user = ?";
            $values = array($this->quantity, $this->subtotal, $this->id_product, $this->id_user);
        } else {
            $sql = "INSERT INTO details(id_product,id_user,price,quantity,subtotal) VALUES(?,?,?,?,?)";
            $values = array($this->id_product, $this->id_user, $this->price, $this->quantity, $this->subtotal);
        }


        return $this->save($sql, $values);
    }

    public function getBuyTotal()
    {
        $sql = "SELECT SUM(subtotal) AS total FROM details";
        return $this->select($sql);
    }

    public function saveBuy(string $total)
    {
        $sql = "INSERT INTO buys(total) VALUES(?)";
        $values = array($total);
        return $this->save($sql, $values);
    }

    public function getIdBuy()
    {
        $sql = "SELECT MAX(id) AS id  FROM buys";
        return $this->select($sql);
    }

    public function saveDetailBuy(int $id_buy, int $quantity, int $price, int $subtotal)
    {
        $sql = "INSERT INTO detail_buy(id_buy,quantity,price,subtotal) VALUES(?,?,?,?)";
        $values = array($id_buy, $quantity, $price, $subtotal);
        return $this->save($sql, $values);
    }

    public function getDetailBuy()
    {
        $id_buy = $this->getIdBuy()['data']['id'];
        $sql = "SELECT db.*,b.total,b.fecha FROM detail_buy db INNER JOIN buys b ON b.id = db.id_buy WHERE id_buy = $id_buy";
        return $this->select($sql);
    }




    public function destroyDetail()
    {
        $sql = "DELETE FROM details";
        return $this->destroyAll($sql);
    }
}
