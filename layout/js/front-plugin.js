$(function (){

	'use strict';


	var winH 	= $(window).height(),
		upperH	= $('.upper-bar').innerHeight(),
		navH 	= $('.navbar').innerHeight();
	$('.header').height(winH - (upperH + navH));
	// tags
	//$("input").val()	

	//$("input").tagsinput('items')

	// switch between login and signup

	$('.arrow').click(function(){$('html, body').animate({

	scrollTop: $('.home').offset().top
	

  }, 1000);
});

	// function u(){
	// 	$.ajax({
	// 		method:'POST',
	// 		url:'ins.php',
	// 		success:function(one,two,three){
	// 			console.log(one);
	// 			console.log(two);
	// 			console.log(three);
	// 		},
	// 		error:function(one,two,three){
	// 			console.log(one);
	// 			console.log(two);
	// 			console.log(three);
	// 		}
	// 		});
	// }
	// $('#u').click(function(){
	// 	u();
	// });



	// for pay to ecommerce from payit.com
// $('#pa').onclick  = 
	// function (){
	// 	var username=$('#pu').val(),
	// 		password=$('#ppp').val(),
	// 		balance=$('#pb').val();
	// 		$.ajax({
	// 			method:'POST',
	// 			url:'api.payit.php',
	// 			data:{
	// 				username,password,balance
	// 			},
	// 			success:function(one,two,three){
	// 				console.log(one);
	// 				console.log(two);
	// 				console.log(three);
	// 			},
	// 			error:function(one,two,three){
	// 				console.log(one);
	// 				console.log(two);
	// 				console.log(three);
	// 			}
	// 			});
		
		
	// }
	// for pay to ecommerce from payit.com
	




	var scrollButton = $("#scroll-top");
// Caching The Scroll Top Element
    
$(window).scroll(function () {
        
	if ($(this).scrollTop() >= 85) {
		
		scrollButton.css('right', '30px');
		$('.arrow').fadeOut();

		
	} else {
		
		scrollButton.css('right', '-70px');
		$('.arrow').fadeIn();
	}
});

// Click On Button To Scroll Top

scrollButton.click(function () {
	
	$("html,body").animate({ scrollTop : 0 }, 600);
	

});
	// Trigger Nice Scroll Plugin
    
    $('html').niceScroll({
        
		// cursorcolor: '#f7600e',
		cursorcolor: '#8e44ad',
        cursorwidth: 10,
		cursorborderradius: 50,
		cursorborder: '1px solid #8e44ad'

        // cursorborder: '1px solid #f7600e'
        
    });
	
	// tags
	//$("input").val()	

	//$("input").tagsinput('items')

	// switch between login and signup

	$(".login-page h1 span").click( function (){

		$(this).addClass('selected').siblings().removeClass('selected');

		$('.login-page form').hide();

		$("." + $(this).data('class')).fadeIn(100);
		//console.log(("." + $(this).data('class')));
	});
	
	// Tigger the Select Box

	$('select').selectBoxIt({

		autoWidth:false
	});

	// Hide placeholder on form focus

	$('[placeholder]').focus(function (){

		$(this).attr('data-text', $(this).attr('placeholder'));

		$(this).attr('placeholder', '');
	}).blur(function (){

		$(this).attr('placeholder', $(this).attr('data-text'));
	});


	$('#check').click(function (){

		$(this).toggleClass('active').next('span').text('إخفاء كلمة المرور');
		

		if($(this).hasClass('active')){

			$('#loginpassword').attr('type', 'text');
			$(this).next('span').text('إخفاء كلمة المرور');
		}else{

			$('#loginpassword').attr('type', 'password');
			$(this).next('span').text('عرض  كلمة المرور');

		}
	});

});

 // add asterisk to the required feilds

 $('input').each(function (){

 	if($(this).attr('required') === 'required'){

 		$(this).after('<span class="asterisk">*</span>');
 	}

 });


 	// Confirmation Message 

 	$('.confirm').click(function() {
 		
 		return confirm('are you sure?');
 	});


	$(".live").keyup(function (){

		$($(this).data("class")).text($(this).val());
		
		//$(".live-preview .caption h3").text($(this).val());
	});
	

