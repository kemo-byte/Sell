<?php 
    ob_start();
    session_start();
    $pageTitle = "الرصيد";
    include "init.php";
?>
<div class="bal text-center" style="">
    <div class="container">
        <div class="row">
        
        
        
        <?php
            $user = $_SESSION['user'];
            $one = getOneFrom("*","users","WHERE Username='$user'","");

            ?>
        <div class="panel panel-warning">
        <div class="panel-head text-right"style="border-radius:10px 10px 0 0;padding:20px;font-size:2em;background-color:#8e44ad;border-color:#8e44ad;color:#fff">الرصيد</div>
        <div class="panel-body">
            <div class="col-sm-12">
            <?php
            echo "<div style='display:inline-block;padding:20px;background-color:#ddd;border-radius:10px;font-size:2em;margin-bottom:20px;'>" . $one['balance']." جنيه" . "</div>";
            ?>
            </div>
            <div class="col-sm-12">
                <button class='btn btn-success btn-lg' onclick='document.getElementById("id02").style.display="block"'>شحن</button>
                <button class='btn btn-danger btn-lg' onclick='document.getElementById("id03").style.display="block"'>سحب</button>
            </div>
            </div>
            </div>

            <?php
            ?>


        <div id="id02" class="modal">       
            <div class="modal-content animate" style="background-color:#eee">
                <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
    
                <div class="pay text-center">
                    
                    <h1>Payit
                    <img src="Cpanel/upload/avatar/payit.png" width="50px" height="50px"/></h1>
                    <!-- <h3 style="font-weight:bold">
                    ادخل إسم المستخدم وكلمة المرور
                    </h3> -->
                    <!-- <form method="POST"> -->
                        <div id="msg"></div>
                    <input class="form-control input-lg" id="pu" type="text" placeholder="إسم المستخدم" required />
                    <input type="hidden" id="me" value="<?php echo $_SESSION['user']?>" />
                    <input type="password" id="ppp" class="form-control input-lg" placeholder="كلمة المرور" required />
                    <input class="form-control input-lg" id="pb" type="number" min="0" max="1000" placeholder="المبلغ المراد شحن رصيدك في الموقع به" required />
                    <button class="btn btn-primary btn-block" id="pa">إرسال</button>
                    <!-- </form> -->
                
                    <script>

                                            // for pay to ecommerce from payit.com
                        $('#pa').click(
                            function (){
                            	var username=$('#pu').val(),
                                    me = $('#me').val(),
                            		password=$('#ppp').val(),
                            		balance=$('#pb').val();
                            		$.ajax({
                            			method:'POST',
                            			url:'../payit.com/api.payit.php',
                            			data:{
                            				username,password,balance
                            			}, beforeSend: function() {
                                        $("#msg").fadeOut();
                                        $("#pa").html('<span class="glyphicon glyphicon-transfer"></span>   جاري الإرسال ...');
                                            },
                            			success:function(one,two,three){
                                            if(one == 1){
                                                $("#msg").fadeIn(1000, function(){
                                                $("#msg").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-info-sign"></span> تم ! </div>');
                                                $("#pa").html('إرسال');
                                                });

                                                $.ajax({
                                                    method:'POST', 
                                                    url:'bal.php',
                                                    data:{balance,me},
                                                    success:function(one,two,three){
                                                        location="balance.php";
                                                        console.log(one);
                                                        console.log(two);
                                                        console.log(three);
                                                        
                                                    },error:function(one,two,three){
                                                        console.log(one);
                                                        console.log(two);
                                                        console.log(three);
                                                    }
                                                });
                                                // $.POST("bal.php",
                                                // {balance},                                               
                                                // function(data, status){
                                                //     alert("Data: " + data + "\nStatus: " + status);
                                                // });
                                                //$("#msg").html('success');
                                            }else if(one == 2){
                                                $("#msg").fadeIn(1000, function(){
                                                $("#msg").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> ليس لديك رصيد كافي </div>');
                                                $("#pa").html('إرسال');
                                                });
                                            }                                          
                                            else if(one == 0){
                                                $("#msg").fadeIn(1000, function(){
                                                $("#msg").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span>   خطأ في إسم المستخدم أو كلمة المرور </div>');
                                                $("#pa").html('إرسال');
                                                });
                                            }
                            				console.log(one);
                            				console.log(two);
                            				console.log(three);
                            			},
                            			error:function(one,two,three){
                                            
                            				console.log(one);
                            				console.log(two);
                            				console.log(three);
                            			}
                            			});
                                
                                
                            }
                        );
                            // for pay to ecommerce from payit.com
                          
     
                    </script>
                </div>
            </div>
        </div>


        










