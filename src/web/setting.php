<?php require_once('require/allInOne.php'); ?>

		<div class="main-content">
			<div class="main-content-inner">
				<div class="breadcrumbs ace-save-state" id="breadcrumbs">
					<ul class="breadcrumb">
						<li>
							<i class="ace-icon fa fa-home home-icon"></i>
							<a href="index.php">Home</a>
						</li>
							
						<?php 
						switch($_GET['table']) {
							
							case "gatheringbattleprice":
								echo '<li class="active">更新收費 (約戰收費)</li>';
								break;
							
							case "privatebookingprice":
								echo '<li class="active">更新收費 (包場收費)</li>';
								break;
								
							case "message":
								echo '<li class="active">更新設定 (通知訊息)</li>';
								break;
							
							case "indexsetting":
								echo '<li class="active">更新設定 (首頁資訊數目)</li>';
								break;
						}
						?>
					</ul>
				</div>
				
				<div class="page-content">
					<?php require_once('require/setting.html'); ?>

						<div class="page-header">
							<h1>
								<?php 
								switch($_GET['table']) {
									
									case "gatheringbattleprice":
										echo '約戰價錢
											<small>
												<i class="ace-icon fa fa-angle-double-right"></i>
												更新約戰星期一至日的收費
											</small>';
										break;
										
									case "privatebookingprice":
										echo '包場價錢
											<small>
												<i class="ace-icon fa fa-angle-double-right"></i>
												更新包場不同服務的收費
											</small>';
										break;
										
									case "message":
										echo '通知訊息
											<small>
												<i class="ace-icon fa fa-angle-double-right"></i>
												更新接受及拒絕申請的訊息
											</small>';
										break;
										
									case "indexsetting":
										echo '首頁資訊數目
											<small>
												<i class="ace-icon fa fa-angle-double-right"></i>
												更新 "最新約戰募集" 及 "最新桌遊代購" 展示數目
											</small>';
										break;
								}
								?>
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								
								<div class="resultMessage"></div>
								
								<?php 
								switch($_GET['table']) {
									
									case "gatheringbattleprice":
										echo '
										<form id="editSettingForm" action="api/updateRecord.php" method="POST" class="form-horizontal" role="form">
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="Monday"> 星期一 </label>
												<div class="col-sm-9">
													<input type="number" id="Monday" name="Monday" placeholder="星期一的收費" class="col-xs-10 col-sm-5" required />
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="Tuesday"> 星期二 </label>
												<div class="col-sm-9">
													<input type="number" id="Tuesday" name="Tuesday" placeholder="星期二的收費" class="col-xs-10 col-sm-5" required />
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="Wednesday"> 星期三 </label>
												<div class="col-sm-9">
													<input type="number" id="Wednesday" name="Wednesday" placeholder="星期三的收費" class="col-xs-10 col-sm-5" required />
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="Thursday"> 星期四 </label>
												<div class="col-sm-9">
													<input type="number" id="Thursday" name="Thursday" placeholder="星期四的收費" class="col-xs-10 col-sm-5" required />
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="Friday"> 星期五 </label>
												<div class="col-sm-9">
													<input type="number" id="Friday" name="Friday" placeholder="星期五的收費" class="col-xs-10 col-sm-5" required />
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="Saturday"> 星期六 </label>
												<div class="col-sm-9">
													<input type="number" id="Saturday" name="Saturday" placeholder="星期六的收費" class="col-xs-10 col-sm-5" required />
												</div>
											</div>
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="Sunday"> 星期日 </label>
												<div class="col-sm-9">
													<input type="number" id="Sunday" name="Sunday" placeholder="星期日的收費" class="col-xs-10 col-sm-5" required />
												</div>
											</div>
											<div class="space-4"></div>
											
											<div class="clearfix form-actions">
												<div class="col-md-offset-3 col-md-9">
													<button class="btn btn-info" id="submit" type="submit">
														<i class="ace-icon fa fa-check bigger-110"></i>
														更新收費
													</button>
						
													&nbsp; &nbsp; &nbsp;
													<button class="btn" id="reset" type="reset">
														<i class="ace-icon fa fa-undo bigger-110"></i>
														重置
													</button>
													
													&nbsp; &nbsp; &nbsp;
													<span id="loading-result" class="lead">
												        <strong><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></strong>
													</span>
												</div>
											</div>
									    </form>';
										break;
										
									case "privatebookingprice":
										echo '
										<form id="editSettingForm" action="api/updateRecord.php" method="POST" class="form-horizontal" role="form">
											<fieldset>
												<legend><strong>基本收費</strong></legend>
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="BasicPrice"> 基本價錢 </label>
													<div class="col-sm-9">
														<input type="number" id="BasicPrice" name="BasicPrice" placeholder="BASIC包場收費" class="col-xs-10 col-sm-5" required />
													</div>
												</div>
												<div class="space-4"></div>
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="BasicPeople"> 基本人數 </label>
													<div class="col-sm-9">
														<input type="number" id="BasicPeople" name="BasicPeople" placeholder="BASIC包場人數" class="col-xs-10 col-sm-5" required />
													</div>
												</div>
												<div class="space-4"></div>
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="BasicHour"> 基本時數 </label>
													<div class="col-sm-9">
														<input type="number" id="BasicHour" name="BasicHour" placeholder="BASIC包場時數" class="col-xs-10 col-sm-5" required />
													</div>
												</div>
												<div class="space-4"></div>
											</fieldset>
											
											<fieldset>
												<legend><strong>額外收費</strong></legend>
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="ExtraFoodPricePerPeople"> 額外美食收費 </label>
													<div class="col-sm-9">
														<input type="number" id="ExtraFoodPricePerPeople" name="ExtraFoodPricePerPeople" placeholder="美食到會收費" class="col-xs-10 col-sm-5" required />
														<span class="help-inline col-xs-12 col-sm-7">
															<span class="middle">(每人)</span>
														</span>
													</div>
												</div>
												<div class="space-4"></div>
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="ExtraPricePerHour"> 額外時間收費 </label>
													<div class="col-sm-9">
														<input type="number" id="ExtraPricePerHour" name="ExtraPricePerHour" placeholder="額外每1小時收費" class="col-xs-10 col-sm-5" required />
														<span class="help-inline col-xs-12 col-sm-7">
															<span class="middle">(每小時)</span>
														</span>
													</div>
												</div>
												<div class="space-4"></div>
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="ExtraPricePerPeople"> 額外人數收費 </label>
													<div class="col-sm-9">
														<input type="number" id="ExtraPricePerPeople" name="ExtraPricePerPeople" placeholder="額外每多1人收費" class="col-xs-10 col-sm-5" required />
														<span class="help-inline col-xs-12 col-sm-7">
															<span class="middle">(每人)</span>
														</span>
													</div>
												</div>
												<div class="space-4"></div>
											</fieldset>
											
											<div class="clearfix form-actions">
												<div class="col-md-offset-3 col-md-9">
													<button class="btn btn-info" id="submit" type="submit">
														<i class="ace-icon fa fa-check bigger-110"></i>
														更新收費
													</button>
						
													&nbsp; &nbsp; &nbsp;
													<button class="btn" id="reset" type="reset">
														<i class="ace-icon fa fa-undo bigger-110"></i>
														重置
													</button>
													
													&nbsp; &nbsp; &nbsp;
													<span id="loading-result" class="lead">
												        <strong><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></strong>
													</span>
												</div>
											</div>
									    </form>';
										break;
										
									case "message":
										echo '
										<form id="editSettingForm" action="api/updateRecord.php" method="POST" class="form-horizontal" role="form">
											<fieldset>
												<legend><strong>約戰訊息</strong></legend>
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="GBSuccessTitle"> 接受標題 </label>
													<div class="col-sm-9">
														<input type="text" id="GBSuccessTitle" name="GBSuccessTitle" placeholder="接受約戰後展示的標題" class="col-xs-10 col-sm-5" required />
													</div>
												</div>
												<div class="space-4"></div>
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="GBSuccessBody"> 接受內容 </label>
													<div class="col-sm-9">
														<input type="text" id="GBSuccessBody" name="GBSuccessBody" placeholder="接受約戰後展示的內容" class="col-xs-10 col-sm-5" required />
													</div>
												</div>
												<div class="space-4"></div>
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="GBCancelTitle"> 拒絕標題 </label>
													<div class="col-sm-9">
														<input type="text" id="GBCancelTitle" name="GBCancelTitle" placeholder="拒絕約戰後展示的標題" class="col-xs-10 col-sm-5" required />
													</div>
												</div>
												<div class="space-4"></div>
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="GBCancelBody"> 拒絕內容 </label>
													<div class="col-sm-9">
														<input type="text" id="GBCancelBody" name="GBCancelBody" placeholder="拒絕約戰後展示的內容" class="col-xs-10 col-sm-5" required />
													</div>
												</div>
												<div class="space-4"></div>
											</fieldset>
											
											<fieldset>
												<legend><strong>包場訊息</strong></legend>
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="PBSuccessTitle"> 接受標題 </label>
													<div class="col-sm-9">
														<input type="text" id="PBSuccessTitle" name="PBSuccessTitle" placeholder="接受包場後展示的標題" class="col-xs-10 col-sm-5" required />
													</div>
												</div>
												<div class="space-4"></div>
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="PBSuccessBody"> 接受內容 </label>
													<div class="col-sm-9">
														<input type="text" id="PBSuccessBody" name="PBSuccessBody" placeholder="接受包場後展示的內容" class="col-xs-10 col-sm-5" required />
													</div>
												</div>
												<div class="space-4"></div>
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="PBCancelTitle"> 拒絕標題 </label>
													<div class="col-sm-9">
														<input type="text" id="PBCancelTitle" name="PBCancelTitle" placeholder="拒絕包場後展示的標題" class="col-xs-10 col-sm-5" required />
													</div>
												</div>
												<div class="space-4"></div>
												<div class="form-group">
													<label class="col-sm-3 control-label no-padding-right" for="PBCancelBody"> 拒絕內容 </label>
													<div class="col-sm-9">
														<input type="text" id="PBCancelBody" name="PBCancelBody" placeholder="拒絕包場後展示的內容" class="col-xs-10 col-sm-5" required />
													</div>
												</div>
												<div class="space-4"></div>
											</fieldset>
											
											<div class="clearfix form-actions">
												<div class="col-md-offset-3 col-md-9">
													<button class="btn btn-info" id="submit" type="submit">
														<i class="ace-icon fa fa-check bigger-110"></i>
														更新通知
													</button>
						
													&nbsp; &nbsp; &nbsp;
													<button class="btn" id="reset" type="reset">
														<i class="ace-icon fa fa-undo bigger-110"></i>
														重置
													</button>
													
													&nbsp; &nbsp; &nbsp;
													<span id="loading-result" class="lead">
												        <strong><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></strong>
													</span>
												</div>
											</div>
									    </form>';
										break;
									
									case "indexsetting":
										echo '
										<br /><br />
										<form id="editSettingForm" action="api/updateRecord.php" method="POST" class="form-horizontal" role="form">
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="BGShowItem"> 桌遊展示數目 </label>
												<div class="col-sm-9">
													<input type="number" id="BGShowItem" name="BGShowItem" placeholder="最新桌遊代購" class="col-xs-10 col-sm-5" required />
												</div>
											</div>
											<br /><br />
											<div class="space-4"></div>
											<div class="form-group">
												<label class="col-sm-3 control-label no-padding-right" for="GBShowItem"> 約戰展示數目 </label>
												<div class="col-sm-9">
													<input type="number" id="GBShowItem" name="GBShowItem" placeholder="最新約戰募集" class="col-xs-10 col-sm-5" required />
												</div>
											</div>
											<div class="space-4"></div>
											<br /><br />
											
											<div class="clearfix form-actions">
												<div class="col-md-offset-3 col-md-9">
													<button class="btn btn-info" id="submit" type="submit">
														<i class="ace-icon fa fa-check bigger-110"></i>
														更新通知
													</button>
						
													&nbsp; &nbsp; &nbsp;
													<button class="btn" id="reset" type="reset">
														<i class="ace-icon fa fa-undo bigger-110"></i>
														重置
													</button>
													
													&nbsp; &nbsp; &nbsp;
													<span id="loading-result" class="lead">
												        <strong><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></strong>
													</span>
												</div>
											</div>
									    </form>';
										break;
								}
								?>
								
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
						
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

		<!--[if lte IE 8]>
		  <script src="assets/js/excanvas.min.js"></script>
		<![endif]-->
		<!--<script src="assets/js/jquery-ui.custom.min.js"></script>-->
		<!--<script src="assets/js/jquery.ui.touch-punch.min.js"></script>-->
		<!--<script src="assets/js/chosen.jquery.min.js"></script>-->
		<!--<script src="assets/js/spinbox.min.js"></script>-->
		<!--<script src="assets/js/bootstrap-datepicker.min.js"></script>-->
		<!--<script src="assets/js/bootstrap-timepicker.min.js"></script>-->
		<!--<script src="assets/js/moment.min.js"></script>-->
		<!--<script src="assets/js/daterangepicker.min.js"></script>-->
		<!--<script src="assets/js/bootstrap-datetimepicker.min.js"></script>-->
		<!--<script src="assets/js/bootstrap-colorpicker.min.js"></script>-->
		<!--<script src="assets/js/jquery.knob.min.js"></script>-->
		<!--<script src="assets/js/autosize.min.js"></script>-->
		<!--<script src="assets/js/jquery.inputlimiter.min.js"></script>-->
		<!--<script src="assets/js/jquery.maskedinput.min.js"></script>-->
		<!--<script src="assets/js/bootstrap-tag.min.js"></script>-->

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>
		
		<script type="text/javascript" src="function/js/setting.js"></script>
	</body>
</html>
