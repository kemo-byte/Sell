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
			"transactions" => "العمليات في الموقع",

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
			"password" 		=> "كلمة المرور",
			"save" 				=> "حفظ",
			// dashboard

			"total"			=> "جميع الأعضاء",
			"pending" 		=> "بإنتظار الموافقة",
			"edit"			=> "تعديل",
			"delete"		=> "حذف",
			"activate" 		=> "تنشيط",
			"deactivate" 		=> "حظر",
			"approve"		=> "تفعيل",
			"price"			=> "السعر",
			"date"			=> "التاريخ",
			"category"		=> "الصنف",
			"comment"		=> "تعليق",
			"balance"		=> "الرصيد"
			

			
		);

		return $lang[$phrase];
	}
 