<!-- سحب المبغ من الموقع -->


<div id="id03" class="modal">       
            <div class="modal-content animate" style="background-color:#eee">
                <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
    
                <div class="pay text-center">
                    
                    <h1>Payit
                    <img src="Cpanel/upload/avatar/payit.png" width="50px" height="50px"/></h1>
                    <!-- <h3 style="font-weight:bold">
                    ادخل إسم المستخدم وكلمة المرور
                    </h3> -->
                    <!-- <form method="POST"> -->
                        <div id="msg1"></div>
                    <input class="form-control input-lg" id="pu1" type="text" placeholder="إسم المستخدم" required />
                    <input type="hidden" id="me1" value="<?php echo $_SESSION['user']?>" />
                    <input type="password" id="ppp1" class="form-control input-lg" placeholder="كلمة المرور" required />
                    <input class="form-control input-lg" id="pb1" type="number" min="0" max="1000" placeholder=" المبلغ المراد سحبه من الموقع" required />
                    <button class="btn btn-primary btn-block" id="pa1">إرسال</button>
                    <!-- </form> -->
                
                    <script>

                                            // for pay to ecommerce from payit.com
                        $('#pa1').click(
                            function (){
                            	var username1=$('#pu1').val(),
                                    me1 = $('#me1').val(),
                            		password1=$('#ppp1').val(),
                            		balance1=$('#pb1').val();
                            		$.ajax({
                            			method:'POST',
                            			url:'../payit.com/api.payit1.php',
                            			data:{
                            				username1,password1,balance1
                            			}, beforeSend: function() {
                                        $("#msg1").fadeOut();
                                        $("#pa1").html('<span class="glyphicon glyphicon-transfer"></span>   جاري الإرسال ...');
                                            },
                            			success:function(one,two,three){
                                            if(one == 1){
                                                $("#msg1").fadeIn(1000, function(){
                                                $("#msg1").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-info-sign"></span> تم ! </div>');
                                                $("#pa1").html('إرسال');
                                                });

                                                $.ajax({
                                                    method:'POST', 
                                                    url:'bal1.php',
                                                    data:{balance1,me1},
                                                    success:function(one,two,three){
                                                        location="balance.php";
                                                        console.log(one);
                                                        console.log(two);
                                                        console.log(three);
                                                        
                                                    },error:function(one,two,three){
                                                        console.log(one);
                                                        console.log(two);
                                                        console.log(three);
                                                    }
                                                });
                                                // $.POST("bal.php",
                                                // {balance},                                               
                                                // function(data, status){
                                                //     alert("Data: " + data + "\nStatus: " + status);
                                                // });
                                                //$("#msg").html('success');
                                            }else if(one == 2){
                                                $("#msg1").fadeIn(1000, function(){
                                                $("#msg1").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> لا يمكن سحب القيمة 0 </div>');
                                                $("#pa1").html('إرسال');
                                                });
                                            }
                                            else if(one == 0){
                                                $("#msg1").fadeIn(1000, function(){
                                                $("#msg1").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span>   خطأ في إسم المستخدم أو كلمة المرور </div>');
                                                $("#pa1").html('إرسال');
                                                });
                                            }
                            				console.log(one);
                            				console.log(two);
                            				console.log(three);
                            			},
                            			error:function(one,two,three){
                                            
                            				console.log(one);
                            				console.log(two);
                            				console.log(three);
                            			}
                            			});
                                
                                
                            }
                        );
                            // for pay to ecommerce from payit.com
                          
     
                    </script>
                </div>
            </div>
        </div>





<script>



    // Get the modal
    var modal = document.getElementById('id02');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }



</script>


        </div>
    </div>
</div>
<?php
    include $tpl . "footer.php";
  
    ob_end_flush();
?>