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
	
	
	loadApplication();
	
	// $(window).on('resize', function(){
	//       resize();
	// });
	
	// function resize() {
	// 	var win = $(this); //this = window
	//       if (win.width() > 1800) { 
	//       	$('.p-box').removeClass('col-md-4');
	//       	$('.p-box').removeClass('col-md-6');
	//     	$('.p-box').addClass('col-md-3');
	//       } else if (win.width() > 1400 && win.width() <= 1800) { 
	//       	$('.p-box').removeClass('col-md-3');
	//       	$('.p-box').removeClass('col-md-6');
	//     	$('.p-box').addClass('col-md-4');
	//       } else if (win.width() <= 1400) { 
	//       	$('.p-box').removeClass('col-md-3');
	//       	$('.p-box').removeClass('col-md-4');
	//     	$('.p-box').addClass('col-md-6');
	//       }
	// }
});

function loadApplication() {
	
	$('div#application-result').html(`<h1 class="col-md-12 text-center">
									        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>
									    </h1>`);
	
	$.ajax({
		type: 'POST',
		url: 'api/getApplication.php',
		data : {current_table : currentTable},
		dataType: 'json',
		success: function(result) 
		{
			$('div#application-result').empty();
			
			if(result.data[0] != null) {
				switch (currentTable) {
					
					case "gatheringbattle":
						for(var i = 0; i < result.data.length; i++) {
							$('div#application-result').append(`
							<div class="p-box col-xs-12 col-sm-6 col-md-4 col-lg-3">
				    			<div class="widget-box w-box widget-color-dark">
				    				<div class="widget-header hideOverflow" data-toggle="tooltip" title="`+ result.data[i][1] +`">
				    					<h5 class="widget-title bigger lighter"><span class="bookingID"><strong>ID : `+ result.data[i][0] +`</strong></span>`+ result.data[i][1] +`</h5>
				    				</div>
				    				<div class="widget-body">
				    					<div class="widget-main">
				    						<img src="BoardGameImage/`+ result.data[i][2] +`" class="img-responsive img-thumbnail center-block boardGame-img">
				    						<br />
				    						<table class="table">
				    							<tr>
				    								<th>房主</th>
				    								<td>`+ result.data[i][3] +`</td>
				    								<th>聯絡方法</th>
				    								<td>`+ result.data[i][4] +`</td>
				    							</tr>
				    							<tr>
				    								<th>日期</th>
				    								<td>`+ result.data[i][5] +`</td>
				    								<th>時間</th>
				    								<td>`+ result.data[i][6] +` - `+ result.data[i][7] +`</td>
				    							</tr>
				    							<tr>
				    								<th class="text-nowrap">地點</th>
				    								<td colspan="3">`+ result.data[i][8] +`</td>
				    							</tr>
				    						</table>
				    						<hr />
				    						<div class="pricing-box">
				    						    <div class="price">
				    							    <small>總人數: </small>`+ result.data[i][9] +`
				    							</div>
				    						</div>
				    					</div>
				    					<div class="btn-group btn-group btn-group-justified" role="group">
				    						<a href="#" class="btn btn-inverse" data-toggle="modal" data-target="#approveBookingModal" onclick="updateApplication(`+ result.data[i][0] +`)">
				    							<i class="ace-icon fa fa-check bigger-110"></i>
				    							<span>接受</span>
				    						</a>
				    						<a href="#" class="btn btn-inverse" data-toggle="modal" data-target="#rejectBookingModal" onclick="updateApplication(`+ result.data[i][0] +`)">
				    							<i class="ace-icon fa fa-times bigger-110"></i>
				    							<span>拒絕</span>
				    						</a>
				    					</div>
				    				</div>
				    			</div>
							</div>`);
						}
						break;
					
					case "privatebooking":
						for(var i = 0; i < result.data.length; i++) {
							$('div#application-result').append(`
							<div class="p-box col-xs-12 col-sm-6 col-md-4 col-lg-3">
				    			<div class="widget-box w-box widget-color-orange">
				    				<div class="widget-header hideOverflow">
				    					<h5 class="widget-title bigger lighter"><span class="bookingID"><strong>ID : `+ result.data[i][0] +`</strong></span>私人包場申請</h5>
				    				</div>
				    				<div class="widget-body">
				    					<div class="widget-main">
				    						<table>
				    							<tr class="row-fluid">
													<th class="text-nowrap col-md-3">包場者:</th>
													<td class="col-md-9">`+ result.data[i][1] +`</td>
												</tr>
												<tr class="row-fluid">
													<th class="text-nowrap col-md-3">聯絡方法:</th>
													<td class="col-md-9">`+ result.data[i][2] +`</td>
												</tr>
												<tr class="row-fluid">
													<th class="text-nowrap col-md-3">日期:</th>
													<td class="col-md-9">`+ result.data[i][3] +`</td>
												</tr>
												<tr class="row-fluid">
													<th class="text-nowrap col-md-3">時間:</th>
													<td class="col-md-9">`+ result.data[i][4] +` - `+ result.data[i][5] +`</td>
												</tr>
												<tr class="row-fluid">
													<th class="text-nowrap col-md-3">地點:</th>
													<td class="col-md-9">`+ result.data[i][6] +`</td>
												</tr>
												<tr class="row-fluid">
													<th class="text-nowrap col-md-3">參加人數:</th>
													<td class="col-md-9">`+ result.data[i][7] +`</td>
												</tr>
												<tr class="row-fluid">
													<th class="text-nowrap col-md-3">備註:</th>
													<td class="col-md-9">`+ result.data[i][9] +`</td>
												</tr>
											</table>
				    						
				    						
				    						<hr />
				    						<div class="pricing-box">
				    						    <div class="price">
				    							    <small>Total: </small>`+ result.data[i][8] +`
				    							</div>
				    						</div>
				    					</div>
				    					<div class="btn-group btn-group btn-group-justified" role="group">
				    						<a href="#" class="btn btn-warning" data-toggle="modal" data-target="#approveBookingModal" onclick="updateApplication(`+ result.data[i][0] +`,'`+ result.data[i][10] +`')">
				    							<i class="ace-icon fa fa-check bigger-110"></i>
				    							<span>接受</span>
				    						</a>
				    						<a href="#" class="btn btn-warning" data-toggle="modal" data-target="#rejectBookingModal" onclick="updateApplication(`+ result.data[i][0] +`,'`+ result.data[i][10] +`')">
				    							<i class="ace-icon fa fa-times bigger-110"></i>
				    							<span>拒絕</span>
				    						</a>
				    					</div>
				    				</div>
				    			</div>
							</div>`);
						}
						break;
					
					case "boardgamebooking":
						for(var i = 0; i < result.data.length; i++) {
							$('div#application-result').append(`
							<div class="p-box col-xs-12 col-sm-6 col-md-4 col-lg-3">
				    			<div class="widget-box w-box widget-color-blue">
				    				<div class="widget-header hideOverflow" data-toggle="tooltip" title="`+ result.data[i][1] +`">
				    					<h5 class="widget-title bigger lighter"><span class="bookingID"><strong>ID : `+ result.data[i][0] +`</strong></span>`+ result.data[i][1] +`</h5>
				    				</div>
				    				<div class="widget-body">
				    					<div class="widget-main">
				    						<img src="BoardGameImage/`+ result.data[i][2] +`" class="img-responsive img-thumbnail center-block boardGame-img">
				    						<br />
				    						<table class="table">
				    							<tr>
				    								<th>買家</th>
				    								<td>`+ result.data[i][3] +`</td>
				    								<th>聯絡方法</th>
				    								<td>`+ result.data[i][4] +`</td>
				    							</tr>
				    							<tr>
				    								<th>價錢(每個)</th>
				    								<td>`+ result.data[i][5] +`</td>
				    								<th>數量</th>
				    								<td>`+ result.data[i][6] +`</td>
				    							</tr>
				    							<tr>
				    								<th>訂購日期</th>
				    								<td>`+ result.data[i][7] +`</td>
				    								<th>訂購時間</th>
				    								<td>`+ result.data[i][8] +`</td>
				    							</tr>
				    						</table>
				    						<hr />
				    						<div class="pricing-box">
				    						    <div class="price">
				    							    <small>Total: </small>`+ result.data[i][9] +`
				    							</div>
				    						</div>
				    					</div>
				    					<div class="btn-group btn-group btn-group-justified" role="group">
				    						<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#approveBookingModal" onclick="updateApplication(`+ result.data[i][0] +`)">
				    							<i class="ace-icon fa fa-check bigger-110"></i>
				    							<span>接受</span>
				    						</a>
				    						<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#rejectBookingModal" onclick="updateApplication(`+ result.data[i][0] +`)">
				    							<i class="ace-icon fa fa-times bigger-110"></i>
				    							<span>拒絕</span>
				    						</a>
				    					</div>
				    				</div>
				    			</div>
							</div>`);
						}
						break;
				}
			} else {
				$('div#application-result').append('<h1 class="text-center">暫時沒有尚未審批的申請</h1>');
			}

			$('[data-toggle="tooltip"]').tooltip();
		}
	});
}

