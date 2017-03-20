<?php
/**
 * Created by PhpStorm.
 * User: shuangchang
 * Date: 3/13/17
 * Time: 2:28 PM
 */
    session_start();
    require_once "assets/inc/page_start.inc.php";
    require_once PATH_INC . "header.inc.php";
    function __autoload( $class_name ){
        //need to use correct file structure (file name)
        require_once PATH_CLASS ."{$class_name}.class.php";
    }
    $db = new DB();
    $pagination = new Pagination();
?>

<div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
        <div class="container">
            <br><br>
            <h1 class="header center teal-text text-lighten-1">Succulents</h1>
            <div class="row center">
                <h5 class="header col s12 light">Echeveria Collection Spring Sale 2017 . Plus free shipping from March 10 - 28. </h5>
            </div>
            <div class="row center">
            </div>
            <br><br>

        </div>
    </div>
    <div class="parallax"><img src="<?php echo URL_IMG . "bg01.jpg" ?>" alt="Unsplashed background img 1"></div>
</div>
<?php  require_once PATH_TEM . "sales.php"; ?>

<?php require_once PATH_TEM . "catalog.php"; ?>

<?php require_once PATH_INC . "footer.inc.php"; ?>
