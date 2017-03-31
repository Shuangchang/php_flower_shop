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

    //get all on sale item - for display
    //@a product objects
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

    //get all regular price item - for display
    //@a product object
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

    //get all item - for display - admin item list
    //@a product object
    function getALLProduct(){
        try{
            include_once "Product.class.php";
            $data = array();
            $stmt = $this->dbh->prepare("SELECT * FROM product");
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

    //get all regular price item
    //implement with pagination - for display
    //@a product object
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


    //add item, user session ID into cart
    //@insert id
    public function addToCart($id,$qty,$s_id){
        try{
            $product = $this->getOneById($id);
            if($product["salePrice"]!=0.00){
                $price =$product["salePrice"];
            }else{
                $price = $product["price"];
            }
            $stmt = $this->dbh->prepare("INSERT INTO cart(id,Qty,name,price,description,sessionID) 
                                          VALUES (:id,:qty,:name,:price,:description,:sessionID)");
            $stmt->execute(array("id"=>$id,"qty"=>$qty,"name"=>$product["name"],"price"=>$price,"description"=>$product["description"],"sessionID"=>$s_id));
            $this->updateQuantity($id,$qty);
            return $this->dbh->lastInsertId();

        }catch (PDOException $exception){
            echo $exception->getMessage();
            die();
        }
    }

    //update quantity when add item in cart
    //@ updated quantity
    public function updateQuantity($id,$qty){
        try{
            $product = $this->getOneById($id);
            $new_quantity = $product["quantity"] - $qty;
            $stmt = $this->dbh->prepare("UPDATE product SET quantity = :quantity WHERE id = :id");
            $stmt->execute(array("quantity"=>$new_quantity, "id"=>$id));
            return $new_quantity;
        }catch (PDOException $exception){
            echo $exception->getMessage();
            die();
        }
    }

    //add quantity back when remove item from cart
    public function addBackQuantity($id,$qty){
        try{
            $product= $this->getOneById($id);
            $stmt = $this->dbh->prepare("UPDATE product SET quantity = :quantity WHERE id = :id");
            $new_quantity = $product["quantity"] + $qty;
            $stmt->execute(array("quantity"=>$new_quantity,"id"=>$id));

            return $new_quantity;
        }catch (PDOException $exception){
            echo $exception->getMessage();
            die();
        }
    }


    //admin edit existing product
    //@ edited id
    public function updateProduct($id,$name,$price,$quantity,$imgName,$salePrice,$description){
        try{
            $stmt = $this->dbh->prepare("UPDATE product SET name = :name, price = :price, 
                                        quantity = :quantity, imgName = :imgName, salePrice = :salePrice, 
                                        description = :description WHERE id = :id");
            $stmt->execute(array("name"=>$name,"price"=>$price,"quantity"=>$quantity,"imgName"=>$imgName,
                            "salePrice"=>$salePrice,"description"=>$description,"id"=>$id));

            return $id;

        }catch (PDOException $exception){
            echo $exception->getMessage();
            die();
        }
    }
    //admin add new product
    //@ added id
    public function insertProduct($name,$price=0.0,$quantity=0,$imgName="add later",$salePrice=0.0,$description="add later"){
        try{
            $stmt = $this->dbh->prepare("INSERT INTO product(name, price, quantity, imgName, salePrice, description)
                                                    VALUES(:name, :price, :quantity, :imgName, :salePrice, :description)");
            $stmt->execute(array("name"=>$name,"price"=>$price,"quantity"=>$quantity,"imgName"=>$imgName,
                "salePrice"=>$salePrice,"description"=>$description));

            return $this->dbh->lastInsertId();

        }catch (PDOException $exception){
            echo $exception->getMessage();
            die();
        }
    }

    //get one item by id - for database
    //@ an associate array
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

    //get one item by id
    //@ a product object - for ui display
    public function getOneByIdClass($id){
        try{
            include_once "Product.class.php";
            $data = array();
            $stmt = $this->dbh->prepare("SELECT * FROM product WHERE id = :id");
            $stmt->execute(array("id"=>$id));
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            $data = $stmt->fetch();

            return $data;

        }catch (PDOException $exception){
            echo $exception->getMessage();
            die();
        }
    }

    public function updateQty($id,$qty, $s_id){
        try{
            $stmt = $this->dbh->prepare("UPDATE cart SET Qty = :qty WHERE id = :id AND sessionID = :sessionID");
            $stmt->execute(array("qty"=>$qty,"id"=>$id,"sessionID"=>$s_id));

        }catch (PDOException $exception){
            echo $exception->getMessage();
            die();
        }
    }

    //get all cart item
    public function getAllCart($s_id){
        try{
            $data = array();
            $stmt = $this->dbh->prepare("SELECT * FROM cart WHERE sessionID = :sessionID");
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute(array("sessionID"=>$s_id));
            $data = $stmt->fetchAll();
            return $data;
        }catch (PDOException $exception){
            echo $exception->getMessage();
            die();
        }
    }

    //get one cart item
    public function getOneCartById($id, $s_id){
        try{
            $data = array();
            $stmt = $this->dbh->prepare("SELECT * FROM cart WHERE id = :id AND sessionID = :sessionID");
            $stmt->execute(array("id"=>$id, "sessionID"=>$s_id));
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $data = $stmt->fetch();

            return $data;

        }catch (PDOException $exception){
            echo $exception->getMessage();
            die();
        }
    }
    //delete cart item
    public function deleteRecord($id, $s_id){
        try{
            $stmt = $this->dbh->prepare("DELETE FROM cart WHERE id = :id AND sessionID = :sessionID");
            $stmt->execute(array("id"=>$id,"sessionID"=>$s_id));
        }catch (PDOException $exception){
            echo $exception->getMessage();
            die();
        }
    }


}
?>