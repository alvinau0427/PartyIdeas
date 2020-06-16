// JavaScript File

var table;
var currentTable;
$(document).ready(function(){
	
	var parts = window.location.search.substr(1).split("&");
	var $_GET = {};
	for (var i = 0; i < parts.length; i++) {
	    var temp = parts[i].split("=");
	    $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
	}
    
    currentTable = $_GET['table'];
    
    table = $('#dynamic-table').DataTable({
    	ajax: {
        	type: 'POST',
			url: 'api/getRecord.php',
			data : {current_table : currentTable}
        },
        // "ajax": "api/getRecord.php",
        "order" : [],
		bAutoWidth: false,
		"aaSorting": [],
		"sScrollX": "100%",
		"bScrollCollapse": true,
    });
    
    // 打印，Export，copy等功能
    //inline scripts related to this page
	$.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';
	
	new $.fn.dataTable.Buttons( table, {
		buttons: [
		  {
			"extend": "colvis",
			"text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
			"className": "btn btn-white btn-primary btn-bold",
			columns: ':not(:first):not(:last)'
		  },
		  {
			"extend": "copy",
			"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
			"className": "btn btn-white btn-primary btn-bold"
		  },
		  {
			"extend": "csv",
			"text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
			"className": "btn btn-white btn-primary btn-bold"
		  },
		  {
			"extend": "excel",
			"text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
			"className": "btn btn-white btn-primary btn-bold"
		  },
		  {
			"extend": "pdf",
			"text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
			"className": "btn btn-white btn-primary btn-bold"
		  },
		  {
			"extend": "print",
			"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
			"className": "btn btn-white btn-primary btn-bold",
			autoPrint: false,
			message: 'This print was produced using the Print button for DataTables'
		  }		  
		]
	} );
	table.buttons().container().appendTo( $('.tableTools-container') );
	
	//style the message box
	var defaultCopyAction = table.button(1).action();
	table.button(1).action(function (e, dt, button, config) {
		defaultCopyAction(e, dt, button, config);
		$('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
	});
	
	
	var defaultColvisAction = table.button(0).action();
	table.button(0).action(function (e, dt, button, config) {
		
		defaultColvisAction(e, dt, button, config);
		
		
		if($('.dt-button-collection > .dropdown-menu').length == 0) {
			$('.dt-button-collection')
			.wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
			.find('a').attr('href', '#').wrap("<li />")
		}
		$('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
	});

	////

	setTimeout(function() {
		$($('.tableTools-container')).find('a.dt-button').each(function() {
			var div = $(this).find(' > div').first();
			if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
			else $(this).tooltip({container: 'body', title: $(this).text()});
		});
	}, 500);
	
	
	
	
	
	table.on( 'select', function ( e, dt, type, index ) {
		if ( type === 'row' ) {
			$( table.row( index ).node() ).find('input:checkbox').prop('checked', true);
		}
	} );
	table.on( 'deselect', function ( e, dt, type, index ) {
		if ( type === 'row' ) {
			$( table.row( index ).node() ).find('input:checkbox').prop('checked', false);
		}
	} );




	/////////////////////////////////
	//table checkboxes
	$('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
	
	//select/deselect all rows according to table header checkbox
	$('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function(){
		var th_checked = this.checked;//checkbox inside "TH" table header
		
		$('#dynamic-table').find('tbody > tr').each(function(){
			var row = this;
			if(th_checked) table.row(row).select();
			else  table.row(row).deselect();
		});
	});
	
	//select/deselect a row when the checkbox is checked/unchecked
	$('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
		var row = $(this).closest('tr').get(0);
		if(this.checked) table.row(row).deselect();
		else table.row(row).select();
	});



	$(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
		e.stopImmediatePropagation();
		e.stopPropagation();
		e.preventDefault();
	});
	
	
	
	//And for the first simple table, which doesn't have TableTools or dataTables
	//select/deselect all rows according to table header checkbox
	var active_class = 'active';
	$('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
		var th_checked = this.checked;//checkbox inside "TH" table header
		
		$(this).closest('table').find('tbody > tr').each(function(){
			var row = this;
			if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
			else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
		});
	});
	
	//select/deselect a row when the checkbox is checked/unchecked
	$('#simple-table').on('click', 'td input[type=checkbox]' , function(){
		var $row = $(this).closest('tr');
		if($row.is('.detail-row ')) return;
		if(this.checked) $row.addClass(active_class);
		else $row.removeClass(active_class);
	});

	

	/********************************/
	//add tooltip for small view action buttons in dropdown menu
	$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
	
	//tooltip placement on right or left
	function tooltip_placement(context, source) {
		var $source = $(source);
		var $parent = $source.closest('table')
		var off1 = $parent.offset();
		var w1 = $parent.width();

		var off2 = $source.offset();
		//var w2 = $source.width();

		if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
		return 'left';
	}
	
	
	
	
	/***************/
	$('.show-details-btn').on('click', function(e) {
		e.preventDefault();
		$(this).closest('tr').next().toggleClass('open');
		$(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
	});
	/***************/
	
	
	
	
	
	/*
	//add horizontal scrollbars to a simple table
	$('#simple-table').css({'width':'2000px', 'max-width': 'none'}).wrap('<div style="width: 1000px;" />').parent().ace_scroll(
	  {
		horizontal: true,
		styleClass: 'scroll-top scroll-dark scroll-visible',//show the scrollbars on top(default is bottom)
		size: 2000,
		mouseWheelLock: true
	  }
	).css('padding-top', '12px');
	*/

    
});