// focus on the username field when load the page
/*
$(window).load(function (){


	'use strict';

	$('input:first-of-type').focus();
});
*/

// show password
// var a =document.getElementById('check'),
// 	p = document.getElementById('loginpassword');

// a.onclick = function(){
// 	console.log(a.checked);
// if(a.checked == true){
// 	p.setAttribute('type', 'text');
// }else{
// 	p.setAttribute('type', 'password');
// }
// };




// scroll top
// let n = document.getElementById('nav');
// window.onscroll= function(){
// 	       if (window.pageYOffset >= 85){
// 			//    display the scroll to top button
// 				n.classList.add('navbar-fixed-top');
// 			console.log(this.pageYOffset);
// 			}else{
// 				n.classList.remove('navbar-fixed-top');
// 			}
// };



// Real Time Application - online
 
$(document).ready(function(){

fetch_user();
fetch_notify();
fetch_admin();
// fetch_one();

setInterval(function(){
 update_last_activity();
 fetch_user();
 fetch_admin();
//  fetch_one();
 fetch_notify();
 update_chat_history_data();
}, 5000);

 function fetch_user()
 {
  $.ajax({
   url:"fetch_user.php",
   method:"POST",
   success:function(data){
    $('#user_details').html(data);
   }
  })
 }

 function fetch_admin()
 {
  $.ajax({
   url:"fetch_admin.php",
   method:"POST",
   success:function(data){
    $('#user_details1').html(data);
   }
  })
 }

 


 function fetch_notify()
 {
  $.ajax({
   url:"fetch_notify.php",
   method:"POST",
   success:function(data){
    $('#noti').html(data);
   }
  })
 }

 function update_last_activity()
 {
  $.ajax({
   url:"update_last_activity.php",
   success:function()
   {

   }
  })
 }

 function make_chat_dialog_box(to_user_id, to_user_name)
 {
  var modal_content = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" title=" '+to_user_name+'">';
  modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
  modal_content += fetch_user_chat_history(to_user_id);
  modal_content += '</div>';
  modal_content += '<div class="form-group">';
  modal_content += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control"></textarea>';
  modal_content += '</div><div class="form-group" align="right">';
  modal_content+= '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat">Send</button></div></div>';
  $('#user_model_details').html(modal_content);
 }

 $(document).on('click', '.start_chat', function(){
  var to_user_id = $(this).data('touserid');
  var to_user_name = $(this).data('tousername');
  make_chat_dialog_box(to_user_id, to_user_name);
  $("#user_dialog_"+to_user_id).dialog({
   autoOpen:false,
   width:400
  });
  $('#user_dialog_'+to_user_id).dialog('open');
 });

 $(document).on('click', '.send_chat', function(){
  var to_user_id = $(this).attr('id');
  var chat_message = $('#chat_message_'+to_user_id).val();
  $.ajax({
   url:"insert_chat.php",
   method:"POST",
   data:{to_user_id:to_user_id, chat_message:chat_message},
   success:function(data)
   {
    $('#chat_message_'+to_user_id).val('');
    $('#chat_history_'+to_user_id).html(data);
   }
  })
 });

 function fetch_user_chat_history(to_user_id)
 {
  $.ajax({
   url:"fetch_user_chat_history.php",
   method:"POST",
   data:{to_user_id:to_user_id},
   success:function(data){
    $('#chat_history_'+to_user_id).html(data);
   }
  })
 }

 function update_chat_history_data()
 {
  $('.chat_history').each(function(){
   var to_user_id = $(this).data('touserid');
   fetch_user_chat_history(to_user_id);
  });
 }

 $(document).on('click', '.ui-button-icon', function(){
  $('.user_dialog').dialog('destroy').remove();
 });
 
});  