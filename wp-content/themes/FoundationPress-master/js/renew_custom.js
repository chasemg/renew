(function($) {

	var stickyRibbonTop = $('#sticky-nav').offset().top;

	$(window).scroll(function(){
		if( $(window).scrollTop() > stickyRibbonTop ) {
			$('#sticky-nav').css({position: 'fixed', top: '0px'});
		} else {
			$('#sticky-nav').css({position: 'absolute', top: '20px'});
		}
	});	
	
	$('.tri_left').imageScroll({
		image: null,
		imageAttribute: 'image',
		container: $('.triangles-left'),
		speed: 1.5,
		coverRatio: 0.75,
		holderClass: 'left_img',
		holderMinHeight: 674,
		extraHeight: 500,
	//	mediaWidth: 1,
		mediaHeight: 0,
		parallax: true,
		touch: false
	});	
	$('.tri_right').imageScroll({
		image: null,
		imageAttribute: 'image',
		container: $('.triangles-right'),
		speed: 1.5,
		coverRatio: 0.75,
		holderClass: 'right_img',
		holderMinHeight: 674,
		extraHeight: 500,
	//	mediaWidth: 1,
		mediaHeight: 0,
		parallax: true,
		touch: false
	});	
	function scrollToAnchor(aid){
		var aTag = $("#"+ aid +"");
		var wWidth = $(window).width();
		var wHeight = $(window).height();
		topMargin = wHeight/2 - aTag.height()/2;
		$('html,body').animate({scrollTop: aTag.offset().top - topMargin},'slow');
	}
	$(".faq_scroll").click(function()	{
		var scrollId = $(this).attr('id');
		scrollToAnchor('easy-faq-'+scrollId);
	});
	$(".scroll_to").click(function()	{
		var scrollId = $(this).attr('id');
		scrollToAnchor('scroll_to_'+scrollId);
	});	
	
/*********************** Plus animation *******************************************/
	
$.fn.is_on_screen = function(){
    var win = $(window);
    var viewport = {
        top : win.scrollTop(),
        left : win.scrollLeft()
    };
    viewport.right = viewport.left + win.width();
    viewport.bottom = viewport.top + win.height();
 
    var bounds = this.offset();
    bounds.right = bounds.left + this.outerWidth();
    bounds.bottom = bounds.top + this.outerHeight();
 
    return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
};

var scroll_to_bottom = function(element){
    var tries = 0, old_height = new_height = element.height();
    var intervalId = setInterval(function() {
        if( old_height != new_height ){    
            // Env loaded
            clearInterval(intervalId);
            element.animate({ scrollTop: new_height }, 'slow');
        }else if(tries >= 30){
            // Give up and scroll anyway
            clearInterval(intervalId);
            element.animate({ scrollTop: new_height }, 'slow');
        } else {
            new_height = content.height();
            tries++;
        }
    }, 100);
}	
if( $('.plus').length > 0 ) { // if target element exists in DOM
	if( $('.plus img').is_on_screen() ) { // if target element is visible on screen after DOM loaded
		console.log('visable');
	} else {
        console.log('not visable');
	}
}

//var eTop = $('.plus img').offset().top;
//console.log(eTop - $(window).scrollTop());

/*
$(window).scroll(function(){ // bind window scroll event
	if( $('.plus').length > 0 ) { // if target element exists in DOM
		if( $('.plus img').is_on_screen() ) { // if target element is visible on screen after DOM loaded
			var plusImg = $('.plus').offset().top;
			var toplimit = $(window).height()/3;
			var bottomlimit = $(window).height()/1.5;
			var plusPos = eTop - $(window).scrollTop();
			//console.log(bottomlimit);
			$('.benefit_left').each(function()	{
				if(toplimit >= plusPos)	{
					if($(this).offset().top >= toplimit)	{
						var nextBenefit = $(this).next().offset().top;
						$('.plus').animate({
							top: nextBenefit +'px'
						});
					}
				} else if(bottomlimit <= plusPos)	{
					if($(this).offset().top <= toplimit)	{
						var prevBenefit = $(this).prev().offset().top;
						$('.plus').animate({
							top: prevBenefit + 'px'
						});
					}
				} else {
					console.log('no');
				}
			});
			//console.log(plusImg);
		} else {
			
		}
	}
});
*/
	$("#validate_address").click(function()	{
		$('#street').removeClass('error_hightlight');
		$('#city').removeClass('error_hightlight');
		$('#state').removeClass('error_hightlight');
		$('#zip').removeClass('error_hightlight');
		$('#fname').removeClass('error_hightlight');
		$('#lname').removeClass('error_hightlight');
		$('#primary_phone').removeClass('error_hightlight');
		$('#mobil_phone').removeClass('error_hightlight');
		$('#ssn').removeClass('error_hightlight');
		$('#dob').removeClass('error_hightlight');
		$('#email_address').removeClass('error_hightlight');
		$('#email_verified').removeClass('error_hightlight');
		$('#username').removeClass('error_hightlight');
		var street_one = $('#street').val();
		var street_two = $('#street_two').val();
		var street = street_one + ", " + street_two;
		var city = $('#city').val();
		var state = $('#state').val();
		var zip = $('#zip').val();
		var fname = $('#fname').val();
		var lname = $('#lname').val();
		var primary_phone = $('#primary_phone').val();
		var mobil_phone = $('#mobil_phone').val();
		var ssn = $('#ssn').val();
		var dob = $('#dob').val();
		var username = $('#username').val();

		/************** Validate first page **********************/
		
		if(street == '')	{
			$('#street').addClass('error_hightlight');
			scrollToAnchor('street');
			return false;
		}
		if(city == '')	{
			$('#city').addClass('error_hightlight');
			scrollToAnchor('city');
			return false;
		}		
		if(state == '')	{
			$('#state').addClass('error_hightlight');
			scrollToAnchor('state');
			return false;
		}	
		if(zip == '')	{
			$('#zip').addClass('error_hightlight');
			scrollToAnchor('zip');
			return false;
		}		
		if(fname == '')	{
			$('#fname').addClass('error_hightlight');
			scrollToAnchor('fname');
			return false;
		}		
		if(lname == '')	{
			$('#lname').addClass('error_hightlight');
			scrollToAnchor('lname');
			return false;
		}	
		if(primary_phone == '')	{
			$('#primary_phone').addClass('error_hightlight');
			scrollToAnchor('primary_phone');
			return false;
		}		
		if(mobil_phone == '')	{
			$('#mobil_phone').addClass('error_hightlight');
			scrollToAnchor('mobil_phone');
			return false;
		}	
		if(ssn == '')	{
			$('#ssn').addClass('error_hightlight');
			scrollToAnchor('ssn');
			return false;
		}	
		if(dob == '')	{
			$('#dob').addClass('error_hightlight');
			scrollToAnchor('dob');
			return false;
		}			

		/******************** Email address validation for account *************************************/
		var email = $("#email_address").val();
		if(username == '')	{
			$("#username").addClass('error_hightlight');
			return false;
		}
		var emailVerified = $("#email_verified").val();
		if(email == '')	{
			$("#email_address").addClass('error_hightlight');
		}	
		if(emailVerified == '')	{
			$("#email_verified").addClass('error_hightlight');
		}				
		var match = false;
		if(email == emailVerified)	{
			console.log('Emails match!');
			match = true;
		} else {
			$("#email_address").addClass('error_hightlight');
			$("#email_verified").addClass('error_hightlight');
			scrollToAnchor('email_address');
			console.log('emails do not match');
		}
		if(match == true)	{
			$.ajax({
				type: 'POST',
				data: 'username='+username+'&email='+email,
				url: 'wp-content/themes/FoundationPress-master/parts/account_registration_check.php',
				success: function(success)	{
					console.log(success);
					if(success == 11)	{
						console.log("valid email address");
						$.ajax({
							type: 'POST',
							data: 'street='+street+'&city='+city+'&state='+state+'&zip='+zip+'&fname='+fname+'&lname='+lname+'&dob='+dob+'&ssn='+ssn+'&mobil_phone='+mobil_phone+'&primary_phone='+primary_phone+'&email='+email+'&username='+username,
							url: 'wp-content/themes/FoundationPress-master/parts/address_validation.php',
							success: function(success)	{
								$('#form_two').html(success);
								$("#form_one").slideUp();
								$("#form_two").delay(1000).slideDown(function() {
									var hiddenContent = $("#type").val();
									if(hiddenContent == 'street_address')	{
										//console.log(hiddenContent);
										$('#map_canvas').animate({
											height: "550px"
										},200);					
										$('.header_image').animate({
											height: "0px"
										}, 200);
										$('.row_container').animate({
											marginTop: "0px"
										}, 200);				
										$("#map_canvas").show();
										$('.header_map').animate({
											height: "550px",
											maxHeight: "550px"
										},200);	
									} else {
										$('#map_canvas').animate({
											height: "0px"
										},200);							
										$('.header_map').animate({
											height: "0px"
										},200);
										$('.header_image').animate({
											height: "550px"
										}, 200);							
										$('#form_two').append("<div>We could not validate your address. Please go back and verify the address you entered.</div><button id='validate_back'>Go Back</button>");
										$("#validate_back").click(function()	{
											$('#map_canvas').animate({
												height: "0px"
											},200);							
											$('.header_map').animate({
												height: "0px"
											},200);
											$('.header_image').animate({
												height: "550px"
											}, 200);	
											$("#form_two").delay(200).slideUp(function() {
												$("#form_one").delay(200).slideDown();
											});							
										});
									}
								$("#go_to_payment").click(function()	{
									var b = 0;
									$(".doctor input[type='radio']").each(function()	{
										if($(this).is(':checked'))	{
											b++;
										}
									});	
									if(b > 0)	{
										$("#form_two").slideUp();
										$("#form_three").delay(1000).slideDown();
									} else {
										return false;
									}
								});
								$("#same_info").change(function()	{
									if(this.checked)	{
										var fname = $("#fname").val();
										var lname = $("#lname").val();
										var street = $("#street").val();
										var street_two = $("#street_two").val();
										var city = $("#city").val();
										var state = $("#state").val();
										var zip = $("#zip").val();
										var email = $("#email_address").val();
										var phone = $("#primary_phone").val();
										$("#billing_fname").val(fname);
										$("#billing_lname").val(lname);
										$("#billing_street").val(street);
										$("#billing_street_two").val(street_two);
										$("#billing_city").val(city);
										$("#billing_state").val(state);
										$("#billing_zip").val(zip);
										$("#billing_phone").val(phone);
										$("#billing_email").val(email);
									} else {
										$("#billing_fname").val('');
										$("#billing_lname").val('');
										$("#billing_street").val('');
										$("#billing_street_two").val('');
										$("#billing_city").val('');
										$("#billing_state").val('');
										$("#billing_zip").val('');
										$("#billing_phone").val('');
										$("#billing_email").val('');
									}
								});
								$("#enroll_patient").click(function()	{
									$('.payment_options label').css('color','#4d4d4d');
									var v = 0;
									var x = 0;
									$('.payment_options input[type="radio"]').each(function()	{
										if($(this).is(":checked"))	{
											x++;
										}
									});
								//	console.log(x);
									if(x == 0)	{
										$('.payment_options label').css('color','#ff0000');
										return false;
									}
									$("#form_three input[type='text']").each(function()	{
										var inputId = $(this).attr('id');
										$('#'+inputId).removeClass('error_hightlight');
									});
									$("#form_three input[type='text']").each(function()	{
										if($(this).val() == '')	{

											var inputId = $(this).attr('id');
											if(inputId != 'billing_street_two')	{
												$('#'+inputId).addClass('error_hightlight');
												v++;
											}
										}
									});
									if(v > 0)	{
										return false();
									} else {
										$("#form_three input[type='text']").each(function()	{
											var inputId = $(this).attr('id');
											$('#'+inputId).removeClass('error_hightlight');
										});
										var one = 0;
										var dataString = '';
										$("#form_one input").each(function()	{
											var input_name = $(this).attr('id');
											var input_value = $(this).val();
											if(one == 0)	{
												dataString += input_name + "=" + input_value;
											} else {
												dataString += "&" + input_name + "=" + input_value;
											}
											one++;
										});
										
										$(".doctor input[type='radio']").each(function()	{
											if($(this).is(':checked'))	{
												var input_name = $(this).attr('id');
												var input_value = $(this).val();
												dataString += "&" + input_name + "=" + input_value;
											}
										});								
										$(".calculate_costs input[type='hidden']").each(function()	{
											var input_name = $(this).attr('id');
											var input_value = $(this).val();
											dataString += "&" + input_name + "=" + input_value;
										});
										$("#form_three input[type='text']").each(function()	{
											var input_name = $(this).attr('id');
											var input_value = $(this).val();
											dataString += "&" + input_name + "=" + input_value;
										});
										$("#form_three input[type='radio']").each(function()	{
											if($(this).is(':checked'))	{
												var input_name = $(this).attr('id');
												var input_value = $(this).val();
												dataString += "&" + input_name + "=" + input_value;
											}
										});								
										console.log(dataString);
										var ssn = $("#ssn").val();
										$.ajax({
											type: 'POST',
											data: 'ssn='+ssn,
											url: 'wp-content/themes/FoundationPress-master/parts/enroll_process.php',
											success: function(success)	{
												$("#enroll_result").html(success);
											},
											error: function(error)	{
												console.log(error);
											}
										});					
									//console.log("Enrolled!");
									}
								});		
								
								});
							},
							error: function(error)	{
								console.log(error);
							}
						});
					} else if(success == 10) {
						scrollToAnchor('username');
						$("#username").addClass('error_hightlight');
						$("#email_error").html('Username already taken. Please choose another.');
						$("#email_error").show();
						$("#email_error").delay(5000).fadeOut();
						return false;
					} else if(success == 01) {
						scrollToAnchor('email_address');
						$("#username").removeClass('error_hightlight');
						$("#username").addClass('error_hightlight');
						$("#email_address").addClass('error_hightlight');
						$("#email_verified").addClass('error_hightlight');						
						$("#email_error").html('Email address already registered.');
						$("#email_error").show();
						$("#email_error").delay(5000).fadeOut();
						return false;
					} else {
						scrollToAnchor('username');
						$("#username").addClass('error_hightlight');
						$("#email_address").addClass('error_hightlight');
						$("#email_verified").addClass('error_hightlight');
						$("#email_error").html('The username and email address you have chosen are already registered.');
						$("#email_error").show();
						$("#email_error").delay(5000).fadeOut();
						//console.log("Email already taken.");
						return false;
					}					
				},
				error:	function(error)	{
					console.log(error);
				}
			});
		}	
	});
	
/******************************************************/
function checkPasswordStrength( $pass1,
                                $pass2,
                                $strengthResult,
                                $submitButton,
                                blacklistArray ) {
    var pass1 = $pass1.val();
    var pass2 = $pass2.val();
 
    // Reset the form & meter
    $submitButton.attr( 'disabled', 'disabled' );
        $strengthResult.removeClass( 'short bad good strong' );
 
    // Extend our blacklist array with those from the inputs & site data
    blacklistArray = blacklistArray.concat( wp.passwordStrength.userInputBlacklist() )
 
    // Get the password strength
    var strength = wp.passwordStrength.meter( pass1, blacklistArray, pass2 );
 
    // Add the strength meter results
    switch ( strength ) {
 
        case 2:
            $strengthResult.addClass( 'bad' ).html( pwsL10n.bad );
            break;
 
        case 3:
            $strengthResult.addClass( 'good' ).html( pwsL10n.good );
            break;
 
        case 4:
            $strengthResult.addClass( 'strong' ).html( pwsL10n.strong );
            break;
 
        case 5:
            $strengthResult.addClass( 'short' ).html( pwsL10n.mismatch );
            break;
 
        default:
            $strengthResult.addClass( 'short' ).html( pwsL10n.short );
 
    }
 
    // The meter function returns a result even if pass2 is empty,
    // enable only the submit button if the password is strong and
    // both passwords are filled up
    if ( 4 === strength && '' !== pass2.trim() ) {
        $submitButton.removeAttr( 'disabled' );
    }
    return strength;
}
 
$(document).ready(function() {
    // Binding to trigger checkPasswordStrength

    $( 'body' ).on( 'keyup', 'input[name=password1], input[name=password2]',
        function( event ) {
            checkPasswordStrength(
                $('input[name=password]'),         // First password field
                $('input[name=password_retyped]'), // Second password field
                $('#password-strength'),           // Strength meter
                $('input[type=submit]'),           // Submit button
                ['black', 'listed', 'word']        // Blacklisted words
            );
        }
    );
});	
})(jQuery);