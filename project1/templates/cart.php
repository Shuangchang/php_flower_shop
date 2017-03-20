<?php
/**
 * Created by PhpStorm.
 * User: shuangchang
 * Date: 3/13/17
 * Time: 6:40 PM
 */
    session_start();
    require_once "../assets/inc/page_start.inc.php";
    require_once PATH_INC . "header.inc.php";
    function __autoload( $class_name ){
        //need to use correct file structure (file name)
        require_once PATH_CLASS ."{$class_name}.class.php";
    }
    $db = new DB();
    $cart = $db->getAllCart();

    if(isset($_POST["type"]) && $_POST["type"]=="update"){
        $new_qty = $_POST["qty"] - $_POST["item_qty"];
        $db->updateQuantity($_POST["id"], $new_qty);
        $db->updateQty($_POST["id"],$_POST["qty"]);
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
    }
?>
<div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
        <div class="container">
            <h1 class="header center teal-text text-lighten-1">Message</h1>
            <div class="row center">
                <h5 class="header col s12 light">cart</h5>
            </div>
        </div>
    </div>
    <div class="parallax"><img src="<?php echo URL_IMG . "bg00.jpg" ?>" alt="Unsplashed background img 1"></div>
</div>

<div class="section">
    <div class="container">

            <table class="responsive-table">
                <thead>
                <tr>
                    <?php
                    $columns = array_keys($cart[0]);
                    foreach ( $columns as $key){
                        if($key != "id"){
                            echo "<th data-field=\"$key\">$key</th>";
                        }
                    }
                    ?>
                </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($cart as $item){
                            echo "<tr>";
                            echo "<td>{$item['name']}</td>
                                  <td>{$item['description']}</td>
                                  <td>
                                   <form action=\"cart.php\" method=\"post\">
                                      <input type=\"text\" name=\"qty\" value=\"{$item["Qty"]}\">
                                      <input type=\"submit\" name=\"type\" value=\"update\" >
                                      <input type=\"hidden\" name=\"item_id\" value=\"{$item["id"]}\" >
                                      <input type = \"hidden\" name = \"item_qty\" value = \"{$item["Qty"]}\" >
                                   </form>
                                   </td>
                                  <td>\${$item['price']}</td>";
                            echo "</tr>";
                        }

                    ?>
                </tbody>
            </table>

    </div>
</div>
<div class="divider"></div>
<div class="total"></div>


<?php require_once PATH_INC . "footer.inc.php"; ?>

