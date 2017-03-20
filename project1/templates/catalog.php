<?php
/**
 * Created by PhpStorm.
 * User: shuangchang
 * Date: 3/13/17
 * Time: 9:54 PM
 */
    $per_page = 6;
    $all_pagination = $db->getALLPagination($per_page);
    $all = $db->getALL();

    if(isset($_POST["type"]) && ($_POST["type"]=="add")){
        if(!isset($_POST["qty"])){
            echo "<p>Please select quantity.</p>";
        }
//        $item = $db->getOneById($_POST["item_id"]);
//        echo "<pre>";
//        print_r($item);
//        echo "</pre>";

        $db->addToCart($_POST["item_id"],$_POST["qty"]);
        echo "<p>You have added an item in cart.</p>";
    }
?>

<div class="container">
    <div class="section">

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
            <?php
                $pagination->pagination_links($all,$per_page);
            ?>
        </div>
    </div>
</div>

<div class="parallax-container valign-wrapper">
    <div class="section no-pad-bot">
        <div class="container">
            <div class="row center">
                <h5 class="header col s12 light">A modern responsive front-end framework based on Material Design</h5>
            </div>
        </div>
    </div>
    <div class="parallax"><img src="<?php echo URL_IMG . "bg04.jpg" ?>" alt="Unsplashed background img 3"></div>
</div>