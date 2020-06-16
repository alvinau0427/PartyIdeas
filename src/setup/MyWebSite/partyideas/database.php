<?php require_once('require/allInOne.php'); ?>

		<div class="main-content">
			<div class="main-content-inner">
				<div class="breadcrumbs ace-save-state" id="breadcrumbs">
					<ul class="breadcrumb">
						<li>
							<i class="ace-icon fa fa-home home-icon"></i>
							<a href="index.php">Home</a>
						</li>
						<li class="active">數據庫 (<?php echo $_GET['table']; ?>)</li>
					</ul>
				</div>

				<div class="page-content">
					
					<?php require_once('require/setting.html'); ?>
					
						<div class="page-header">
							<h1>
								數據庫
								<small>
									<i class="ace-icon fa fa-angle-double-right"></i>
									<span><?php echo $_GET['table']; ?></span>
								</small>
							</h1>
						</div><!-- /.page-header -->
						
						<div class="row">
							<div class="col-xs-12">
							    <!-- PAGE CONTENT BEGINS -->
						        <div class="row">
						        	<div class="col-xs-12">
						        		<?php 
						        			if($_GET['table']=="photo") {
						        				echo '<div class="alert alert-info alert-dismissible" role="alert">
													  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													  <strong> <span class="glyphicon glyphicon-info-sign"></span> </strong>"包場價錢" 相片最多有1張，不可以沒有！
													</div>';
						        			}
						        		?>
						        		<div class="removeMessage"></div><!-- show the remove message -->
						        
						        		<button class="btn btn-primary" data-toggle="modal" data-target="#addRecordModal" id="addRecordModalBtn"
						        			<?php if($_GET['table']=="photo" || $_GET['table']=="notification") echo 'disabled="disabled"'; ?> >
						        			<span class="glyphicon glyphicon-plus-sign"></span>&nbsp;&nbsp;新增&nbsp;<span class="text-capitalize"><?php echo $_GET['table']; ?></span>
						        		</button>
						        		
						        
						        		<div class="clearfix">
						        			<div class="pull-right tableTools-container"></div>
						        		</div>
						        		<div class="table-header">
						        			Results for "<?php echo $_GET['table']; ?>" table
						        		</div>
						        
						        		<!-- div.table-responsive -->
						        
						        		<!-- div.dataTables_borderWrap -->
						        		<div id="database-result">
											<table id="dynamic-table" class="table table-striped table-bordered table-hover">
												<thead>
													<tr>
														<?php 
														if($_GET['table'] == "photo"){
															echo "<th>ID</th>
																	<th>PhotoName</th>
																	<th>Photo</th>
																	<th>Status</th>";
																	
														} elseif ($_GET['table'] == "users") {
															echo '<th>ID</th>
																	<th>Token</th>
																	<th>Account</th>
																	<th>ReceiveNotification</th>';
														} else {
															require_once 'require/connection/conn.php';
														
															$sql = "select DISTINCT(COLUMN_NAME) from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME='{$_GET['table']}'";
															$rs = mysqli_query($conn,$sql) or die(mysqli_error($conn));
															while($rc = mysqli_fetch_assoc($rs)){
																echo "<th> {$rc['COLUMN_NAME']} </th>";
															}
															
															mysqli_close($conn);
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
						
						<!-- add record modal -->
						<div class="modal fade" id="addRecordModal">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
										<h4 class="modal-title">
											<span class="glyphicon glyphicon-plus-sign"></span>&nbsp;&nbsp;新增&nbsp;<span class="text-capitalize"><?php echo $_GET['table']; ?></span>
										</h4>
									</div>
									
									<form class="form-horizontal" role="form" action="api/insertRecord.php" method="POST" id="addRecordForm">
										<div class="modal-body">
						
											<div class="addMessage"></div>
												
											<?php 
											genForm();
											?>
											
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
											<button type="submit" class="btn btn-primary">確定新增</button>
										</div>
									</form>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div>
						<!-- /. add record modal -->
						
						<!-- edit record modal -->
						<div class="modal fade" id="editRecordModal">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
										<h4 class="modal-title">
											<span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;修改&nbsp;<span class="text-capitalize"><?php echo $_GET['table']; ?></span>
										</h4>
									</div>
									<form class="form-horizontal" role="form" action="api/updateRecord.php" method="POST" id="editRecordForm">
										
										<div class="modal-body">
											
											<div class="editMessage"></div>
							
											<?php 
											genForm("edit");
											?>
											
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
											<button type="submit" class="btn btn-primary">保存修改</button>
										</div>
									</form>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div>
						<!-- /.edit record modal -->
						
						<!-- remove record modal -->
						<div class="modal fade" id="removeRecordModal">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
										<h4 class="modal-title">
											<span class="glyphicon glyphicon-trash"></span>&nbsp;&nbsp;移除&nbsp;<span class="text-capitalize"><?php echo $_GET['table']; ?></span>
										</h4>
									</div>
									<div class="modal-body">
										<p>你確定要移除此項紀錄 ?</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">關閉</button>
										<button type="button" class="btn btn-primary" id="removeBtn">確定移除</button>
									</div>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div>
						<!-- /.remove record modal -->
						
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
		
		
		<?php 
		function genForm($edit = "") {
			if($_GET['table'] == "admin") {
				echo'
							<div class="form-group">
								<label for="'.$edit.'Name" class="col-sm-2 control-label">管理員名字</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Name" name="'.$edit.'Name" placeholder="管理員的稱呼或名字">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'LoginAccount" class="col-sm-2 control-label">登入帳戶</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'LoginAccount" name="'.$edit.'LoginAccount" placeholder="Facebook 登入用的手機號碼或電子郵件">
								</div>
							</div>';
			}
			
			if($_GET['table'] == "blacklist") {
				
				require 'require/connection/conn.php';
														
				$sql = "select AdminID, Name from admin";
				$rs = mysqli_query($conn,$sql) ;
				
				$option = '';
				while($rc = mysqli_fetch_assoc($rs)){
					$option .= '<option value="'.$rc['AdminID'].'">'.$rc['Name'].'</option>';
				}
				
				echo'
							<div class="form-group">
								<label for="'.$edit.'Account" class="col-sm-2 control-label">封鎖帳戶</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Account" name="'.$edit.'Account" placeholder="Account">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Status" class="col-sm-2 control-label">封鎖狀態</label>
								<div class="col-sm-10">
									<select class="form-control" id="'.$edit.'Status" name="'.$edit.'Status">
										<option value="">~~請選擇~~</option>
										<option value="0">黃牌 (警告)</option>
										<option value="1">紅牌 (封鎖)</option>
									</select>
								</div>
							</div>
		
							<div class="form-group">
								<label for="'.$edit.'BlackListDate" class="col-sm-2 control-label">封鎖日期</label>
								<div class="col-sm-10">
									<input type="date" class="form-control" id="'.$edit.'BlackListDate" name="'.$edit.'BlackListDate" value="'.date("Y-m-d").'">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Admin" class="col-sm-2 control-label">管理員</label>
								<div class="col-sm-10">
									<select class="form-control" id="'.$edit.'Admin" name="'.$edit.'Admin">
										<option value="">~~請選擇~~</option>
										'.$option.'
									</select>
								</div>
							</div>';
			}
			
			if($_GET['table'] == "boardgame") {
				
				require 'require/connection/conn.php';
														
				$sql = "select ID, Type from boardgametype";
				$rs = mysqli_query($conn,$sql) ;
				
				$option = '';
				while($rc = mysqli_fetch_assoc($rs)){
					$option .= '<option value="'.$rc['ID'].'">'.$rc['Type'].'</option>';
				}
				
				mysqli_close($conn);
				
				echo'
							<div class="form-group">
								<label for="'.$edit.'BoardGameName" class="col-sm-2 control-label">遊戲名字</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'BoardGameName" name="'.$edit.'BoardGameName" placeholder="BoardGameName">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'BoardGameDetail" class="col-sm-2 control-label">遊戲詳情</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'BoardGameDetail" name="'.$edit.'BoardGameDetail" placeholder="BoardGameDetail">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'BoardGameType" class="col-sm-2 control-label">遊戲類型</label>
								<div class="col-sm-10">
									<select class="form-control" id="'.$edit.'BoardGameType" name="'.$edit.'BoardGameType">
										<option value="">~~請選擇~~</option>
										'.$option.'
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Year" class="col-sm-2 control-label">生產年份</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Year" name="'.$edit.'Year" placeholder="Year">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Price" class="col-sm-2 control-label">價錢</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Price" name="'.$edit.'Price" placeholder="Price">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Quantity" class="col-sm-2 control-label">貨存</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Quantity" name="'.$edit.'Quantity" placeholder="Quantity">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Player_Minimum" class="col-sm-2 control-label">最少人數</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Player_Minimum" name="'.$edit.'Player_Minimum" placeholder="Player_Minimum">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Player_Maximum" class="col-sm-2 control-label">最多人數</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Player_Maximum" name="'.$edit.'Player_Maximum" placeholder="Player_Maximum">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'LimitationAge" class="col-sm-2 control-label">限制年齡</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'LimitationAge" name="'.$edit.'LimitationAge" placeholder="LimitationAge">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Photo" class="col-sm-2 control-label">相片</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Photo" name="'.$edit.'Photo" placeholder="Photo">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Status" class="col-sm-2 control-label">狀態</label>
								<div class="col-sm-10">
									<select class="form-control" id="'.$edit.'Status" name="'.$edit.'Status">
										<option value="">~~請選擇~~</option>
										<option value="0">售賣</option>
										<option value="1">已售罄</option>
									</select>
								</div>
							</div>';
			}
			
			if($_GET['table'] == "boardgamebooking") {
				
				echo'
							<div class="form-group">
								<label for="'.$edit.'BoardGameID" class="col-sm-2 control-label">遊戲ID</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'BoardGameID" name="'.$edit.'BoardGameID" placeholder="BoardGameID">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Quantity" class="col-sm-2 control-label">數量</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Quantity" name="'.$edit.'Quantity" placeholder="Quantity">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'TotalPrice" class="col-sm-2 control-label">總額</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'TotalPrice" name="'.$edit.'TotalPrice" placeholder="TotalPrice">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'MemberName" class="col-sm-2 control-label">買家</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'MemberName" name="'.$edit.'MemberName" placeholder="MemberName">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Contact" class="col-sm-2 control-label">聯絡方法</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Contact" name="'.$edit.'Contact" placeholder="Contact">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'OrderDate" class="col-sm-2 control-label">訂購日期</label>
								<div class="col-sm-10">
									<input type="date" class="form-control" id="'.$edit.'OrderDate" name="'.$edit.'OrderDate" placeholder="OrderDate">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'OrderTime" class="col-sm-2 control-label">訂購時間</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'OrderTime" name="'.$edit.'OrderTime" placeholder="OrderTime">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'ReceiptDate" class="col-sm-2 control-label">成交日期</label>
								<div class="col-sm-10">
									<input type="date" class="form-control" id="'.$edit.'ReceiptDate" name="'.$edit.'ReceiptDate" placeholder="ReceiptDate">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'ReceiptTime" class="col-sm-2 control-label">成交時間</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'ReceiptTime" name="'.$edit.'ReceiptTime" placeholder="ReceiptTime">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Status" class="col-sm-2 control-label">狀態</label>
								<div class="col-sm-10">
									<select class="form-control" id="'.$edit.'Status" name="'.$edit.'Status">
										<option value="">~~請選擇~~</option>
										<option value="0">等待審批</option>
										<option value="1">已接受</option>
										<option value="2">已拒絕</option>
										<option value="3">已完成</option>
										<option value="4">已取消</option>
									</select>
								</div>
							</div>';
			}
			
			if($_GET['table'] == "boardgametype") {
				echo'
							<div class="form-group">
								<label for="'.$edit.'Type" class="col-sm-2 control-label">遊戲類型</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Type" name="'.$edit.'Type" placeholder="Type">
								</div>
							</div>';
			}
			
			if($_GET['table'] == "gatheringbattle") {
				echo'
							<div class="form-group">
								<label for="'.$edit.'BoardGameID" class="col-sm-2 control-label">遊戲ID</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'BoardGameID" name="'.$edit.'BoardGameID" placeholder="BoardGameID">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'MemberName" class="col-sm-2 control-label">房主</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'MemberName" name="'.$edit.'MemberName" placeholder="MemberName">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Account" class="col-sm-2 control-label">房主帳戶</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Account" name="'.$edit.'Account" placeholder="Account">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Contact" class="col-sm-2 control-label">聯絡方法</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Contact" name="'.$edit.'Contact" placeholder="Contact">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Date" class="col-sm-2 control-label">日期</label>
								<div class="col-sm-10">
									<input type="date" class="form-control" id="'.$edit.'Date" name="'.$edit.'Date" placeholder="Date">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Time" class="col-sm-2 control-label">開始時間</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Time" name="'.$edit.'Time" placeholder="Time">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'EndTime" class="col-sm-2 control-label">完結時間</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'EndTime" name="'.$edit.'EndTime" placeholder="EndTime">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Place" class="col-sm-2 control-label">地點ID</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Place" name="'.$edit.'Place" placeholder="Place">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'ParticipantRequirement" class="col-sm-2 control-label">人數要求</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'ParticipantRequirement" name="'.$edit.'ParticipantRequirement" placeholder="ParticipantRequirement">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Status" class="col-sm-2 control-label">狀態</label>
								<div class="col-sm-10">
									<select class="form-control" id="'.$edit.'Status" name="'.$edit.'Status">
										<option value="">~~請選擇~~</option>
										<option value="-1">人數未滿</option>
										<option value="0">等待審批</option>
										<option value="1">已接受</option>
										<option value="2">已拒絕</option>
										<option value="3">已完成</option>
										<option value="4">已取消</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'JoinedParticipant" class="col-sm-2 control-label">參加者</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'JoinedParticipant" name="'.$edit.'JoinedParticipant" placeholder="JoinedParticipant">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'JoinedParticipantToken" class="col-sm-2 control-label">參加者Token</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'JoinedParticipantToken" name="'.$edit.'JoinedParticipantToken" placeholder="JoinedParticipantToken">
								</div>
							</div>';
			}
			
			if($_GET['table'] == "location") {
				echo'
							<div class="form-group">
								<label for="'.$edit.'Place" class="col-sm-2 control-label">地點</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Place" name="'.$edit.'Place" placeholder="Place">
								</div>
							</div>';
			}
			
			if($_GET['table'] == "notification") {
				echo'
							<div class="form-group">
								<label for="'.$edit.'Title" class="col-sm-2 control-label">標題</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Title" name="'.$edit.'Title" placeholder="Title">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Body" class="col-sm-2 control-label">內容</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Body" name="'.$edit.'Body" placeholder="Body">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Uid" class="col-sm-2 control-label">Uid</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Uid" name="'.$edit.'Uid" placeholder="Uid">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Name" class="col-sm-2 control-label">Name</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Name" name="'.$edit.'Name" placeholder="Name">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Date" class="col-sm-2 control-label">日期時間</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Date" name="'.$edit.'Date" placeholder="Date">
								</div>
							</div>';
			}
			
			if($_GET['table'] == "photo") {
				echo'
							<div class="form-group">
								<label for="'.$edit.'PhotoName" class="col-sm-2 control-label">相片名字</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'PhotoName" name="'.$edit.'PhotoName" placeholder="PhotoName" readonly>
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Status" class="col-sm-2 control-label">顯示狀態</label>
								<div class="col-sm-10">
									<select class="form-control" id="'.$edit.'Status" name="'.$edit.'Status">
										<option value="">~~請選擇~~</option>
										<option value="0">不顯示</option>
										<option value="1">首頁顯示</option>
										<option value="2">包場價錢</option>
									</select>
								</div>
							</div>';
			}
			
			if($_GET['table'] == "privatebooking") {
				echo'
							<div class="form-group">
								<label for="'.$edit.'MemberName" class="col-sm-2 control-label">包場者</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'MemberName" name="'.$edit.'MemberName" placeholder="MemberName">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Account" class="col-sm-2 control-label">包場者帳戶</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Account" name="'.$edit.'Account" placeholder="Account">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Contact" class="col-sm-2 control-label">聯絡方法</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Contact" name="'.$edit.'Contact" placeholder="Contact">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Date" class="col-sm-2 control-label">日期</label>
								<div class="col-sm-10">
									<input type="date" class="form-control" id="'.$edit.'Date" name="'.$edit.'Date" placeholder="Date">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Time" class="col-sm-2 control-label">開始時間</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Time" name="'.$edit.'Time" placeholder="Time">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'EndTime" class="col-sm-2 control-label">完結時間</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'EndTime" name="'.$edit.'EndTime" placeholder="EndTime">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Place" class="col-sm-2 control-label">地點ID</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Place" name="'.$edit.'Place" placeholder="Place">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'NumberOfPeople" class="col-sm-2 control-label">人數</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'NumberOfPeople" name="'.$edit.'NumberOfPeople" placeholder="NumberOfPeople">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'TotalPrice" class="col-sm-2 control-label">總額</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'TotalPrice" name="'.$edit.'TotalPrice" placeholder="TotalPrice">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Discount" class="col-sm-2 control-label">折扣</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Discount" name="'.$edit.'Discount" placeholder="Discount">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Remark" class="col-sm-2 control-label">備註</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Remark" name="'.$edit.'Remark" placeholder="Remark">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Photo" class="col-sm-2 control-label">相片</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Photo" name="'.$edit.'Photo" placeholder="Photo">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Status" class="col-sm-2 control-label">狀態</label>
								<div class="col-sm-10">
									<select class="form-control" id="'.$edit.'Status" name="'.$edit.'Status">
										<option value="">~~請選擇~~</option>
										<option value="0">等待審批</option>
										<option value="1">已接受</option>
										<option value="2">已拒絕</option>
										<option value="3">已完成</option>
										<option value="4">已取消</option>
									</select>
								</div>
							</div>';
			}
			
			if($_GET['table'] == "users") {
				echo '
							<div class="form-group">
								<label for="'.$edit.'Token" class="col-sm-2 control-label">Token</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Token" name="'.$edit.'Token" placeholder="Token">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'Account" class="col-sm-2 control-label">帳戶</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="'.$edit.'Account" name="'.$edit.'Account" placeholder="Account">
								</div>
							</div>
							<div class="form-group">
								<label for="'.$edit.'ReceiveNotification" class="col-sm-2 control-label">接收資訊</label>
								<div class="col-sm-10">
									<select class="form-control" id="'.$edit.'ReceiveNotification" name="'.$edit.'ReceiveNotification">
										<option value="">~~請選擇~~</option>
										<option value="0">接受訊息</option>
										<option value="1">不接受訊息</option>
									</select>
								</div>
							</div>';
			}
		}
		?>
		
		
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

		<!-- ace scripts nav bar click-->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>


		<!-- inline scripts related to this page -->
		<!--<script type="text/javascript" src="function/js/function.js"></script>-->
        <script type="text/javascript" src="function/js/database.js"></script>
	</body>
</html>