// add Record
$('#addRecordModalBtn').on('click', function() {
    
    //reset the form
    $("#addRecordForm")[0].reset();
    
    // remove the error message
	$(".form-group").removeClass('has-error').removeClass('has-success');
    $(".text-danger").remove();
    
    // empty the message div
	$(".addMessage").html("");
    
    // submit form
	$("#addRecordForm").unbind('submit').bind('submit', function() {
	    
	    $(".text-danger").remove();
	    
	    var form = $(this);
	    
	    if(validation()) {
	        //submi the form to server
	        $.ajax({
        		type: form.attr('method'),
        		url: form.attr('action'),
        		dataType: 'json',
        		data : form.serialize()+"&current_table="+currentTable,    //序列化表單值
        		success: function(result) 
        		{
        		    // remove the error 
					$(".form-group").removeClass('has-error').removeClass('has-success');
        		    
        			if(result.success == true) {
        			    $('.addMessage').html('<div class="alert alert-success alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'+
                          '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + result.messages + 
                        '</div>');
                        
                        //reset the form
                        $("#addRecordForm")[0].reset();	
                        
                        // reload the datatables
						table.ajax.reload(null, false);
						// this function is built in function of datatables;
                        
        			} else {
        			    $('.addMessage').html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                          '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'+
                          '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>' + result.messages + 
                        '</div>');
        			}
        		}   // success  
        	}); // ajax subit 	
	    }
	    
	    return false;
	});
}); // /add modal

