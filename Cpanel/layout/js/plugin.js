$(function (){

	'use strict';

	// Dashboard

	$('.toggle-info').click(function (){

		$(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);

		if($(this).hasClass('selected')){

			$(this).html('<i class="fa fa-minus fa-lg"></i>');
		}else{

			$(this).html('<i class="fa fa-plus fa-lg"></i>');
		}
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

});

 // add asterisk to the required feilds

 $('input').each(function (){

 	if($(this).attr('required') === 'required'){

 		$(this).after('<span class="asterisk">*</span>');
 	}

 });

 // convert password field into text when hover

 	var PassField = $('.password');

 $('.show-pass').hover( function (){

 	PassField.attr('type' , 'text');

 }, function (){
 	
 	PassField.attr('type' , 'password');

 });

 	// Confirmation Message 

 	$('.confirm').click(function() {
 		
 		return confirm('are you sure?');
 	});


	//  category view option

	$('.cat h3').click(function (){

		$(this).next('.full-view').fadeToggle(200);
	});

	// full and classic view opiton
	
	$('.option span').click(function (){

		$(this).addClass('active').siblings('span').removeClass('active');

		if($(this).data('view') === 'full'){

			$('.cat .full-view').fadeIn(200);
		}else{

			$('.cat .full-view').fadeOut(200);
		}

		
	});

	$('.child-link').hover( function (){

		$(this).find('.show-delete').fadeIn(400);
	},function(){

		$(this).find('.show-delete').fadeOut(400);
	});
	
// focus on the username field when load the page
/*
$(window).load(function (){


	'use strict';

	$('input:first-of-type').focus();
});
*/