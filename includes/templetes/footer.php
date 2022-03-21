		
		 <!-- Start Ultimate Footer Section -->
        
		 <section class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <h3>روابط الموقع</h3>
                        <ul class="list-unstyled three-columns">
                            <li><a href="#">الرئيسية</a></li>
                            <li><a href="guide.php">عمل الموقع</a></li>
                            <li><a href="polices.php">سياسات الموقع</a></li>
                            <li><a href="#">برمجة</a></li>
                            <li><a href="#">تصميم</a></li>
                            <li><a href="#">إستضافة</a></li>
                            <li><a href="#">حلول</a></li>
                            <li><a href="#">خريطة الموقع</a></li>
                            <li><a href="contact.php">راسلنا</a></li>
                        </ul>
                        <ul class="list-unstyled social-list">
                            <li><img src="Cpanel/upload/img/social-bookmarks/facebook.png" width="48" height="48" alt="Facebook" /></li>
                            <li><img src="Cpanel/upload/img/social-bookmarks/gplus.png" width="48" height="48" alt="Google Plus" /></li>
                            <li><img src="Cpanel/upload/img/social-bookmarks/twitter.png" width="48" height="48" alt="Twitter" /></li>
                            <li><img src="Cpanel/upload/img/social-bookmarks/pinterest.png" width="48" height="48" alt="Pinterest" /></li>
                            <li><img src="Cpanel/upload/img/social-bookmarks/rss.png" width="48" height="48" alt="Rss" /></li>
                            <li><img src="Cpanel/upload/img/social-bookmarks/email.png" width="48" height="48" alt="Email" /></li>
                        </ul>


                        <div class="text-right"> 
                            <div>
                            <span >البريد الإلكتروني:  </span>
                                <span id="emailid">
                                    <?php 
                                        echo getOneFrom('email','settings','WHERE id=1')['email'];
                                    ?>
                                </span>
                                
                            </div>
                            <div>
                            <span >الجوال:  </span> 
                                <span id="teleid">
                                    <?php 
                                        echo getOneFrom('tel','settings','WHERE id=1')['tel'];
                                    ?>
                                </span>
                                
                            </div>
                        </div>
                    </div>

                        <!-- Email and Telephone -->

                        

                    <div class="col-lg-4 col-md-6">
                        <h3>أحدث الخدمات</h3>
                            <?php
                            
                            $all = getAllFrom('*','items','where Approve = 1','','item_ID DESC','LIMIT 3 ');
                            foreach($all as $item){
                                if($item['Approve'] == 1){
                                   ?>
                        <div class="media" style="height:70px">
                        <a href='items.php?itemid=<?php echo $item["item_ID"]?>'>
                            <div class="pull-left" >
                                <img class="media-object" src="<?php echo (!empty($item['Image']))? 'Cpanel/upload/items/'.$item['Image'] : 'Cpanel/upload/img/articles/01.jpg' ?>" width="64" height="64" alt="Image 01" />
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    <?php echo $item['Name'];?>
                                </h4>
                                <?php echo $item['Description'];?>
                            </div>
                            </a>
                        </div>
                        
                                    <?php }}?>
                        
                        
                            
                    </div>
                    <div class="col-lg-4">
                        <h3>وسائل الدفع الإلكتروني</h3>
                        <img class="img-thumbnail" src="Cpanel/upload/img/payit.png" style="width:40%;height:80px" alt="Image 01" />
                        <img class="img-thumbnail" src="Cpanel/upload/img/icon_visa.gif" style="width:40%;height:100px" alt="Image 02" />
                        <img class="img-thumbnail" src="Cpanel/upload/img/icon_mastercard.gif" style="width:40%;height:100px" alt="Image 03" />
                        <img class="img-thumbnail" src="Cpanel/upload/img/icon_paypal.gif" style="width:40%;height:100px"  alt="Image 04" />
                    </div>
                </div>
            </div>
            <div style="font-weight:bold" class="copyright text-center">
            <!-- <span>جميع الحقوق محفوظة</span> &copy; 2020   -->
            <span>صنع بـ</span>
                    <i class="fa fa-heart fa-lg" style="color:red"></i>
                    <span> من فريق CS Team</span>
                     <!-- <span>© 2020</span>   -->        
            </div>
           </section>
        
        <!-- End Ultimate Footer Section -->

		<script src="<?php echo $js;?>jquery.nicescroll.min.js"></script>
		<script src="<?php echo $js;?>jquery-ui.min.js"></script>
		<script src="<?php echo $js;?>bootstrap.min.js"></script>
		<script src="<?php echo $js;?>jquery.selectBoxIt.min.js"></script>
		<script src="<?php echo $js;?>front-plugin.js"></script>
		<script src="<?php echo $js;?>bootstrap-tagsinput.min.js"></script>
		
	</body>
</html>
