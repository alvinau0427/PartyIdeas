<?php require_once('require/allInOne.php'); ?>

		<div class="main-content">
			<div class="main-content-inner">
				<div class="breadcrumbs ace-save-state" id="breadcrumbs">
					<ul class="breadcrumb">
						<li>
							<i class="ace-icon fa fa-home home-icon"></i>
							<a href="index.php">Home</a>
						</li>
						<li class="active">紀錄活動 
							(
								<?php 
								switch($_GET['table']) {
									
									case "gatheringbattle":
										echo '紀錄約戰';
										break;
									
									case "privatebooking":
										echo '紀錄包場';
										break;
										
									case "boardgamebooking":
										echo '紀錄訂購';
										break;}
								?>
							)
						</li>
					</ul>
				</div>
				
				<div class="page-content">
					<?php require_once('require/setting.html'); ?>

						<div class="page-header">
							<h1>
								<?php 
								switch($_GET['table']) {
									
									case "gatheringbattle":
										echo '記錄約戰
											<small>
											<i class="ace-icon fa fa-angle-double-right"></i>
											尚未記錄的遊戲約戰
											</small>';
										break;
										
									case "privatebooking":
										echo '記錄包場
											<small>
											<i class="ace-icon fa fa-angle-double-right"></i>
											尚未記錄的私人包場
											</small>';
										break;
									
									case "boardgamebooking":
										echo '記錄訂購
											<small>
											<i class="ace-icon fa fa-angle-double-right"></i>
											尚未記錄的遊戲訂購
											</small>';
										break;
								}
								?>
							</h1>
						</div><!-- /.page-header -->
						
						<div class="row">
							<div class="col-xs-12">
							    <!-- PAGE CONTENT BEGINS -->
						        <div class="row">
						        	<div class="col-xs-12">
						        
						        		<div class="resultMessage"></div><!-- show the result message -->
										<div class="form-group alert alert-info">
											<label for="Status" class="control-label"><strong>顯示狀態 : &nbsp;&nbsp;</strong></label>
												<select id="Status">
													<?php 
													if($_GET['table'] == "gatheringbattle")
														echo '<option value="-1">人數未滿</option>'; 
													?>
													<option value="0">等待審批</option>
													<option value="1" selected="selected">已接受</option>
													<option value="2">已拒絕</option>
													<option value="3">已完成</option>
													<option value="4">已取消</option>
												</select>
										</div>
										
										
										
						        		<div class="clearfix">
						        			<div class="pull-right tableTools-container"></div>
						        		</div>
						        		<div class="table-header">
						        			Results for "<?php echo $_GET['table']; ?>" table
						        		</div>
						        
						        		<!-- div.table-responsive -->
						        
						        		<!-- div.dataTables_borderWrap -->
						        		<div id="database-result">
											<table id="dynamic-table" class="table table-striped table-hover">
												<thead>
													<tr>
														<?php 
														switch($_GET['table']) {
															
															case "gatheringbattle":
																echo '<th>ID</th>
																	<th>遊戲</th>
																	<th>房主</th>
																	<th>聯絡方法</th>
																	<th>日期</th>
																	<th>開始時間</th>
																	<th>完結時間</th>
																	<th>地點</th>
																	<th>人數</th>
																	<th>成員</th>';
																break;
																
															case "privatebooking":
																echo '<th>ID</th>
																	<th>包場者</th>
																	<th>聯絡方法</th>
																	<th>日期</th>
																	<th>開始時間</th>
																	<th>完結時間</th>
																	<th>地點</th>
																	<th>人數</th>
																	<th>總額</th>
																	<th>成員</th>';
																break;
															
															case "boardgamebooking":
																echo '<th>ID</th>
																	<th>遊戲</th>
																	<th>買家</th>
																	<th>聯絡方法</th>
																	<th>訂購日期</th>
																	<th>訂購時間</th>
																	<th>數量</th>
																	<th>總額</th>';
																break;
														}
														?>
														<th></th>
													</tr>
												</thead>
												<tbody>
						    					</tbody>
											</table>
						        		</div>
						        	</div>
						        </div>
						    </div>
						</div>
						
						<!-- sucess event modal -->
						<div class="modal fade" id="successEventModal">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
										<h4 class="modal-title"><i class="ace-icon fa fa-check"></i>&nbsp;&nbsp;完成活動</h4>
									</div>
									<div class="modal-body">
										<p>此項活動已經舉辦完成？</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
										<button type="button" class="btn btn-primary" id="successBtn">確定完成</button>
									</div>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.sucess event modal -->
						
						<!-- cancel event modal -->
						<div class="modal fade" id="cancelEventModal">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
										<h4 class="modal-title"><i class="ace-icon fa fa-times"></i>&nbsp;&nbsp;取消活動</h4>
									</div>
									<div class="modal-body">
										<p>你確定要取消此項活動？</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
										<button type="button" class="btn btn-primary" id="cancelBtn">確定取消</button>
									</div>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.cancel event modal -->
						
						<!-- cancel event modal -->
						<div class="modal fade" id="memberModal">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
										<h4 class="modal-title"><i class="ace-icon fa fa-users"></i>&nbsp;&nbsp;所有成員</h4>
									</div>
									<div class="modal-body">
										<div class="banMessage"></div>
										
										<div id="member-result" class="row">
											<h1 class="col-md-12 text-center">
										        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>
										    </h1>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
									</div>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.cancel event modal -->
						
					</div>
					<!-- /.page-content -->
				</div>
			</div>
			<!-- /.main-content -->
	
			<div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						<span class="bigger-120">
								<span class="blue bolder">Ace</span> Application &copy; 2013-2014
						</span>
	
						&nbsp; &nbsp;
						<span class="action-buttons">
								<a href="#">
									<i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
								</a>
	
								<a href="#">
									<i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
								</a>
	
								<a href="#">
									<i class="ace-icon fa fa-rss-square orange bigger-150"></i>
								</a>
							</span>
					</div>
				</div>
			</div>
	
			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div>

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="assets/js/jquery-2.1.4.min.js"></script>
		<script type="text/javascript" src="function/js/navActive.js"></script>
		<!-- <![endif]-->

		<!--[if IE]>
		<script src="assets/js/jquery-1.11.3.min.js"></script>
		<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>
    
		<!-- page specific plugin scripts -->
		<script src="assets/js/jquery.dataTables.min.js"></script>
		<script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>
		<script src="assets/js/dataTables.buttons.min.js"></script>
		<script src="assets/js/buttons.flash.min.js"></script>
		<script src="assets/js/buttons.html5.min.js"></script>
		<script src="assets/js/buttons.print.min.js"></script>
		<script src="assets/js/buttons.colVis.min.js"></script>
		<script src="assets/js/dataTables.select.min.js"></script>

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>


		<!-- inline scripts related to this page -->
		
		
        <script type="text/javascript" src="function/js/event.js"></script>
        
        <script type="text/javascript">

			function banUser(account = null) {
				
				var adminAccount = "<?php if(isset($_SESSION['fb_access_token'])) echo $user['email']; ?>";
				
				if(account && adminAccount) {
					$.ajax({
						url: 'api/banUser.php',
						type: 'post',
						data: {account : account,adminAccount : adminAccount},
						dataType: 'json',
						success: function(result) {
							if(result.success == true) {						
								$(".banMessage").html('<div class="alert alert-success alert-dismissible" role="alert">'+
									  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
									  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+ result.messages +
									'</div>');
		
							} else {
								$(".banMessage").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
									  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
									  '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+ result.messages +
									'</div>');
							}
						}
					});
				} else {
					alert('Error: 請重新載入網頁');
				}
				
			}
		</script>
	</body>
</html>