// JavaScript File

var url = window.location.href;
var filename = url.substring(url.lastIndexOf('/')+1);

if((filename) == ""){
	$('#Dashboard').addClass('active')
}
	
$('ul.nav.nav-list a').each(function(){
	if($(this).attr('href') == filename){
		$(this).closest('li').addClass('active');
		$(this).closest('ul').closest('li').addClass('active open');
		if($(this).closest('ul').closest('li').closest('ul').closest('li'))
			$(this).closest('ul').closest('li').closest('ul').closest('li').addClass('active open');
		return false;
	}
});