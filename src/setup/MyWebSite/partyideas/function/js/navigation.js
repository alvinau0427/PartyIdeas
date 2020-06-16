// JavaScript File

$(document).ready(function() {
    
    $('#content').load('content/main.php');
    
});

$('ul#nav li a').on('click',function() {
    
    var page = $(this).attr('href');
    
    if(page == "#")
        return false;
    
	$.ajax({
    	url: page,
    	cache: false,
    	success: function(result) 
    	{
    		$('#content').empty().append(result);
    	}
	});
        
    // $('#content').load(page);
    
    return false;
});

// /* ---------- Add class .active to current link  ---------- */
// $('ul.main-menu li a').on('click',function(){

// 	$(this).parent().addClass('active');

// });

// $('ul.main-menu li ul li a').on('click',function(){

// 	$(this).parent().addClass('active');
// 	$(this).parent().parent().show();

// });


// /* ---------- Submenu  ---------- */

// $('.dropmenu').click(function(e){

// 	e.preventDefault();

// 	$(this).parent().find('ul').slideToggle();

// });