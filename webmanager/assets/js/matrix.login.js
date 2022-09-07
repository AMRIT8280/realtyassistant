
$(document).ready(function(){

	var login = $('#loginform');
	var recover = $('#recoverform');
	var speed = 400;

	$('#to-recover').click(function(){
		
		$("#loginform").slideUp();
		$("#recoverform").fadeIn();
	});
	$('#to-login').click(function(){
		
		$("#recoverform").hide();
		$("#loginform").fadeIn();
	});
	
	
	$('#to-login').click(function(){
	
	});
    
	setTimeout(function() {
		$('#hide_allert').hide('fast');
	}, 10000);
	setTimeout(function() {
		$('#hide_captcha').hide('fast');
	}, 10000);
			
	$('.login_valid').validate({
		rules: {
		  username: {
			required: true,
			rangelength: [4, 8]
		},
		  password: {
			required: true,
			minlength: 3
		}
		},
		messages: {
			username: {
				required: "Please provide a user name...!",
				rangelength: "Please enter a 4 to 8 characters long user name"
			},
			password: {
				required: "Please provide a password...!",
				minlength: "Your password must be at least 3 characters long"
			}
		},
		errorElement: 'label',
		errorPlacement: function (error, element) {
		  error.addClass('has-warning');
		  element.closest('.control-group').append(error);
		},
		highlight: function (element, errorClass, validClass) {
		  $(element).addClass('has-warning');
		  $(element).removeClass('has-success');
		},
		unhighlight: function (element, errorClass, validClass) {
		  $(element).removeClass('has-warning');
		  $(element).addClass('has-success');
		},
		success: function(span) {
			var messages = new Array(
				"That's Great!",
				"Looks good!",
				"You got it!",
				"Great Job!",
				"Smart!",
				"That's it!",
				"Cool!",
				"Nice!",
				"Done!"
			);
			var num = Math.floor(Math.random()*9); 

			span.text(messages[num]).removeClass("has-warning");
			span.text(messages[num]).css("color","green");

		},
		 submitHandler: function(form) {
			form.submit();
		}
	  });
	$('.recover_valid').validate({
		rules: {
		  email: 'required email'
		},
		messages: {
			email: {
			required: "Please enter a email address...!"
			}
		},
		errorElement: 'label',
		errorPlacement: function (error, element) {
		  error.addClass('has-warning');
		  element.closest('.controls').append(error);
		},
		highlight: function (element, errorClass, validClass) {
		  $(element).addClass('has-warning');
		  $(element).removeClass('has-success');
		},
		unhighlight: function (element, errorClass, validClass) {
		  $(element).removeClass('has-warning');
		  $(element).addClass('has-success');
		},
		success: function(span) {
			var messages = new Array(
				"That's Great!",
				"Looks good!",
				"You got it!",
				"Great Job!",
				"Smart!",
				"That's it!",
				"Cool!",
				"Nice!",
				"Done!"
			);
			var num = Math.floor(Math.random()*9); 

			span.text(messages[num]).removeClass("has-warning");
			span.text(messages[num]).css("color","green");

		},
		 submitHandler: function(form) {
			form.submit();
		}
	});
});