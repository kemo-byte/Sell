    <?php
    
    session_start();
	include "init.php";?>

    <div class="container">

    <h1 class="text-center"></h1>
        <div class="row">    
            <?php
            // $category = isset($_GET['pageid']) && is_numeric($_GET['pageid'])?  intval($_GET['pageid']) : 0;
                 
                if(isset($_GET['pageid']) && is_numeric($_GET['pageid'])){
                    $category = intval($_GET['pageid']);
                $all = getAllFrom("*","items","where Cat_ID = {$category }","AND Approve = 1","item_ID");
                foreach($all as $item){

                    echo "<div class='col-sm-6 col-md-3'>";
                    echo "<a style='text-decoration:none' href='items.php?itemid=". $item['item_ID'] . "'>";
                            echo "<div class='thumbnail item-box'>";
                                // echo "<span class='price'>". $item['Price'] ."</span>";
                                // echo "<img src='avatar.png' class='img-responsive' alt='User' />";
                                echo "<div style=' height:200px;'>";
                                if(!empty($item['Image'])){
                                    echo "<img src='Cpanel/upload/items/" . $item['Image'] . "' alt=''  class='img-responsive img-thumbnail center-block' style='width:100%; height:200px;'/>";
                                    }else{
                                    echo "<img style='width:100%; height:200px;' src='Cpanel/upload/items/items.jpg' alt=''  class='img-responsive img-thumbnail center-block' />";
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
            }else{
                echo "معرف غير صحيح";
            }
            ?>
        </div>
    </div>

    <?php    
        include $tpl . "footer.php";
     ?>