//validation
function validation(edit = "") {
	
	var isCorrect = false;
	
	switch (currentTable) {
		
		case 'admin':
			var name = $('#'+edit+'Name').val();
		    var loginAccount = $('#'+edit+'LoginAccount').val();
		    
		    if($.trim(name) == "") {
		        $('#'+edit+'Name').closest('.form-group').addClass('has-error');
				$('#'+edit+'Name').after('<p class="text-danger">"管理員名字"必需輸入</p>');
		    } else {
			    $('#'+edit+'Name').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Name').closest('.form-group').addClass('has-success');				
			}
			
			if($.trim(loginAccount) == "") {
		        $('#'+edit+'LoginAccount').closest('.form-group').addClass('has-error');
				$('#'+edit+'LoginAccount').after('<p class="text-danger">"登入帳戶"必需輸入</p>');
		    } else {
			    $('#'+edit+'LoginAccount').closest('.form-group').removeClass('has-error');
				$('#'+edit+'LoginAccount').closest('.form-group').addClass('has-success');				
			}
			
			if($.trim(loginAccount) && $.trim(name)){
				isCorrect = true;
			}
			
			break;
			
		case 'blacklist':
			var account = $('#'+edit+'Account').val();
			var status = $('#'+edit+'Status').val();
			var admin = $('#'+edit+'Admin').val();
			
			if($.trim(account) == "") {
		        $('#'+edit+'Account').closest('.form-group').addClass('has-error');
				$('#'+edit+'Account').after('<p class="text-danger">"封鎖帳戶"必需輸入</p>');
		    } else {
			    $('#'+edit+'Account').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Account').closest('.form-group').addClass('has-success');				
			}
			
			if($.trim(status) == "") {
		        $('#'+edit+'Status').closest('.form-group').addClass('has-error');
				$('#'+edit+'Status').after('<p class="text-danger">"封鎖狀態"必需輸入</p>');
		    } else {
			    $('#'+edit+'Status').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Status').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(admin) == "") {
		        $('#'+edit+'Admin').closest('.form-group').addClass('has-error');
				$('#'+edit+'Admin').after('<p class="text-danger">"管理員"必需輸入</p>');
		    } else {
			    $('#'+edit+'Admin').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Admin').closest('.form-group').addClass('has-success');
		    }
		    			
			if($.trim(account) && $.trim(status) && $.trim(admin)){
				isCorrect = true;
			}
            break;
                    
        case 'boardgame':
            var boardGameName = $('#'+edit+'BoardGameName').val();
			var year = $('#'+edit+'Year').val();
			var price = $('#'+edit+'Price').val();
			var quantity = $('#'+edit+'Quantity').val();
			var player_Minimum = $('#'+edit+'Player_Minimum').val();
			var status = $('#'+edit+'Status').val();
			
			if($.trim(boardGameName) == "") {
		        $('#'+edit+'BoardGameName').closest('.form-group').addClass('has-error');
				$('#'+edit+'BoardGameName').after('<p class="text-danger">"遊戲名字"必需輸入</p>');
		    } else {
			    $('#'+edit+'BoardGameName').closest('.form-group').removeClass('has-error');
				$('#'+edit+'BoardGameName').closest('.form-group').addClass('has-success');				
			}
			
		    if($.trim(year) == "") {
		        $('#'+edit+'Year').closest('.form-group').addClass('has-error');
				$('#'+edit+'Year').after('<p class="text-danger">"生產年份"必需輸入</p>');
		    } else {
			    $('#'+edit+'Year').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Year').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(price) == "") {
		        $('#'+edit+'Price').closest('.form-group').addClass('has-error');
				$('#'+edit+'Price').after('<p class="text-danger">"價錢"必需輸入</p>');
		    } else {
			    $('#'+edit+'Price').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Price').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(quantity) == "") {
		        $('#'+edit+'Quantity').closest('.form-group').addClass('has-error');
				$('#'+edit+'Quantity').after('<p class="text-danger">"貨存"必需輸入</p>');
		    } else {
			    $('#'+edit+'Quantity').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Quantity').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(player_Minimum) == "") {
		        $('#'+edit+'Player_Minimum').closest('.form-group').addClass('has-error');
				$('#'+edit+'Player_Minimum').after('<p class="text-danger">"最少人數"必需輸入</p>');
		    } else {
			    $('#'+edit+'Player_Minimum').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Player_Minimum').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(status) == "") {
		        $('#'+edit+'Status').closest('.form-group').addClass('has-error');
				$('#'+edit+'Status').after('<p class="text-danger">"狀態"必需輸入</p>');
		    } else {
			    $('#'+edit+'Status').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Status').closest('.form-group').addClass('has-success');
		    }
		    
			if($.trim(boardGameName) && $.trim(year) && $.trim(price) && $.trim(quantity) && 
			$.trim(player_Minimum) && $.trim(status)){
				isCorrect = true;
			}
            break;
                    
        case 'boardgamebooking':
            var boardGameID = $('#'+edit+'BoardGameID').val();
			var quantity = $('#'+edit+'Quantity').val();
			var totalPrice = $('#'+edit+'TotalPrice').val();
			var memberName = $('#'+edit+'MemberName').val();
			var contact = $('#'+edit+'Contact').val();
			var orderDate = $('#'+edit+'OrderDate').val();
			var orderTime = $('#'+edit+'OrderTime').val();
			var status = $('#'+edit+'Status').val();
			
			if($.trim(boardGameID) == "") {
		        $('#'+edit+'BoardGameID').closest('.form-group').addClass('has-error');
				$('#'+edit+'BoardGameID').after('<p class="text-danger">"遊戲ID"必需輸入</p>');
		    } else {
			    $('#'+edit+'BoardGameID').closest('.form-group').removeClass('has-error');
				$('#'+edit+'BoardGameID').closest('.form-group').addClass('has-success');				
			}
			
			if($.trim(quantity) == "") {
		        $('#'+edit+'Quantity').closest('.form-group').addClass('has-error');
				$('#'+edit+'Quantity').after('<p class="text-danger">"數量"必需輸入</p>');
		    } else {
			    $('#'+edit+'Quantity').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Quantity').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(totalPrice) == "") {
		        $('#'+edit+'TotalPrice').closest('.form-group').addClass('has-error');
				$('#'+edit+'TotalPrice').after('<p class="text-danger">"總額"必需輸入</p>');
		    } else {
			    $('#'+edit+'TotalPrice').closest('.form-group').removeClass('has-error');
				$('#'+edit+'TotalPrice').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(memberName) == "") {
		        $('#'+edit+'MemberName').closest('.form-group').addClass('has-error');
				$('#'+edit+'MemberName').after('<p class="text-danger">"買家"必需輸入</p>');
		    } else {
			    $('#'+edit+'MemberName').closest('.form-group').removeClass('has-error');
				$('#'+edit+'MemberName').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(contact) == "") {
		        $('#'+edit+'Contact').closest('.form-group').addClass('has-error');
				$('#'+edit+'Contact').after('<p class="text-danger">"聯絡方法"必需輸入</p>');
		    } else {
			    $('#'+edit+'Contact').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Contact').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(orderDate) == "") {
		        $('#'+edit+'OrderDate').closest('.form-group').addClass('has-error');
				$('#'+edit+'OrderDate').after('<p class="text-danger">"訂購日期"必需輸入</p>');
		    } else {
			    $('#'+edit+'OrderDate').closest('.form-group').removeClass('has-error');
				$('#'+edit+'OrderDate').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(orderTime) == "") {
		        $('#'+edit+'OrderTime').closest('.form-group').addClass('has-error');
				$('#'+edit+'OrderTime').after('<p class="text-danger">"訂購時間"必需輸入</p>');
		    } else {
			    $('#'+edit+'OrderTime').closest('.form-group').removeClass('has-error');
				$('#'+edit+'OrderTime').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(status) == "") {
		        $('#'+edit+'Status').closest('.form-group').addClass('has-error');
				$('#'+edit+'Status').after('<p class="text-danger">"狀態"必需輸入</p>');
		    } else {
			    $('#'+edit+'Status').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Status').closest('.form-group').addClass('has-success');
		    }
		    
			if($.trim(boardGameID) && $.trim(quantity) && $.trim(totalPrice) && $.trim(memberName) && $.trim(contact) && 
			$.trim(orderDate) && $.trim(orderTime) && $.trim(status)){
				isCorrect = true;
			}
            break;
                    
        case 'boardgametype':
        	var type = $('#'+edit+'Type').val();
        	
        	if($.trim(type) == "") {
		        $('#'+edit+'Type').closest('.form-group').addClass('has-error');
				$('#'+edit+'Type').after('<p class="text-danger">"遊戲類型"必需輸入</p>');
		    } else {
			    $('#'+edit+'Type').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Type').closest('.form-group').addClass('has-success');				
			}
			
			if($.trim(type)){
				isCorrect = true;
			}
        	break;
                    
        case 'gatheringbattle':
            var boardGameID = $('#'+edit+'BoardGameID').val();
			var memberName = $('#'+edit+'MemberName').val();
			var account = $('#'+edit+'Account').val();
			var contact = $('#'+edit+'Contact').val();
			var date = $('#'+edit+'Date').val();
			var time = $('#'+edit+'Time').val();
			var endTime = $('#'+edit+'EndTime').val();
			var place = $('#'+edit+'Place').val();
			var participantRequirement = $('#'+edit+'ParticipantRequirement').val();
			var status = $('#'+edit+'Status').val();
			
			if($.trim(boardGameID) == "") {
		        $('#'+edit+'BoardGameID').closest('.form-group').addClass('has-error');
				$('#'+edit+'BoardGameID').after('<p class="text-danger">"遊戲ID"必需輸入</p>');
		    } else {
			    $('#'+edit+'BoardGameID').closest('.form-group').removeClass('has-error');
				$('#'+edit+'BoardGameID').closest('.form-group').addClass('has-success');				
			}
			
			if($.trim(memberName) == "") {
		        $('#'+edit+'MemberName').closest('.form-group').addClass('has-error');
				$('#'+edit+'MemberName').after('<p class="text-danger">"房主"必需輸入</p>');
		    } else {
			    $('#'+edit+'MemberName').closest('.form-group').removeClass('has-error');
				$('#'+edit+'MemberName').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(account) == "") {
		        $('#'+edit+'Account').closest('.form-group').addClass('has-error');
				$('#'+edit+'Account').after('<p class="text-danger">"房主帳戶"必需輸入</p>');
		    } else {
			    $('#'+edit+'Account').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Account').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(contact) == "") {
		        $('#'+edit+'Contact').closest('.form-group').addClass('has-error');
				$('#'+edit+'Contact').after('<p class="text-danger">"聯絡方法"必需輸入</p>');
		    } else {
			    $('#'+edit+'Contact').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Contact').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(date) == "") {
		        $('#'+edit+'Date').closest('.form-group').addClass('has-error');
				$('#'+edit+'Date').after('<p class="text-danger">"日期"必需輸入</p>');
		    } else {
			    $('#'+edit+'Date').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Date').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(time) == "") {
		        $('#'+edit+'Time').closest('.form-group').addClass('has-error');
				$('#'+edit+'Time').after('<p class="text-danger">"開始時間"必需輸入</p>');
		    } else {
			    $('#'+edit+'Time').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Time').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(endTime) == "") {
		        $('#'+edit+'EndTime').closest('.form-group').addClass('has-error');
				$('#'+edit+'EndTime').after('<p class="text-danger">"完結時間"必需輸入</p>');
		    } else {
			    $('#'+edit+'EndTime').closest('.form-group').removeClass('has-error');
				$('#'+edit+'EndTime').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(place) == "") {
		        $('#'+edit+'Place').closest('.form-group').addClass('has-error');
				$('#'+edit+'Place').after('<p class="text-danger">"地點ID"必需輸入</p>');
		    } else {
			    $('#'+edit+'Place').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Place').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(participantRequirement) == "") {
		        $('#'+edit+'ParticipantRequirement').closest('.form-group').addClass('has-error');
				$('#'+edit+'ParticipantRequirement').after('<p class="text-danger">"人數要求"必需輸入</p>');
		    } else {
			    $('#'+edit+'ParticipantRequirement').closest('.form-group').removeClass('has-error');
				$('#'+edit+'ParticipantRequirement').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(status) == "") {
		        $('#'+edit+'Status').closest('.form-group').addClass('has-error');
				$('#'+edit+'Status').after('<p class="text-danger">"狀態"必需輸入</p>');
		    } else {
			    $('#'+edit+'Status').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Status').closest('.form-group').addClass('has-success');
		    }
		    
			if($.trim(boardGameID) && $.trim(memberName) && $.trim(account) && $.trim(contact) && $.trim(date) && 
			$.trim(time) && $.trim(endTime) && $.trim(place) && $.trim(participantRequirement) && $.trim(status)){
				isCorrect = true;
			}
            break;
        
        case 'location':
            var place = $('#'+edit+'Place').val();
			
			if($.trim(place) == "") {
		        $('#'+edit+'Place').closest('.form-group').addClass('has-error');
				$('#'+edit+'Place').after('<p class="text-danger">"地點"必需輸入</p>');
		    } else {
			    $('#'+edit+'Place').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Place').closest('.form-group').addClass('has-success');				
			}
			
			if($.trim(place)){
				isCorrect = true;
			}
            break;
                    
        case 'notification':
            var title = $('#'+edit+'Title').val();
			var body = $('#'+edit+'Body').val();
			var uid = $('#'+edit+'Uid').val();
			var name = $('#'+edit+'Name').val();
			var date = $('#'+edit+'Date').val();
			
			if($.trim(title) == "") {
		        $('#'+edit+'Title').closest('.form-group').addClass('has-error');
				$('#'+edit+'Title').after('<p class="text-danger">"標題"必需輸入</p>');
		    } else {
			    $('#'+edit+'Title').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Title').closest('.form-group').addClass('has-success');				
			}
			
			if($.trim(body) == "") {
		        $('#'+edit+'Body').closest('.form-group').addClass('has-error');
				$('#'+edit+'Body').after('<p class="text-danger">"內容"必需輸入</p>');
		    } else {
			    $('#'+edit+'Body').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Body').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(uid) == "") {
		        $('#'+edit+'Uid').closest('.form-group').addClass('has-error');
				$('#'+edit+'Uid').after('<p class="text-danger">Uid必需輸入</p>');
		    } else {
			    $('#'+edit+'Uid').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Uid').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(name) == "") {
		        $('#'+edit+'Name').closest('.form-group').addClass('has-error');
				$('#'+edit+'Name').after('<p class="text-danger">Name必需輸入</p>');
		    } else {
			    $('#'+edit+'Name').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Name').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(date) == "") {
		        $('#'+edit+'Date').closest('.form-group').addClass('has-error');
				$('#'+edit+'Date').after('<p class="text-danger">"日期時間"必需輸入</p>');
		    } else {
			    $('#'+edit+'Date').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Date').closest('.form-group').addClass('has-success');
		    }
		    
			if($.trim(title) && $.trim(body) && $.trim(uid) && $.trim(name) && $.trim(date)){
				isCorrect = true;
			}
            break;
        
        case 'photo':
        	var photoName = $('#'+edit+'PhotoName').val();
        	var status = $('#'+edit+'Status').val();
        	
        	if($.trim(photoName) == "") {
		        $('#'+edit+'PhotoName').closest('.form-group').addClass('has-error');
				$('#'+edit+'PhotoName').after('<p class="text-danger">"相片名字"必需輸入</p>');
		    } else {
			    $('#'+edit+'PhotoName').closest('.form-group').removeClass('has-error');
				$('#'+edit+'PhotoName').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(status) == "") {
		        $('#'+edit+'Status').closest('.form-group').addClass('has-error');
				$('#'+edit+'Status').after('<p class="text-danger">"顯示狀態"必需輸入</p>');
		    } else {
			    $('#'+edit+'Status').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Status').closest('.form-group').addClass('has-success');
		    }
        	
        	if($.trim(photoName) && $.trim(status)){
				isCorrect = true;
			}
        	break;
        
        case 'privatebooking':
            var memberName = $('#'+edit+'MemberName').val();
			var account = $('#'+edit+'Account').val();
			var contact = $('#'+edit+'Contact').val();
			var date = $('#'+edit+'Date').val();
			var time = $('#'+edit+'Time').val();
			var endTime = $('#'+edit+'EndTime').val();
			var place = $('#'+edit+'Place').val();
			var numberOfPeople = $('#'+edit+'NumberOfPeople').val();
			var totalPrice = $('#'+edit+'TotalPrice').val();
			var status = $('#'+edit+'Status').val();
			
			
			if($.trim(memberName) == "") {
		        $('#'+edit+'MemberName').closest('.form-group').addClass('has-error');
				$('#'+edit+'MemberName').after('<p class="text-danger">"包場者"必需輸入</p>');
		    } else {
			    $('#'+edit+'MemberName').closest('.form-group').removeClass('has-error');
				$('#'+edit+'MemberName').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(account) == "") {
		        $('#'+edit+'Account').closest('.form-group').addClass('has-error');
				$('#'+edit+'Account').after('<p class="text-danger">"包場者帳戶"必需輸入</p>');
		    } else {
			    $('#'+edit+'Account').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Account').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(contact) == "") {
		        $('#'+edit+'Contact').closest('.form-group').addClass('has-error');
				$('#'+edit+'Contact').after('<p class="text-danger">"聯絡方法"必需輸入</p>');
		    } else {
			    $('#'+edit+'Contact').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Contact').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(date) == "") {
		        $('#'+edit+'Date').closest('.form-group').addClass('has-error');
				$('#'+edit+'Date').after('<p class="text-danger">"日期"必需輸入</p>');
		    } else {
			    $('#'+edit+'Date').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Date').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(time) == "") {
		        $('#'+edit+'Time').closest('.form-group').addClass('has-error');
				$('#'+edit+'Time').after('<p class="text-danger">"開始時間"必需輸入</p>');
		    } else {
			    $('#'+edit+'Time').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Time').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(endTime) == "") {
		        $('#'+edit+'EndTime').closest('.form-group').addClass('has-error');
				$('#'+edit+'EndTime').after('<p class="text-danger">"完結時間"必需輸入</p>');
		    } else {
			    $('#'+edit+'EndTime').closest('.form-group').removeClass('has-error');
				$('#'+edit+'EndTime').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(place) == "") {
		        $('#'+edit+'Place').closest('.form-group').addClass('has-error');
				$('#'+edit+'Place').after('<p class="text-danger">"地點ID"必需輸入</p>');
		    } else {
			    $('#'+edit+'Place').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Place').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(numberOfPeople) == "") {
		        $('#'+edit+'NumberOfPeople').closest('.form-group').addClass('has-error');
				$('#'+edit+'NumberOfPeople').after('<p class="text-danger">"人數"必需輸入</p>');
		    } else {
			    $('#'+edit+'NumberOfPeople').closest('.form-group').removeClass('has-error');
				$('#'+edit+'NumberOfPeople').closest('.form-group').addClass('has-success');
		    }
		    		    
		    if($.trim(totalPrice) == "") {
		        $('#'+edit+'TotalPrice').closest('.form-group').addClass('has-error');
				$('#'+edit+'TotalPrice').after('<p class="text-danger">"總額"必需輸入</p>');
		    } else {
			    $('#'+edit+'TotalPrice').closest('.form-group').removeClass('has-error');
				$('#'+edit+'TotalPrice').closest('.form-group').addClass('has-success');
		    }
		    
		    if($.trim(status) == "") {
		        $('#'+edit+'Status').closest('.form-group').addClass('has-error');
				$('#'+edit+'Status').after('<p class="text-danger">"狀態"必需輸入</p>');
		    } else {
			    $('#'+edit+'Status').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Status').closest('.form-group').addClass('has-success');
		    }
			if($.trim(memberName) && $.trim(account) && $.trim(contact) && $.trim(date) && 
			$.trim(time) && $.trim(endTime) && $.trim(place) && $.trim(numberOfPeople) && $.trim(totalPrice) && $.trim(status)){
				isCorrect = true;
			}
            break;
                                
        case 'users':
            var token = $('#'+edit+'Token').val();
            var account = $('#'+edit+'Account').val();
            var receiveNotification = $('#'+edit+'ReceiveNotification').val();

			if($.trim(token) == "") {
		        $('#'+edit+'Token').closest('.form-group').addClass('has-error');
				$('#'+edit+'Token').after('<p class="text-danger">"帳戶"必需輸入</p>');
		    } else {
			    $('#'+edit+'Token').closest('.form-group').removeClass('has-error');
				$('#'+edit+'Token').closest('.form-group').addClass('has-success');
		    }
		    
			if($.trim(token)){
				isCorrect = true;
			}
            break;
		
		default:
			// code
	}
    
	
	return isCorrect;
}


