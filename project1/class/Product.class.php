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


    public function display_product(){
        $self = basename($_SERVER['REQUEST_URI']);//the current page
        $url = URL_P_IMG . $this->imgName . ".jpg";
        $display = "<div class=\"col s12 m4\"> <div class=\"img-block\">";
        $display .= "<img class=\"pic\" src=\"{$url}\">";
        $display .= "<h5>{$this->name}</h5>
                     <p>{$this->description}</p>
                     <p>In stock: {$this->quantity}<br />
                     Price: <span class=\"light price\">{$this->price}</span>";
        if(!empty($this->salePrice) && $this->salePrice > 0){
            $display .="<span class=\"light red-text darken-2\">Now: {$this->salePrice}</span></p>";
        }else{
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
}
?>