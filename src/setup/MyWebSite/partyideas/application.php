<?php require_once('require/allInOne.php'); ?>

		<div class="main-content">
			<div class="main-content-inner">
				<div class="breadcrumbs ace-save-state" id="breadcrumbs">
					<ul class="breadcrumb">
						<li>
							<i class="ace-icon fa fa-home home-icon"></i>
							<a href="index.php">Home</a>
						</li>
						<li class="active">審批申請 
							(
								<?php 
								switch($_GET['table']) {
									
									case "gatheringbattle":
										echo '約戰申請';
										break;
									
									case "privatebooking":
										echo '包場申請';
										break;
										
									case "boardgamebooking":
										echo '訂購申請';
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
										echo '約戰申請
											<small>
											<i class="ace-icon fa fa-angle-double-right"></i>
											尚未審批的遊戲約戰申請
											</small>';
										break;
										
									case "privatebooking":
										echo '包場申請
											<small>
											<i class="ace-icon fa fa-angle-double-right"></i>
											尚未審批的私人包場申請
											</small>';
										break;
									
									case "boardgamebooking":
										echo '訂購申請
											<small>
											<i class="ace-icon fa fa-angle-double-right"></i>
											尚未審批的遊戲訂購申請
											</small>';
										break;
								}
								?>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								
									<div class="resultMessage"></div><!-- show the result message -->
									
									<div id="application-result" class="row">
									    <h1 class="col-md-12 text-center">
									        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>
									    </h1>
									</div>
									
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
						
						<!-- approve booking modal -->
						<div class="modal fade" id="approveBookingModal">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
										<h4 class="modal-title"><i class="ace-icon fa fa-check"></i>&nbsp;&nbsp;接受申請</h4>
									</div>
									<div class="modal-body">
										<p>你確定要<strong>&nbsp;接受&nbsp;</strong>此項申請紀錄？</p>
										<?php if($_GET['table'] == "boardgamebooking") echo "<p>ps:請先聯絡買家，告知訂購及交收詳情。</p>"?>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
										<button type="button" class="btn btn-primary" id="approveBtn">確定接受</button>
									</div>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.approve booking modal -->
						
						<!-- reject booking modal -->
						<div class="modal fade" id="rejectBookingModal">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
										<h4 class="modal-title"><i class="ace-icon fa fa-times"></i>&nbsp;&nbsp;拒絕申請</h4>
									</div>
									<div class="modal-body">
										<p>你確定要<strong>&nbsp;拒絕&nbsp;</strong>此項申請紀錄？</p>
										<?php if($_GET['table'] == "boardgamebooking") echo "<p>ps:請先聯絡買家，告知拒絕他的訂購。</p>"?>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
										<button type="button" class="btn btn-primary" id="rejectBtn">確定拒絕</button>
									</div>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.reject booking modal -->
		
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">Ace</span>
							Application &copy; 2013-2014
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
		</div><!-- /.main-container -->

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

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		
		<script src="assets/js/holder.min.js"></script>
		
		<script src="function/js/application.js"></script>
	</body>
</html>