function updateApplication(id = null, account = null) {
	if (id) {
		
		var status = "";

		// click on reject and approve button
		$("#rejectBtn, #approveBtn").unbind('click').bind('click', function() {
			
			var btnID = this.id;
			
            if (btnID == 'rejectBtn') {
		        status = 2;
		    }
		    else if (btnID == 'approveBtn') {
		        status = 1;
		    }
		    
			$.ajax({
				url: 'api/updateApplication.php',
				type: 'post',
				data: {record_id : id,current_table : currentTable,record_status : status},
				dataType: 'json',
				success:function(result) {
					if(result.success == true) {						
						$(".resultMessage").html('<div class="alert alert-success alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+ result.messages +
							'</div>');
						
						var title = "";
						var body = "";
						
						$.ajax({
							url: 'api/getMessage.php',
							type: 'post',
							data: {current_table : currentTable},
							dataType: 'json',
							success:function(result) {
								
								if(btnID == 'approveBtn'){
									title = result.SuccessTitle;
									body = result.SuccessBody;
								} else if (btnID == 'rejectBtn') {
									title = result.CancelTitle;
									body = result.CancelBody;
								}
								
								switch(currentTable) {
							
									case "gatheringbattle":
										$.ajax({
											url: 'api/Receive.php',
											type: 'post',
											data: {table : currentTable,id : id,title : title,body : body}
										});
										break
										
									case "privatebooking":
										$.ajax({
											url: 'api/Receive.php',
											type: 'post',
											data: {account : account,title : title,body : body}
										});
										break;
								}
							} // ajax success
						});
	
						loadApplication();
						// close the modal
						$("#rejectBookingModal, #approveBookingModal").modal('hide');
						
						
					} else {
						$(".resultMessage").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+ result.messages +
							'</div>');
					}
				}
			});
			
		}); // click btn
	} else {
		alert('Error: 請重新載入網頁');
	}
	
}