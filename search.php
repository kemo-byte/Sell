<?php

session_start();
include "init.php";?>

<div class="container">


    <div class="row">    
        <?php
        // $category = isset($_GET['pageid']) && is_numeric($_GET['pageid'])?  intval($_GET['pageid']) : 0;
             
            if(isset($_GET['search'])){
                $tag = $_GET['search'];
                
                
            $all = getAllFrom("*","items","where match(Name) Against('$tag') OR MATCH(Description) Against('$tag')  Or MATCH(tags) Against('$tag') ","","item_ID");
            //SELECT Name FROM items WHERE MATCH(Name) Against('usb')  OR MATCH(Description) Against('usb')  Or MATCH(tags) Against('usb') 
            if(count($all) > 0 ){
                echo "<h1 class='text-center'>". $tag ."</h1>";
            
            foreach($all as $item){
                
                if($item['Approve'] == 1){
                echo "<div class='col-sm-6 col-md-3'>";
                    echo "<a style='text-decoration:none' href='items.php?itemid=". $item['item_ID'] . "'>";
                        echo "<div class='thumbnail item-box'>";
                            // echo "<span class='price'>$". $item['Price'] ."</span>";
                            //echo "<img src='avatar.png' class='img-responsive' alt='User' />";
                            echo "<div style=' height:200px;'>";
                                if(!empty($item['Image'])){
                                echo "<img src='Cpanel/upload/items/" . $item['Image'] . "' title='".$item['Name']."' alt='".$item['Name']."' class='img-responsive' style='width:100%; height:200px;' />";
                                }else{
                                    echo "<img src='Cpanel/upload/items/items.jpg' title='".$item['Name']."' alt='".$item['Name']."' class='img-responsive ' style='width:100%; height:100%' />";
                                }
                            echo "</div>";
                            echo "<div class='caption'>";
                                echo "<h3 style='color:blue;font-weight:bold'>" . $item['Name'] . "</h3>";
                                echo "<p>" . $item['Description'] . "</p>";
                                // echo "<span>".$item['Add_Date']."</span>";
                            echo "</div>";
                        echo "</div>";
                    echo "</a>";
                echo "</div>";
                }
            }
        }else{
            echo "<h1 class='text-center'>". $tag ." غير موجود</h1>";
        }
        }else{
            echo "Invalid ID";
        }
        ?>
    </div>
</div>

<?php    
    include $tpl . "footer.php";
 ?>


