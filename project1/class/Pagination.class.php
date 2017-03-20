<?php

/**
 * Created by PhpStorm.
 * User: shuangchang
 * Date: 3/16/17
 * Time: 2:21 PM
 * tutorial www.codingcage.com/2015/04/how-to-create-pagination-with-php-pdo.html
 */
class Pagination
{
    //refine mysql query with start record and number of records display data $per_page,
    //return new query
    public function get_per_page($query, $per_page){
        $start = 0;
        if(isset($_GET["page_no"])){
            $start = (intval($_GET["page_no"]) - 1)*$per_page;
        }
        $new_query = $query . "LIMIT $start, $per_page";
        return $new_query;
    }

    //pagination links
    public function pagination_links($data, $per_page){
        $self = $_SERVER["PHP_SELF"];//if on the current page

        $total_count = count($data);
        if($total_count >0){
            echo "<ul class=\"pagination\">";
            $total_pages = ceil($total_count/$per_page);
            $current = 1;
            if(isset($_GET["page_no"])){
                $current = $_GET["page_no"];
            }
            if($current != 1){
                $prev = $current - 1;
                echo "<li class=\"waves-effect\"><a href=\"$self?page_no=1\">&laquo;</a></li>";
                echo "<li class=\"waves-effect\"><a href=\"$self?page_no=$prev\">
                        <i class=\"material-icons\">chevron_left</i></a></li>";
            }
            for($i=1;$i<=$total_pages;$i++){
                if($i==$current){
                    echo "<li class=\"active\"><a href=\"$self?page_no=$i\">$i</a></li>";
                }else{
                    echo "<li class=\"waves-effect\"><a href=\"$self?page_no=$i\">$i</a></li>";
                }
            }
            if($current != $total_pages){
                $next = $current + 1;
                echo "<li class=\"waves-effect\"><a href=\"$self?page_no=$next\">
                        <i class=\"material-icons\">chevron_right</i></a></li>";
                echo "<li class=\"waves-effect\"><a href=\"$self?page_no=$total_pages\">&raquo;</a></li>";
            }
            echo "</ul>";
        }
    }
}
?>