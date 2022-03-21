<?php

session_start();
include "init.php";?>

<div class="container">


    <div class="row">    
        <?php
        // $category = isset($_GET['pageid']) && is_numeric($_GET['pageid'])?  intval($_GET['pageid']) : 0;
             
            if(isset($_GET['name'])){
                $tag = $_GET['name'];
                echo "<h1 class='text-center'>". $tag ."</h1>";
                
            $all = getAllFrom("*","items","where tags like '%$tag%'","AND Approve = 1","item_ID");
            foreach($all as $item){
                echo "<div class='col-sm-6 col-md-3'>";
                    echo "<div class='thumbnail item-box'>";
                        echo "<span class='price'>". $item['Price'] ."</span>";
                        echo "<img src='avatar.png' class='img-responsive' alt='User' />";
                        echo "<div class='caption'>";
                            echo "<h3><a href='items.php?itemid=". $item['item_ID'] . "'>" . $item['Name'] . "</a></h3>";
                            echo "<p>" . $item['Description'] . "</p>";
                            echo "<span style='font-size:12px;color: #bcb7b7;position: absolute;right: 10px;bottom:25px'>".$item['Add_Date']."</span>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
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


