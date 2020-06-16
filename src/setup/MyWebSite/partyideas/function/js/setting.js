// JavaScript File

var currentTable;

$(document).ready(function(){
	
	var parts = window.location.search.substr(1).split("&");
	var $_GET = {};
	for (var i = 0; i < parts.length; i++) {
	    var temp = parts[i].split("=");
	    $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
	}

	currentTable = $_GET['table'];
	
	loadSetting();
});

function loadSetting() {
	
	$('span#loading-result').html(`<strong><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></strong>`);
	
	// fetch the record data
	$.ajax({
		url: 'api/getRecord.php',
		type: 'post',
		data: {current_table : currentTable},
		dataType: 'json',
		success: function(result) {
			
			$('span#loading-result').empty();
			
			if(result) {
				switch(currentTable) {
					case "gatheringbattleprice":
						$('#Monday').val(result.Monday);
						$('#Tuesday').val(result.Tuesday);
						$('#Wednesday').val(result.Wednesday);
						$('#Thursday').val(result.Thursday);
						$('#Friday').val(result.Friday);
						$('#Saturday').val(result.Saturday);
						$('#Sunday').val(result.Sunday);
						break;
					
					case "privatebookingprice":
						$('#BasicPrice').val(result.BasicPrice);
						$('#BasicPeople').val(result.BasicPeople);
						$('#BasicHour').val(result.BasicHour);
						$('#ExtraFoodPricePerPeople').val(result.ExtraFoodPricePerPeople);
						$('#ExtraPricePerHour').val(result.ExtraPricePerHour);
						$('#ExtraPricePerPeople').val(result.ExtraPricePerPeople);
						break;
						
					case "message":
						$('#GBSuccessTitle').val(result["1"].SuccessTitle);
						$('#GBSuccessBody').val(result["1"].SuccessBody);
						$('#GBCancelTitle').val(result["1"].CancelTitle);
						$('#GBCancelBody').val(result["1"].CancelBody);
						$('#PBSuccessTitle').val(result["2"].SuccessTitle);
						$('#PBSuccessBody').val(result["2"].SuccessBody);
						$('#PBCancelTitle').val(result["2"].CancelTitle);
						$('#PBCancelBody').val(result["2"].CancelBody);
						break;
						
					case "indexsetting":
						$('#BGShowItem').val(result["1"].ShowItem);
						$('#GBShowItem').val(result["2"].ShowItem);
						break;
				}
				
			}
		}
	});
}

$("#reset").unbind('reset').bind('click', loadSetting);

// here update the data
$("#editSettingForm").unbind('submit').bind('submit', function() {

	var form = $(this);
	
	$.ajax({
		url: form.attr('action'),
		type: form.attr('method'),
		data: form.serialize() +"&record_id=1&current_table="+currentTable,
		dataType: 'json',
		success : function(result) {
			if(result.success == true){
				
				$(".resultMessage").html('<div class="alert alert-success alert-dismissible" role="alert">'+
				  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
				  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+result.messages+
				'</div>');

				// reload the setting
				loadSetting();
				
			} else {
				$(".resultMessage").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
				  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
				  '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+result.messages+
				'</div>')
			}
		}
	});
		

	return false;
});