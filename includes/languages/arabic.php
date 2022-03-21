<?php

	function lang( $phrase ){

		static $lang = array(
			
			// navbar links
			"Home_Admin" 	=> "لوحة التحكم",
			"CATEGORIES"	=> "الاصناف",
			"ITEMS"			=> "المنتجات",
			"MEMBERS"		=> "الاعضاء",
			"COMMENTS" 		=> "التعليقات",
			"STATISTICS"	=> "الإحصائات",
			"LOGS"			=> "مخطوطة",
			"dashboard"		=> "لوحة التحكم",

			// Dropdown Links
			"PROFILE"		=> "الملف الشخصي",
			"SETTINGS" 		=> "الإعدادات",
			"OUT" 			=> "تسجيل خروج",

			//information
			"login" 		=> "تسجيل الدخول",
			"signup"		=> "التسجيل",
			"information"	=> "المعلومات",
			"services"		=> "الخدمات",
			"name"			=> "الإسم",
			"description"	=> "الوصف",
			"ordering"		=> "الترتيب",
			"email"			=> "البريد الإلكتروني",
			"fullname"		=> "الإسم كامل",
			"register_date"	=> "تاريخ التسجيل",
			"edit_information"	=> "تعديل المعلومات",
			"username" 		=> "إسم المستخدم",
			"service_provider" => "مقدم  الخدمة",
			"password" 		=> "كلمة المرور",

			// dashboard

			"total"			=> "جميع الأعضاء",
			"pending" 		=> "بإنتظار الموافقة",
			"edit"			=> "تعديل",
			"delete"		=> "حذف",
			"activate" 		=> "تنشيط",
			"approve"		=> "تفعيل",
			"price"			=> "السعر",
			"date"			=> "التاريخ",
			"category"		=> "الصنف",
			"comment"		=> "تعليق",
			// navbar links
			"Home_Admin" 	=> "مشرف",
			"CATEGORIES"	=> "الاصناف",
			"ITEMS"			=> "المصطلحات",
			"MEMBERS"		=> "الاعضاء",
			"COMMENTS" 		=> "التعليقات",
			"STATISTICS"	=> "الإحصائات",
			"LOGS"			=> "مخطوطة",

			// Dropdown Links
			"PROFILE"			=> "الملف الشخصي",
			"SETTINGS" 			=> "الإعدادات",
			"Logout" 			=> "تسجيل الخروج",

			// The Library

			"Login" 			=> "تسجيل الدخول",
			"SignUp"			=> "التسجيل",
			"information"		=> "المعلومات",
			"services"			=> "الخدمات",
			"name"				=> "الإسم",
			"email"				=> "البريد الإلكتروني",
			"fullname"			=> "الإسم كامل",
			"register_date"		=> "تاريخ التسجيل",
			"edit_information"	=> "تعديل المعلومات",
			"home"				=> "الصفحة الرئيسية",
			"add_service" 		=> "إضافة خدمة",
			"register"			=> "تسجيل",
			"enter"				=> "دخول",
			"image"				=> "الصورة",
			"balance"			=> "الرصيد",
			"contact"			=> "تواصل مع البائع"
			
		);

		return $lang[$phrase];
	}


 