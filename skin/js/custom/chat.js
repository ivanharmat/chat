$(document).ready(function(){
	var browser_height = $(window).height();  
    $('#main_page').css('min-height', browser_height - 130);

    var can_refresh = false;

    // Display login modal if user not logged in
    var client_logged_in = $('#client_logged_in').val();
    if(!client_logged_in)
    {
    	$('#login_modal').modal({'backdrop':'static'});
    	$('#chat_button').attr('disabled', 'disabled');
    }
    else
    {
    	$('#chat_button').removeAttr('disabled');
    	var offset = parseInt($('#offset').val());
    	if(offset > 5)
    	{
    		var position = $("#bottom_message").offset();
			$('body,html').animate({
				scrollTop: position.top
			}, 1500);
    	}
    	
		can_refresh = true;
    }

    if(can_refresh)
    {
    	setTimeout(function() {
    		load_new_messages(true);
		}, 2500);
    }

    // Load More messages
    $('#load_older_messages').click(function(e){
    	e.preventDefault;
    	var button = $(this);
    	$(button).attr('disabled', 'disabled');
    	$(button).html('<i class="icon-refresh icon-spin"></i> Load Older Messages');
    	var offset = parseInt($('#offset').val());
    	$.ajax({
    		url : '/chat/load_older_messages',
    		type : 'GET',
    		data : {'offset' : offset},
    		success : function(data){
    			var json = JSON.parse(data);
    			if(json.count > 0)
				{
					$.each(json.messages, function(index, value) {
						var css_class = (json.client_id == value.from) ? 'blue-right' : '';
						$('#text_messages_div').prepend('<div class="row">' +
								'<div class="span12">'+
								'<div class="sms_bubble '+css_class+'">'+
								'<p><strong>'+value.from_user +'</strong> to <strong>'+value.to_user+'</strong> - '+value.time_since+'</p>'+value.message+
								'</div>' +
								'</div>'+
								'</div>');
					});
					if(json.count < 25)
					{
						$(button).remove();
					}
					else
					{
						$(button).removeAttr('disabled');
						$(button).html('Load Older Messages');
						var new_offset = offset + 25;
						$('#offset').val(new_offset);
					}
				}
				else
				{
					$(button).remove();
				}
    		}
    	})
    	return false;
    });


    // Display login modal if user not logged in
    var client_logged_in = $('#client_logged_in').val();
    if(!client_logged_in)
    {
    	$('#login_modal').modal({'backdrop':'static'});
    	$('#chat_button').attr('disabled', 'disabled');
    }
    else
    {
    	$('#chat_button').removeAttr('disabled');
    	var offset = parseInt($('#offset').val());
    	if(offset > 5)
    	{
    		var position = $("#bottom_message").offset();
			$('body,html').animate({
				scrollTop: position.top
			}, 1500);
    	}
    }

    // Login Form Submit
    $('#login_form').submit(function(e){
    	e.preventDefault();
    	$('#sign_in_button').attr('disabled', 'disabled');
    	$('#sign_in_button').html('<i class="icon-spinner icon-spin"></i> Sign In');
    	$('#modal_results').hide();
    	$.ajax({
    		url : '/chat/authenticate',
    		type : 'POST',
    		data : $('#login_form').serialize(),
    		success : function(data){
    			var json = JSON.parse(data);
    			if(json.success)
    			{
    				window.location = '/';
    			}
    			else
    			{
    				$('#sign_in_button').removeAttr('disabled');
    				$('#sign_in_button').html('<i class="icon-user"></i> Sign In');
    				$('#modal_results').html('<p class="alert alert-error"><i class="icon-warning-sign"></i> Wrong name / password combination</p>');
    				$('#modal_results').fadeIn(1000, function(){
    					$('#modal_results').show();
    				});
    			}
    		}
    	});
    	return false;
    });

    $('#chat_form').submit(function(e){
    	e.preventDefault;
    	var chat_text_field = $('#chat_text_field').val().trim();
    	if(chat_text_field != '')
    	{
    		$('#chat_button').attr('disabled', 'disabled');
    		$('#chat_button').html('<i class="icon-spinner icon-spin"></i> Submit');
    		$.ajax({
	    		url : '/chat/new_comment',
	    		type : 'POST',
	    		data : $('#chat_form').serialize(),
	    		success : function(){
	    			$('#chat_button').removeAttr('disabled');
	    			$('#chat_button').html('<i class="icon-check"></i> Submit');
	    			$('#chat_text_field').val('');
	    		}
	    	});
    	}
    	
    	return false;
    });
    
});

function load_new_messages(repeat_function)
{
	var last_id = $('.message_id:last').val();
	var total_messages = 0;
	var new_count = 0;
	$.ajax({
		url : '/chat/load_new_messages',
		type : 'GET',
		data : {'last_id' : last_id},
		success : function(data){
			var json = JSON.parse(data);
			var offset = parseInt($('#offset').val());
			total_messages = offset + json.count;
			new_count = json.count;
			if(json.count > 0)
			{
				$.each(json.messages, function(index, value) {
					var css_class = (json.client_id == value.from) ? 'blue-right' : '';
					$('#new_messages').append('<div class="row">' +
							'<div class="span12">'+
							'<div class="sms_bubble '+css_class+'">'+
							'<p><strong>'+value.from_user +'</strong> to <strong>'+value.to_user+'</strong> - '+value.time_since+'</p>'+value.message+
							'</div>' +
							'</div>'+
							'</div><input type="hidden" class="message_id" value="'+value.id+'">');
				});
			}
			
		}
	}).done(function(){
		$('#offset').val(total_messages);
    	if(total_messages > 5 && new_count > 0)
    	{
    		var position = $("#bottom_message").offset();
			$('body,html').animate({
				scrollTop: position.top
			}, 1000);
    	}
	});

	if(repeat_function)
	{
		setTimeout(function() {
    		load_new_messages(true);
		}, 2500);
	}
}
