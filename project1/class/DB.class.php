<?php
/**
 * Created by PhpStorm.
 * User: shuangchang
 * Date: 3/14/17
 * Time: 2:58 PM
 */

class DB
{
    private $dbh;

    function __construct(){
        require_once ("/home/sxc8355/db_conn.php");

        try{
            $this->dbh = new PDO("mysql:host=$mysql_host;dbname=$mysql_name", $mysql_user,$mysql_pass);
            $this->dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        } catch (PDOException $exception){
            echo $exception->getMessage();
            die();
        }
    }

    function getSale(){
        try{
            include_once "Product.class.php";
            $data = array();
            $stmt = $this->dbh->prepare("SELECT * FROM product WHERE salePrice != :sale_price");
            $stmt->bindValue(":sale_price",0.00,PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");

            while($product = $stmt->fetch()){
                $data[] = $product;
            }
            return $data;
        }catch (PDOException $exception){
            echo $exception->getMessage();
            die();
        }
    }
    function getALL(){
        try{
            include_once "Product.class.php";
            $data = array();
            $stmt = $this->dbh->prepare("SELECT * FROM product WHERE salePrice = :sale_price");
            $stmt->bindValue(":sale_price",0.00,PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");

            while($product = $stmt->fetch()){
                $data[] = $product;
            }
            return $data;
        }catch (PDOException $exception){
            echo $exception->getMessage();
            die();
        }
    }
    //implement with pagination
    function getALLPagination($per_page){
        try{
            include_once "Product.class.php";
            include_once "Pagination.class.php";
            $data = array();
            $query = "SELECT * FROM product WHERE salePrice = :sale_price ";
            $pagination = new Pagination();
            $new_query = $pagination->get_per_page($query,$per_page);
            $stmt = $this->dbh->prepare($new_query);
            $stmt->bindValue(":sale_price",0.00,PDO::PARAM_INT);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");

            while($product = $stmt->fetch()){
                $data[] = $product;
            }
            return $data;
        }catch (PDOException $exception){
            echo $exception->getMessage();
            die();
        }
    }

    //save card item
    public function addToCart($id,$qty){
        try{
            $item = $this->getOneById($id);
            if($item["salePrice"]!=0.00){
                $price =$item["salePrice"];
            }else{
                $price = $item["price"];
            }
            $stmt = $this->dbh->prepare("INSERT INTO cart(id,Qty,name,price,description) 
                                          VALUES (:id,:qty,:name,:price,:description)");
            $stmt->execute(array("id"=>$id,"qty"=>$qty,"name"=>$item["name"],"price"=>$price,"description"=>$item["description"]));
            $this->updateQuantity($id,$qty);
            return $this->dbh->lastInsertId();

        }catch (PDOException $exception){
            echo $exception->getMessage();
            die();
        }
    }
    //update quantity when add item in cart
    public function updateQuantity($id,$qty){
        try{
            $item = $this->getOneById($id);
            $new_quantity = $item["quantity"] - $qty;
            $stmt = $this->dbh->prepare("UPDATE product SET quantity = :quantity WHERE id = :id");
            $stmt->execute(array("quantity"=>$new_quantity, "id"=>$id));
            return $new_quantity;
        }catch (PDOException $exception){
            echo $exception->getMessage();
            die();
        }
    }
    public function updateQty($id,$qty){
        try{
            $stmt = $this->dbh->prepare("UPDATE cart SET Qty = :qty WHERE id = :id");
            $stmt->execute(array("qty"=>$qty,"id"=>id));

        }catch (PDOException $exception){
            echo $exception->getMessage();
            die();
        }
    }

    //get all cart item
    public function getAllCart(){
        try{
            $data = array();
            $stmt = $this->dbh->prepare("SELECT * FROM cart");
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;
        }catch (PDOException $exception){
            echo $exception->getMessage();
            die();
        }
    }

    //get one item by id
    public function getOneById($id){
        try{
            $data = array();
            $stmt = $this->dbh->prepare("SELECT * FROM product WHERE id = :id");
            $stmt->execute(array("id"=>$id));
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $data = $stmt->fetch();

            return $data;

        }catch (PDOException $exception){
            echo $exception->getMessage();
            die();
        }
    }

    //
    public function getOneCartById($id){
        try{
            $data = array();
            $stmt = $this->dbh->prepare("SELECT * FROM cart WHERE id = :id");
            $stmt->execute(array("id"=>$id));
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $data = $stmt->fetch();

            return $data;

        }catch (PDOException $exception){
            echo $exception->getMessage();
            die();
        }
    }


}
?>