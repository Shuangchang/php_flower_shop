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
    //check session id
    $s_id = session_id();
    $cart = $db->getAllCart($s_id);

    if(isset($_POST["type"]) && $_POST["type"]=="update"){
        $id = intval($_POST["item_id"]);
        $qty = $_POST["qty"];

        $db->updateQty($id,$qty,$s_id);
        $new_qty = $_POST["qty"] - $_POST["item_qty"];
        $db->updateQuantity($_POST["item_id"], $new_qty);
        $cart = $db->getAllCart($s_id);
    }
    if(isset($_POST["clear"])){
        foreach($cart as $item){
            $id = $item["id"];
            $Qty = $item["Qty"];
            $db->addBackQuantity($id,$Qty);
            $db->deleteRecord($id,$s_id);
        }

        $cart = $db->getAllCart($s_id);
    }
?>
<div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
        <div class="container">
            <h1 class="header center teal-text text-lighten-1">Cart</h1>
        </div>
    </div>
    <div class="parallax"><img src="<?php echo URL_IMG . "bg00.jpg" ?>" alt="Unsplashed background img 1"></div>
</div>

<div class="section">
    <div class="container">
        <div class="row center">
            <h5 class="header col s12"><?php
                if(empty($cart)){
                    echo "Cart is empty.";
                }
                ?></h5>
        </div>
            <table class="responsive-table">
                <thead>
                <tr>
                    <?php
                    if(!empty($cart)){
                        $columns = array_keys($cart[0]);
                        foreach ( $columns as $key){
                            if($key != "id" || $key != "sessionID"){
                                echo "<th data-field=\"$key\">$key</th>";
                            }
                        }
                    }
                    ?>
                </tr>
                </thead>
                <tbody>
                    <?php
                        $total = 0;
                        if(!empty($cart)) {
                            foreach ($cart as $item) {
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
                                $total += $item["Qty"] * $item["price"];
                                echo "</tr>";

                            }
                        }
                    ?>
                </tbody>
            </table>

            <div class="divider"></div>
            <p>Total: <?= $total ?><br /> Tax:<?= $total*0.08 ?> <br /> Amount: <?= $total*1.08 ?></p>
            <form action="cart.php" method="post">
                <button class="btn waves-effect waves-light" type="submit" name="clear">Empty cart
                    <i class="material-icons right">remove_shopping_cart</i>
                </button>
            </form>
    </div>
</div>

<?php require_once PATH_INC . "footer.inc.php"; ?>

