<?php
/**
 * Created by PhpStorm.
 * User: shuangchang
 * Date: 3/14/17
 * Time: 4:34 PM
 */

//@property String p_name

class Product
{
    private $id, $name, $price, $quantity, $imgName, $salePrice, $description;

    function __construct()
    {
        $this->name = ucfirst(trim($this->name));
    }

    public function display_product(){
        $self = basename($_SERVER['REQUEST_URI']);//the current page
        $url = URL_P_IMG . $this->imgName;
        $display = "<div class=\"col s12 m4\"> <div class=\"img-block\">";
        $display .= "<img class=\"pic\" src=\"{$url}\">";
        $display .= "<h5>{$this->name}</h5>
                     <p class=\"left-align\">{$this->description}</p>
                     <p>In stock: {$this->quantity}<br />";
        if(!empty($this->salePrice) && $this->salePrice > 0){
            $display .="Price: <span class=\"light price\">\${$this->price}</span>";
            $display .="<span class=\"light red-text darken-2\">Now: \${$this->salePrice}</span></p>";
        }else{
            $display .="Price: <span class=\"light\">{$this->price}</span>";
            $display .="</p>";
        }
        $display .= "<form class=\"col s12\" action=\"{$self}\" method=\"POST\">                                          
                        <div class=\"input-field col s12 offset-3 qty \">                 
                            <select class=\"browser-default\" name=\"qty\">
                                <option value=\"\" disabled selected>select qty</option>
                                <option value=\"1\">1</option>
                                <option value=\"2\">2</option>
                                <option value=\"3\">3</option>
                                <option value=\"4\">4</option>
                                <option value=\"5\">5</option>
                                <option value=\"6\">6</option>
                                <option value=\"7\">7</option>
                                <option value=\"8\">8</option>
                                <option value=\"9\">9</option>
                                <option value=\"10\">10</option>
                            </select> 
                            <input type=\"hidden\" name=\"item_id\" value=\"{$this->id}\" >
                            <input type=\"hidden\" name=\"type\" value=\"add\" ></div>";
        $display .= "<button class=\"btn waves-effect waves-light\" type=\"submit\" name=\"add\">Add to cart
                    <i class=\"material-icons right\">add_shopping_cart</i>
                    </button></form>";
        $display .="</div></div>";

        return $display;
    }

    public function get_name(){
        return $this->name;
    }

    public function get_id(){
        return $this->id;
    }

    public function display_edit(){
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

//        if(isset($_SESSION["imgName"])){
//            $display .="<div class=\"col s12 center\">".$_SESSION["imgName"]."</div>";
//        }
       $display .="<div class=\"border col s12\"></div><div class=\"divider\"></div>";
       $display .= "<br /><br /><form class=\"col s12\" action=\"{$self}\" method=\"POST\">";
       $display .= "<div class=\"input-field col s12\">
                    <input type = \"text\" id=\"{$this->id}_name\" name=\"p_name\" class=\"validate\" data-length=\"50\" value=\"{$this->name}\">
                    <label id=\"{$this->id}_name\" class=\"active\" >Product Name (required)</label>
                    </div>";
       $display .= "<div class=\"input-field col s12\">
                    <textarea id=\"{$this->id}_description\" name=\"p_description\" class=\"materialize-textarea\" data-length=\"250\">{$this->description}</textarea>
                    <label id=\"{$this->id}__description\" class=\"active\"  >Description</label>
                    </div>";
       $display .= "<div class=\"input-field col s12\">
                    <input type = \"text\" id=\"{$this->id}_price\" name=\"p_price\" class=\"validate\" value=\"{$this->price}\">
                    <label id=\"{$this->id}_price\" class=\"active\"  >Price (required)</label>
                    </div>";
       $display .= "<div class=\"input-field col s12\">
                    <input type = \"text\" id=\"{$this->id}_quantity\" name=\"p_quantity\" class=\"validate\" value=\"{$this->quantity}\">
                    <label id=\"{$this->id}_quantity\" class=\"active\" >Quantity</label>
                    </div>";
       $display .= "<div class=\"input-field col s12\">
                    <input type = \"text\" id=\"{$this->id}_salePrice\" name=\"p_salePrice\" class=\"validate\" value=\"{$this->salePrice}\">
                    <label id=\"{$this->id}_salePrice\" class=\"active\" >Sale Price</label>
                    </div>";

       $display .= "<input type = \"hidden\" name=\"p_id\" value=\"{$this->id}\">";
       $display .= "<input type = \"hidden\" name=\"p_imgName\" value=\"{$this->imgName}\">";
       $display .= "<button class=\"btn waves-effect waves-light\" type=\"submit\" name=\"edit\">Submit Edit
                        <i class=\"material-icons right\">edit</i>
                    </button>
                    <button class=\"btn waves-effect waves-light\" type=\"reset\" name=\"reset\">Reset
                    </button>";
       $display .="</form>";

       return $display;
   }
}
?>