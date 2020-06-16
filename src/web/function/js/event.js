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
			url: 'api/getEvent.php',
			data : function(d) {
				d.current_table = currentTable;
				d.status_id = $('#Status').val();
			}
		},
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
	
	
	
	
	
	/**
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

function initDatatable() {

	table = $('#dynamic-table').DataTable({
		ajax: {
			type: 'POST',
			url: 'api/getEvent.php',
			data : function(d) {
				d.current_table = currentTable;
				d.status_id = $('#Status').val();
			}
		},
		"order" : [],
		bAutoWidth: true,
		"aaSorting": [],
		"sScrollX": "100%",
		"bScrollCollapse": true,
	});
}

$('#Status').on('change', function() {
	
	// refresh the table
	table.ajax.reload(null, false);
	
});

function updateEvent(id = null) {
    if (id) {
        
        var status = "";
        
        // click on success and cancel button
		$("#successBtn, #cancelBtn").unbind('click').bind('click', function() {
		    
		    var btnID = this.id;
            if (btnID == 'cancelBtn') {
		        status = 4;
		    }
		    else if (btnID == 'successBtn') {
		        status = 3;
				
				if(currentTable == 'boardgamebooking') {
					$.ajax({
						url: 'api/UpdateBoardGameQuantity.php',
						type: 'post',
						data: {record_id : id},
						dataType: 'json'
					});
				}
		    }
		    
		    $.ajax({
				url: 'api/updateEvent.php',
				type: 'post',
				data: {record_id : id,current_table : currentTable,record_status : status},
				dataType: 'json',
				success:function(result) {
					if(result.success == true) {						
						$(".resultMessage").html('<div class="alert alert-success alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+ result.messages +
							'</div>');

						// refresh the table
						table.ajax.reload(null, false);

						// close the modal
						$("#cancelEventModal, #successEventModal").modal('hide');

					} else {
						$(".resultMessage").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
							  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
							  '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+ result.messages +
							'</div>');
					}
				}
			});
		    
		});
    }
}


function loadMember(id = null) {
    
	$('div#member-result').html(`<h1 class="col-md-12 text-center">
							        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>
							    </h1>`);
    
	if(id) {
	    
	    // empty the message div
		$(".banMessage").html("");

		// fetch the member data
		$.ajax({
			url: 'api/getSelectedEventMember.php',
			type: 'post',
			data: {record_id : id,current_table : currentTable},
			dataType: 'json',
			success: function(result) {
			    
			    $('div#member-result').empty();
                
                if(result != null) {
                    
    				switch (currentTable) {
    						
        				case "gatheringbattle":
        					var member = JSON.parse(result.JoinedParticipant);
		                    var memberToken = JSON.parse(result.JoinedParticipantToken);
		                    
		                    var td = "";
		                    
		                    for(var i = 0;i < member.length;i++){
		                        if(member[i].extraPeople)
		                            td += `<tr><td class="text-nowrap">` +member[i].nickName+ `+` +member[i].extraPeople+ `</td>`;
		                        else
		                            td += `<tr><td class="text-nowrap">` +member[i].nickName+ `</td>`;
		                            
		                        td += `<td class="text-nowrap">` +memberToken[i].token+ `</td>
		                        		<td>
		                        			<button type="button" class="btn btn-xs btn-warning" onclick="banUser('` +memberToken[i].token+ `')">
		                        				<i class="ace-icon fa fa-ban bigger-110"></i>
		                        			</button>
		                        		</td></tr>`;
		                    }
        					
                            $('div#member-result').append(`
                                <h4 class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table class="table">
                                    	<thead>
    	    							     `+ td +`
    	    							</thead>
    	    						</table>
	    						</h4>`);
                            break;
                        
                        case "privatebooking":
                            $('div#member-result').append(`
                                <h4 class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <table class="table">
                                    	<thead>
    	    							     <tr>
    	    							    	<td class="text-nowrap">` +result.MemberName+ `</td>
    	    							    	<td class="text-nowrap">` +result.Account+ `</td>
    	    							    	<td>
    	    							    		<button type="button" class="btn btn-xs btn-warning" onclick="banUser('` +result.Account+ `')">
				                        				<i class="ace-icon fa fa-ban bigger-110"></i>
				                        			</button>
				                        		</td>
				                        	</tr>
    	    							</thead>
    	    						</table>
	    						</h4>`);
                            break;
    				}
                }
			} // ajax Success
		});
		
	} else {
		alert('Error: 請重新載入網頁');
	}
}