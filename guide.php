<?php

	/*
	=====================================================
	== 
	=====================================================
	*/
		ob_start();

		session_start();

	
		
		$pageTitle = 'السياسات والخصوصية ';

		include "init.php";
        
         ?>
		
		<style>

		.wo > h2 {
			color:#333;
		}
		.wo {
			transition:all 1s ease-in-out;
			margin-top:50px;
			margin-bottom:50px;
			border: 1px solid #000;
			background-color: #eee;
			font-size:1.2em
		}
		.wo:hover{
			background-color: #ddd;
		}
		.wo h2 {
			text-shadow: 0px 2px #8e44ad;
		}
		.wo .woo{
			border:1px solid;
			width:60%;
			margin-right:22%;
			border-radius:40px 0 40px 0;
			padding:10px;
			margin-bottom: 10px;
		}
		.wo .woo:last-child{
			margin-bottom:5%;
		}
		</style>
<div class="container wo text-center">

<h2>
كيف يعمل الموقع؟
</h2>

<div class="woo">
<h4>
<h3>
إستعرض الخدمات
</h3>
إبحث عن الخدمة التي تحتاجها في مربع البحث
أو أكتبها في طلبات الخدمة غير الموجودة


</h4>
</div>

<div class="woo">
<h4>
<h3>
إستلم خدمتك
</h3>
تواصل مع البائع مباشرة داخل الموقع
حتى إستلام طلبك كاملاً

</h4>
</div>
<div class="woo">
<h4>


<h3>
أطلب الخدمة
</h3> 
راجع وصف الخدمة جيداً وإقرأ تعليقات العملاء
السابقين قبل طلب الخدمة

</h4>

</div>
</div>

    <?php
	    include $tpl . "footer.php";

	
	ob_end_flush();
?>