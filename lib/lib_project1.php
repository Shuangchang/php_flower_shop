<?php
/**
 * Created by PhpStorm.
 * User: shuangchang
 * Date: 3/14/17
 * Time: 4:41 PM
 */

//www.w3schools.com/php/php_file_upload.asp
   function uploadImg(){
       $uploaddir = PATH_CLASS . "succulents/";
       $imgPath = $uploaddir .basename($_FILES["img"]["name"]);
       $uploadOK = 1;
       $imageFileType = pathinfo($imgPath,PATHINFO_EXTENSION);

           $check = getimagesize($_FILES["img"]["tmp_name"]);
           if($check !== false){
              $uploadOK = 1;
           }else{
               echo "File is not an image.";
               $uploadOK = 0;
           }

           //check if file exists
           if(file_exists($imgPath)){
               echo  "Image exists.";
               $uploadOK = 0;
           }

           //check file size
           if($_FILES["img"]["size"]>50000){
               echo "Image size is too large.";
               $uploadOK = 0;
           }

           //check file type
           if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif"){
               echo "Only jpg, jpeg, png and gif files are allowed.";
               $uploadOK = 0;
           }

           //check file name
           $reg = "/^[A-Za-z0-9\-\. ]+$/";
           if(!preg_match($reg,$_FILES["img"]["name"])){
               echo "Filename has illegal character.";
               $uploadOK = 0;
           }

           if($uploadOK == 1){
               if(move_uploaded_file($_FILES["img"]["tmp_name"], $imgPath)){
                   echo "<p>File has been uploaded.</p>";
                   $imgName = $_FILES["img"]["name"];
               }else{
                   echo "There was an error. Upload failed";
               }
           }


       return $imgName;
   }

   function validate_input($name, $price, $quantity, $salePrice, $description){
       $validate = false;
       if(empty($name)){
           $err[]="Product name is required.";
       }
       if(!empty($name) && !validate_name($name)){
           $err[]="Name can only contain alphabetic or numeric character with space.";
       }
       if(empty($price)){
           $err[]="Product price is required.";
       }
       if(!empty($price) && !is_numeric(floatval($price))){
           $err[]="Price can only contain numeric character.";
       }
       if(!is_numeric(intval($quantity))){
           $err[]="Quantity can only contain numeric character.";
       }
       if(!is_numeric(floatval($salePrice))){
           $err[]="Quantity can only contain numeric character.";
       }
       if(!empty($description) && strlen($description)<5){
           $err[]="Description is too short.";
       }

       if(empty($err)){
           $validate = true;
       }else{
           echo "<pre>";
           print_r($err);
           echo "</pre>";
       }
       return $validate;
   }

   function sanitize_input($value){
       $clean = filter_var(htmlspecialchars(strip_tags(stripslashes(trim($value)))),FILTER_SANITIZE_SPECIAL_CHARS);
       return $clean;
   }

   function validate_name($name){
       $reg = "/^[A-Za-z0-9 ]+$/";
       return preg_match($reg, $name);
   }


   function insert_Product_form($id){
    $self = basename($_SERVER['REQUEST_URI']);
    $display = "<form class=\"col s12\" enctype=\"multipart/form-data\" action=\"{$self}\" method=\"POST\">";
    $display .= "<div class=\"file-field input-field\">
                            <div class=\"btn\"><span>Choose Image</span>
                                <input type = \"file\" name = \"img\">
                            </div> 
                            <div class=\"file-path-wrapper\">
                                <input class=\"file-path validate\" type=\"text\" name=\"newImgName\" value=\"{$_SESSION["imgName"]}\">
                            </div>               
                        </div>";
    $display .= "<button class=\"btn waves-effect waves-light\" type=\"submit\" name=\"upload\">upload</button>";
    $display .="</form>";
//    if(isset($_SESSION["imgName"])){
//        $display .="<div class=\"col s12 center\">".$_SESSION["imgName"]."</div>";
//    }
    $display .="<div class=\"border col s12\"></div><div class=\"divider\"></div>";
    $display .= "<br /><br /><form class=\"col s12\" action=\"{$self}\" method=\"POST\">";
    $display .= "<div class=\"input-field col s12\">
                        <input type = \"text\" id=\"{$id}_name\" name=\"p_name\" class=\"validate\" data-length=\"50\" value=\"{$_POST["name"]}\">
                        <label id=\"{$id}_name\" class=\"active\" >Product Name (required)</label>
                        </div>";
    $display .= "<div class=\"input-field col s12\">
                        <textarea id=\"{$id}_description\" name=\"p_description\" class=\"materialize-textarea\" data-length=\"250\">{$_POST["description"]}</textarea>
                        <label id=\"{$id}__description\" class=\"active\"  >Description</label>
                        </div>";
    $display .= "<div class=\"input-field col s12\">
                        <input type = \"text\" id=\"{$id}_price\" name=\"p_price\" class=\"validate\" value=\"{$_POST["price"]}\">
                        <label id=\"{$id}_price\" class=\"active\"  >Price (required)</label>
                        </div>";
    $display .= "<div class=\"input-field col s12\">
                        <input type = \"text\" id=\"{$id}_quantity\" name=\"p_quantity\" class=\"validate\" value=\"{$_POST["quantity"]}\">
                        <label id=\"{$id}_quantity\" class=\"active\" >Quantity</label>
                        </div>";
    $display .= "<div class=\"input-field col s12\">
                        <input type = \"text\" id=\"{$id}_salePrice\" name=\"p_salePrice\" class=\"validate\" value=\"{$_POST["salePrice"]}\">
                        <label id=\"{$id}_salePrice\" class=\"active\" >Sale Price</label>
                        </div>";
    $display .= "<button class=\"btn waves-effect waves-light\" type=\"submit\" name=\"addNew\">Submit
                            <i class=\"material-icons right\">insert</i>
                        </button>
                        <button class=\"btn waves-effect waves-light\" type=\"reset\" name=\"reset\">Reset
                            <i class=\"material-icons right\">reset</i>
                        </button>";
    $display .="</form>";

    return $display;
}

?>