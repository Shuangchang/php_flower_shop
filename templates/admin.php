<?php
/**
 * Created by PhpStorm.
 * User: shuangchang
 * Date: 3/13/17
 * Time: 6:39 PM
 */
    session_start();

    require_once "../assets/inc/page_start.inc.php";
    if(isset($_POST["login"])) {
        if($_POST["pass"] == PASS){
        $_SESSION["login"] = true;
        $_SESSION["action"] = "insert";
        session_regenerate_id();
        }else{
            $msg[] = "Wrong password.";
        }
    }
    if(isset($_POST["logout"])){
        unset($_SESSION["login"]);
    }
    require_once PATH_INC . "header.inc.php";
    require_once PATH_LIB . "lib_project1.php";
    function __autoload( $class_name ){
        //need to use correct file structure (file name)
        require_once PATH_CLASS ."{$class_name}.class.php";
    }

?>
<div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
        <div class="container">
            <br><br>
            <h1 class="header center teal-text text-lighten-1">Admin page</h1>
        </div>
    </div>
    <div class="parallax"><img src="<?php echo URL_IMG . "bg03.jpg" ?>" alt="Unsplashed background img 1"></div>
</div>
<div class="section">
    <div class="container">
        <?php
            $db = new DB();
            $data = $db->getALLProduct();
            if(!isset($_SESSION["login"]) && $_SESSION["login"] !== true){
                echo "<form class=\"col s12\" action=\"admin.php\" method=\"post\">
                    <div class=\"input-field col s6\">
                        <input placeholder=\"password\" id=\"password\" name=\"pass\" type=\"password\" class=\"validate\">
                        <label for=\"password\">Admin login</label>
                    </div>
                    <div class=\"col s6\">
                        <button class=\"btn waves-effect waves-light\" type=\"submit\" name=\"login\">Login</button>
                     </div>
                </form>";
            }?>
    </div>
    <div class="row">
        <?php
            if($_SESSION["login"]){
                echo "<div class=\"col s12\">
                        <form action=\"admin.php\" method=\"post\">
                            <button class=\"btn waves-effect waves - light\" type=\"submit\" name=\"logout\">Logout</button>
                            <button class=\"btn waves-effect waves - light\" type=\"submit\" name=\"insert\">Add product
                                <i class=\"material-icons right\">add</i></button> 
                        </form>
                      </div>";
                echo "<div class=\"col s6\">";
                echo "<ul class=\"collection with-header\"><li class=\"collection-header\"><h5>Products</h5></li>";
                foreach($data as $product){
                    $p_name = $product->get_name();
                    $p_id = $product->get_id();
                    echo "<li class=\"collection-item\"><form action=\"admin.php\" method=\"post\">
                                            <button type=\"submit\" name=\"select\" class=\"waves-effect waves-teal btn-flat\">
                                                {$p_name}<i class=\"material-icons right\">edit</i></button>
                                            <input type=\"hidden\" name=\"p_id\" value=\"{$p_id}\">
                                          </form>
                                      </li>";
                }
                echo "<li class=\"collection-item\"><form action=\"admin.php\" method=\"post\"></form></li>";
                echo "</ul></div>";

                if(isset($_POST["insert"])){
                    $_SESSION["action"] = "insert";
                }

                if(isset($_POST["select"])) {
                    $_SESSION["action"] = "select";
                    $_SESSION["p_id"] = $_POST["p_id"];
                }

                if($_SESSION["action"] == "insert"){
                    $id_num = count($data);
                    echo "<div class=\"col s6\">";
                    echo insert_Product_form($id_num);
                    echo "</div>";

                    if(isset($_POST["upload"])){
                        //upload image
                        $imgName = uploadImg();
                        unset($_SESSION["imgName"]);
                        $_SESSION["imgName"] = $imgName;
                        echo $imgName;
                    }

                    if(isset($_POST["addNew"])){
                        //echo $_POST["p_name"],$_POST["p_price"],$_POST["p_quantity"],$_POST["p_salePrice"],$_POST["p_description"];
                        //validate input & sanitize input
                        validate_input($_POST["p_name"],$_POST["p_price"],$_POST["p_quantity"],$_POST["p_salePrice"],$_POST["p_description"]);
                        if(validate_input($_POST["p_name"],$_POST["p_price"],$_POST["p_quantity"],$_POST["p_salePrice"],$_POST["p_description"])){
                            $name = sanitize_input($_POST["p_name"]);
                            $price = sanitize_input(floatval($_POST["p_price"]));
                            $quantity = sanitize_input(intval($_POST["p_quantity"]));
                            $salePrice = sanitize_input(floatval($_POST["p_salePrice"]));
                            $description = sanitize_input($_POST["p_description"]);

                            if(isset($_SESSION["imgName"])){
                                $imgName = $_SESSION["imgName"];
                            }else{
                                $imgName = null;
                            }

                            $id = $db->insertProduct($name,$price,$quantity,$imgName,$salePrice,$description);
                            echo "<div class=\"col s6\">New item has been added.</div>";
                            unset($_SESSION["imgName"]);
                            //display again
                            $edit_product = $db->getOneByIdClass($id);
                            $edit_product ->display_edit();
                            $data = $db->getALLProduct();
                            foreach($data as $product){
                                $p_name = $product->get_name();
                                $p_id = $product->get_id();
                                echo "<li class=\"collection-item\"><form action=\"admin.php\" method=\"post\">
                                            <button type=\"submit\" name=\"select\" class=\"waves-effect waves-teal btn-flat\">
                                                {$p_name}<i class=\"material-icons right\">edit</i></button>
                                            <input type=\"hidden\" name=\"p_id\" value=\"{$p_id}\">
                                          </form>
                                      </li>";
                            }
                        }
                    }
                }


                if($_SESSION["action"] == "select"){
                    $edit_product = $db->getOneByIdClass($_SESSION["p_id"]);
                    echo "<div class=\"col s6\">";
                    echo "{$edit_product->display_edit()}";
                    echo "</div>";

                    if(isset($_POST["upload"])){
                        //upload image
                        $imgName = uploadImg();
                        $_SESSION["imgName"] = $imgName;
                        echo $imgName;
                    }

                    if(isset($_POST["edit"])){

                        validate_input($_POST["p_name"],$_POST["p_price"],$_POST["p_quantity"],$_POST["p_salePrice"],$_POST["p_description"]);

                        //validate input & sanitize input
                        if(validate_input($_POST["p_name"],$_POST["p_price"],$_POST["p_quantity"],$_POST["p_salePrice"],$_POST["p_description"])){
                            $name = sanitize_input($_POST["p_name"]);
                            $price = sanitize_input(floatval($_POST["p_price"]));
                            $quantity = sanitize_input(intval($_POST["p_quantity"]));
                            $salePrice = sanitize_input(floatval($_POST["p_salePrice"]));
                            $description = sanitize_input($_POST["p_description"]);


                            if(empty($_SESSION["imgName"])){
                                $imgName = $_POST["p_imgName"];
                            }else{
                                $imgName = $_SESSION["imgName"];
                            }
                            $id = $db->updateProduct($_POST["p_id"],$name,$price,$quantity,$imgName,$salePrice,$description);
                            echo "<div class=\"col s6\">Item {$id} has been edited.</div>";
                            //display again
                            $edited_product = $db->getOneByIdClass($id);
                            $edited_product->display_edit();
                        }
                    }
                }

            }
        ?>
    </div>
    <div class="container">
        <div class="row center">
            <?php
            if(!empty($msg)){
                foreach ($msg as $m){
                    echo "<p>{$m}</p>";
                }
            }
            ?>
        </div>
    </div>
</div>


<?php require_once PATH_INC . "footer.inc.php"; ?>
