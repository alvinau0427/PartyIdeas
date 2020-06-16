// JavaScript File

$(document).ready(function(){
	    	
	$.ajax({
		type: 'POST',
		url: 'api/getNotification.php',
		dataType: 'Text',
		success: function(result) 
		{
			$('div#message').html(result);
		}
	});
	
	setInterval(function() {
		$('div#message').load("api/getNotification.php");
	}, 3000);

});


$('button#submit').on('click',function() {
	var title = $('input#title').val();
	var body = $('input#body').val();
	var name = $('input#name').val();
	var uid = $('input#uid').val();
    //var adminEmail = $('input#adminEmail').val();
    // if( $.trim(adminEmail) == '' ) {
    	
    // 	alert('Input not correct!');
    	
    // } else {
    	$.ajax({
    		type: 'POST',
    		url: 'api/addNotification.php',
    		dataType: 'Text',
    		data: {title:title, body:body, name:name, uid:uid},
    		success: function(result) 
    		{
    			$('div#message').html(result);
    		}
    	});
    	
    	$.ajax({
    		type: 'POST',
    		url: 'api/Receive.php',
    		dataType: 'Text',
    		data: {title:title, body:body},
    		success: function(result) 
    		{
    			// alert("OK");
    		}
    	});
    //}
});
	
