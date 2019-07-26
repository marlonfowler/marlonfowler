$(document).ready(function() {
	$('form #response').hide();
	
	
	$('.button').click(function(e) {
		
		e.preventDefault();
	
		var valid = '';
		var required = ' is required.';
		var first = $('form #first').val();
		var last = $('form #last').val();
		var email = $('form #email').val();
		var message = $('form #message').val();
		var tempt = $('form #tempt').val();
		var tempt2 = $('form #tempt2').val();
		
		if (first = '' || first.length <= 1) {
			valid += '<p>Your first name' + required + '</p>';
		}
		
		if (last = '' || last.length <= 1) {
			valid += '<p>Your last name' + required + '</p>';
		}
		
		if (!email.match(/^([a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,4}$)/i)) {
			valid += '<p>Your e-mail address' + required + '</p>';
		}
		
		if (message = '' || message.length <= 4) {
			valid += '<p>A message' + required + '</p>';
		}
		
		if (tempt != 'http://') {
			valid += '<p>We can\'t allow spam bots.</p>';
		}
		
		if (tempt2 != '') {
			valid += '<p>A human user' + required + '</p>';
		}
		
		if (valid != '') {
			$('form #response').removeClass().addClass('error')
				.html('' +valid).fadeIn('fast');
		}
			
		else {
			$('form #response').removeClass().addClass('processing').html('<p style="top:25px; text-align:center;">Your message is being sent...</p>').fadeIn('fast');
			
			var formData = $('form').serialize();
			submitForm(formData);
		}
		
	});
	
});

function submitForm(formData) {
	
	$.ajax({
			
			type: 'POST',
			url: 'mail/contact.php',
			data: formData,
			dataType: 'json',
			cache: false,
			timeout: 4000,
			success: function(data) {
							
							$('form #response').removeClass().addClass((data.error === true) ? 'error' : 'success')
											.html(data.msg).fadeIn('fast');
											
							if ($('form #response').hasClass('success')) {
								setTimeout("$('form #response').fadeOut('fast')", 6000);
						}
						
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						
						$('form #response').removeClass().addClass('error')
									.html('<p>There was an <strong>' + errorThrown +
										'</strong> error due to an <strong>' + textStatus +
										'</strong> condition.</p>').fadeIn('fast');
					},
					complete: function(XMLHttpRequest, status) {
						
						$('form')[0].reset();
					}
					
		  });


};
