
//alert('ARe you ready?!');
$(document).ready(function(){
	//alert("Are you ready");
	$('input').keyup(function(){
		min_length = $(this).attr('minlength');// get the length of the current input
		current_value = $(this).val();// get the value
		message_container = 'message_' + $(this).attr('id');// get container for the message
		max_length = $(this).attr('maxlength');// get the maximum lenght of the field
		//alert(current_value.length);
		if($(this).attr('type') != 'mail'){// if the type of input is not mail
		if(current_value.length < min_length ){// the current length of the text in the input box is less than specified length
			$('#'+message_container).text('You can not have less than '+ min_length+' characters ');// Error message input box
		}else if(current_value.length == max_length ){// Else if the number of characters in the inputbox is the same as the currrent value
			$('#'+message_container).text('Maximum no. of characters reached');// display a message that minimum characters have been reached
		}else{
			$('#'+message_container).text('You are now within allowable limit');
		}
		}else{
			$('#'+message_container).text('This is a mail type');
		}
	});
});

function sign_in(){
	//alert('Ok.');
	if(window.XMLHttpRequest){
		//alert('XML REQUEST')
		xmlhttp = new XMLHttpRequest();
	}else{
		//alert('XMLHTTP');
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange = function(){
		//alert('isokay');
		//alert('Change initiated');
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			var login_message = document.getElementById('login_message');
			if(xmlhttp.responseText == 0){// i.e user is a normal user(PH and GH)
					//login_message.innerHTML = xmlhttp.responseText;
					location = 'dashboard.php';
					//window.location = 'dashboard.php';
			}else if(xmlhttp.responseText == 1){// i.e user is liable for only GH
					location = 'we_gh.php';
			}else{
					login_message.innerHTML = xmlhttp.responseText;
			}
		}
	}
		parameters = 'user_mail='+document.getElementById('user_mail').value+'&user_pass='+document.getElementById('user_pass').value;
		xmlhttp.open('POST','includes/sign_in.php',true);
		xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlhttp.send(parameters);
}