function removeRecord(id = null) {
	if (id) {
		// click on remove button
		$("#removeBtn").unbind('click').bind('click', function() {
			
			$.ajax({
				url: 'api/removeRecord.php',
				type: 'post',
				data: {record_id : id,current_table : currentTable},
				dataType: 'json',
				success:function(result) {
					if(result.success == true) {						
						$(".removeMessage").html('<div class="alert alert-success alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+ result.messages +
							'</div>');

						// refresh the table
						table.ajax.reload(null, false);

						// close the modal
						$("#removeRecordModal").modal('hide');

					} else {
						$(".removeMessage").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+ result.messages +
							'</div>');
					}
				}
			});
			
		}); // click remove btn
	} else {
		alert('Error: 請重新載入網頁');
	}
}


function editRecord(id = null) {
	if(id) {

	    // remove the error message
		$(".form-group").removeClass('has-error').removeClass('has-success');
	    $(".text-danger").remove();
	    
	    // empty the message div
		$(".editMessage").html("");

		// fetch the record data
		$.ajax({
			url: 'api/getSelectedRecord.php',
			type: 'post',
			data: {record_id : id,current_table : currentTable},
			dataType: 'json',
			success: function(result) {

				switch (currentTable) {
		
					case 'admin':
						$('#editName').val(result.Name);
						$('#editLoginAccount').val(result.LoginAccount);
						break;
						
					case 'blacklist':
						$('#editAccount').val(result.Account);
						$('#editStatus').val(result.Status);
						$('#editBlackListDate').val(result.BlackListDate);
						$('#editAdmin').val(result.Admin);
			            break;
			                    
			        case 'boardgame':
			            $('#editBoardGameName').val(result.BoardGameName);
						$('#editBoardGameDetail').val(result.BoardGameDetail);
						$('#editBoardGameType').val(result.BoardGameType);
						$('#editYear').val(result.Year);
						$('#editPrice').val(result.Price);
						$('#editQuantity').val(result.Quantity);
						$('#editPlayer_Minimum').val(result.Player_Minimum);
						$('#editPlayer_Maximum').val(result.Player_Maximum);
						$('#editLimitationAge').val(result.LimitationAge);
						$('#editPhoto').val(result.Photo);
						$('#editStatus').val(result.Status);
			            break;
			                    
			        case 'boardgamebooking':
			            $('#editBoardGameID').val(result.BoardGameID);
						$('#editQuantity').val(result.Quantity);
						$('#editTotalPrice').val(result.TotalPrice);
						$('#editMemberName').val(result.MemberName);
						$('#editContact').val(result.Contact);
						$('#editOrderDate').val(result.OrderDate);
						$('#editOrderTime').val(result.OrderTime);
						$('#editReceiptDate').val(result.ReceiptDate);
						$('#editReceiptTime').val(result.ReceiptTime);
						$('#editStatus').val(result.Status);
			            break;

					case 'boardgametype':
						$('#editType').val(result.Type);
			            break;
    
			        case 'gatheringbattle':
			            $('#editBoardGameID').val(result.BoardGameID);
						$('#editMemberName').val(result.MemberName);
						$('#editAccount').val(result.Account);
						$('#editContact').val(result.Contact);
						$('#editDate').val(result.Date);
						$('#editTime').val(result.Time);
						$('#editEndTime').val(result.EndTime);
						$('#editPlace').val(result.Place);
						$('#editParticipantRequirement').val(result.ParticipantRequirement);
						$('#editStatus').val(result.Status);
						$('#editJoinedParticipant').val(result.JoinedParticipant);
						$('#editJoinedParticipantToken').val(result.JoinedParticipantToken);
			            break;
			        
			        case 'location':
			            $('#editPlace').val(result.Place);
			            break;
			                    
			        case 'notification':
			            $('#editTitle').val(result.Title);
						$('#editBody').val(result.Body);
						$('#editUid').val(result.Uid);
						$('#editName').val(result.Name);
						$('#editDate').val(result.Date);
			            break;
			        
			        case 'photo':
			            $('#editPhotoName').val(result.PhotoName);
			            $('#editStatus').val(result.Status);
			            break;
			                    
			        case 'privatebooking':
						$('#editMemberName').val(result.MemberName);
						$('#editAccount').val(result.Account);
						$('#editContact').val(result.Contact);
						$('#editDate').val(result.Date);
						$('#editTime').val(result.Time);
						$('#editEndTime').val(result.EndTime);
						$('#editPlace').val(result.Place);
						$('#editNumberOfPeople').val(result.NumberOfPeople);
						$('#editTotalPrice').val(result.TotalPrice);
						$('#editDiscount').val(result.Discount);
						$('#editRemark').val(result.Remark);
						$('#editPhoto').val(result.Photo);
						$('#editStatus').val(result.Status);
			            break;
			                                
			        case 'users':
			            $('#editToken').val(result.Token);
			            $('#editAccount').val(result.Account);
			            $('#editReceiveNotification').val(result.ReceiveNotification);
			            break;
				}
				
				// here update the data
				$("#editRecordForm").unbind('submit').bind('submit', function() {
					
					// remove error messages
					$(".text-danger").remove();
					
					var form = $(this);

					if(validation("edit")) {
						$.ajax({
							url: form.attr('action'),
							type: form.attr('method'),
							data: form.serialize() +"&record_id="+id+"&current_table="+currentTable,//{record_id: id, edit_Name:editName, edit_LoginAccount:editLoginAccount},
							dataType: 'json',
							success : function(result) {
								if(result.success == true){
									
									$(".editMessage").html('<div class="alert alert-success alert-dismissible" role="alert">'+
									  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
									  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+result.messages+
									'</div>');

									// reload the datatables
									table.ajax.reload(null, false);
									// this function is built in function of datatables;

									// remove the error 
									$(".form-group").removeClass('has-success').removeClass('has-error');
									$(".text-danger").remove();
									
								} else {
									$(".editMessage").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
									  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
									  '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+result.messages+
									'</div>')
								}
							}
						});
					}
					
					return false;
				});
			}
		});
		
	} else {
		alert('Error: 請重新載入網頁');
	}
}