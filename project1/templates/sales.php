<?php
/**
 * Created by PhpStorm.
 * User: shuangchang
 * Date: 3/13/17
 * Time: 9:48 PM
 */

    $allSale = $db->getSale();
?>

<div class="container">
    <div class="section">
        <div class="row">
            <?php
                $count = 1;
                foreach ($allSale as $product){
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
        </div>

    </div>
</div>

<div class="parallax-container valign-wrapper">
    <div class="section no-pad-bot">
        <div class="container">
            <div class="row center">
                <h5 class="header col s12 light">//////////////something abt succulents//////////</h5>
            </div>
        </div>
    </div>
    <div class="parallax"><img src="<?php echo URL_IMG . "bg02.jpg" ?>" alt="Unsplashed background img 2"></div>
</div>