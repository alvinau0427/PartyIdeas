<?php require_once('require/allInOne.php'); ?>

		<div class="main-content">
			<div class="main-content-inner">
				<div class="breadcrumbs ace-save-state" id="breadcrumbs">
					<ul class="breadcrumb">
						<li>
							<i class="ace-icon fa fa-home home-icon"></i>
							<a href="index.php">Home</a>
						</li>
						<li class="active">上載圖片 
							(
								<?php 
								switch($_GET['table']) {
									
									case "photo":
										echo '上載資訊圖片';
										break;
									
									case "boardgame":
										echo '上載桌遊圖片';
										break;
								}
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
									
									case "photo":
										echo '上載資訊圖片
											<small>
												<i class="ace-icon fa fa-angle-double-right"></i>
												上載 首頁資訊 及 價格 圖片
											</small>';
											
										$action = "api/uploadImageToPhoto.php";
										$cloudColor = "black";
										$image = "Information";
										break;
										
									case "boardgame":
										echo '上載桌遊圖片
											<small>
												<i class="ace-icon fa fa-angle-double-right"></i>
												上載 桌遊(Board Game) 圖片
											</small>';
											
										$action = "api/uploadImageToBoardGame.php";
										$cloudColor = "blue";
										$image = "Board Game";
										break;
								}
								?>
							</h1>
						</div><!-- /.page-header -->
						
						<div class="row">
							<div class="col-xs-12">

								<div>
									<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="dropzone well" id="dropzone">
										<div class="fallback">
											<input name="file" type="file" multiple="" />
										</div>
									</form>
								</div>

								<div id="preview-template" class="hide">
									<div class="dz-preview dz-file-preview">
										<div class="dz-image">
											<img data-dz-thumbnail="" />
										</div>

										<div class="dz-details">
											<div class="dz-size">
												<span data-dz-size=""></span>
											</div>

											<div class="dz-filename">
												<span data-dz-name=""></span>
											</div>
										</div>

										<div class="dz-progress">
											<span class="dz-upload" data-dz-uploadprogress=""></span>
										</div>

										<div class="dz-error-message">
											<span data-dz-errormessage=""></span>
										</div>

										<div class="dz-success-mark">
											<span class="fa-stack fa-lg bigger-150">
												<i class="fa fa-circle fa-stack-2x white"></i>

												<i class="fa fa-check fa-stack-1x fa-inverse green"></i>
											</span>
										</div>

										<div class="dz-error-mark">
											<span class="fa-stack fa-lg bigger-150">
												<i class="fa fa-circle fa-stack-2x white"></i>

												<i class="fa fa-remove fa-stack-1x fa-inverse red"></i>
											</span>
										</div>
									</div>
								</div><!-- PAGE CONTENT ENDS -->
								
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
		<script src="assets/js/dropzone.min.js"></script>

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>
		
		
		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($){
			
			try {
			  Dropzone.autoDiscover = false;
			
			  var myDropzone = new Dropzone('#dropzone', {
			    previewTemplate: $('#preview-template').html(),
			    
				thumbnailHeight: 120,
			    thumbnailWidth: 120,
			    maxFilesize: 5,
				
				accept: function(file, done) {
		            if (file.type != "image/jpeg" && file.type != "image/png") {
		                done("只接受圖片格式 jpeg 及 png ");
		            }
		            else { 
		            	done(); 
		            }
		        },
				// addRemoveLinks : true,
				// dictRemoveFile: 'Remove',
				
				dictDefaultMessage :
				'<span class="bigger-150 bolder"><i class="ace-icon fa fa-caret-right red"></i> Drop <?php echo $image; ?> Images</span> to upload \
				<span class="smaller-80 grey">(or click)</span> <br /> \
				<i class="upload-icon ace-icon fa fa-cloud-upload <?php echo $cloudColor; ?> fa-3x"></i>'
			,
				
			    thumbnail: function(file, dataUrl) {
			      if (file.previewElement) {
			        $(file.previewElement).removeClass("dz-file-preview");
			        var images = $(file.previewElement).find("[data-dz-thumbnail]").each(function() {
						var thumbnailElement = this;
						thumbnailElement.alt = file.name;
						thumbnailElement.src = dataUrl;
					});
			        setTimeout(function() { $(file.previewElement).addClass("dz-image-preview"); }, 1);
			      }
			    }
			
			  });
			
			   //remove dropzone instance when leaving this page in ajax mode
			   $(document).one('ajaxloadstart.page', function(e) {
					try {
						myDropzone.destroy();
					} catch(e) {}
			   });
			
			} catch(e) {
			  alert('Dropzone.js does not support older browsers!');
			}
			
			});
		</script>
		
	</body>
</html>