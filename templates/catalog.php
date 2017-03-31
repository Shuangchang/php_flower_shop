<?php
/**
 * Created by PhpStorm.
 * User: shuangchang
 * Date: 3/13/17
 * Time: 9:54 PM
 */
//    $per_page = 6;
//    $all_pagination = $db->getALLPagination($per_page);
//    $all = $db->getALL();
//
//    if(isset($_POST["type"]) && ($_POST["type"]=="add")){
//        if(!isset($_POST["qty"])){
//            echo "<p>Please select quantity.</p>";
//        }
//        $db->addToCart($_POST["item_id"],$_POST["qty"],$s_id);
//        $message = "You have added an item in cart.";
//        $allSale = $db->getSale();
//        $all_pagination = $db->getALLPagination($per_page);
//    }
?>

<div class="container">
    <div class="section">
        <h4 class="center">Catalog</h4>
            <?php
            $count = 1;
            foreach ($all_pagination as $product){
                if($count % 3 == 1 ){
                    echo "<div class=\"row\">";
                }
                echo "{$product->display_product()}";
                if($count % 3 == 0){
                    echo "</div>";
                }
                $count++;
            }
            ?>
        <div class="section col s12">
            <div class="row center">
                <?php
                    $pagination->pagination_links($all,$per_page);
                ?>
            </div>
        </div>
    </div>
</div>

<div class="parallax-container valign-wrapper">
    <div class="section no-pad-bot">
        <div class="container">
            <div class="row center">
                <h5 class="header col s12 light">Experience tranquility...</h5>
            </div>
        </div>
    </div>
    <div class="parallax"><img src="<?php echo URL_IMG . "bg04.jpg" ?>" alt="Unsplashed background img 3"></div>
</div>