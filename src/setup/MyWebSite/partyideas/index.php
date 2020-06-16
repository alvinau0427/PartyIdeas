<?php 
	require_once('require/connection/conn.php');
	require_once('require/allInOne.php');
?>

		<div class="main-content">
			<div class="main-content-inner">
				<div class="breadcrumbs ace-save-state" id="breadcrumbs">
					<ul class="breadcrumb">
						<li>
							<i class="ace-icon fa fa-home home-icon"></i>
							<a href="index.php">Home</a>
						</li>
						<li class="active">Dashboard</li>
					</ul>
				</div>
				
				<div class="page-content">
					<?php require_once('require/setting.html'); ?>
<?php
	// if($_SESSION['isAdmin'] == 1){
	// print $_SESSION['isAdmin'];
	
	require_once('require/getCalendar.php');
	
	$sql = 'select * from boardgamebooking where Status = 0';
	$rs = mysqli_query($conn,$sql) or die(mysqli_error($conn));
	$newboardgamebooking = mysqli_num_rows($rs);
	
	$sql = 'select * from gatheringbattle where Status = 0';
	$rs = mysqli_query($conn,$sql) or die(mysqli_error($conn));
	$newgatheringbattle = mysqli_num_rows($rs);
	
	$sql = 'select * from privatebooking where Status = 0';
	$rs = mysqli_query($conn,$sql) or die(mysqli_error($conn));
	$newprivatebooking = mysqli_num_rows($rs);
?>

					<div class="page-header">
						<h1> Dashboard <small> <i class="ace-icon fa fa-angle-double-right"></i> overview &amp; stats </small></h1>
					</div>
					<!-- /.page-header -->

					<div class="row">
						<div class="col-xs-12">
							
							
							<!-- PAGE CONTENT BEGINS -->
							<div class="alert alert-block alert-success">
								<button type="button" class="close" data-dismiss="alert">
									<i class="ace-icon fa fa-times"></i>
								</button>

								<i class="ace-icon fa fa-check green"></i> Welcome to
								<strong class="green">
									Party Ideas Content Management System
									<small>(v1.0)</small>
								</strong>
							</div>

							<div class="row center">
								<div class="space-6"></div>

								<div class="col-sm-12 infobox-container">
									
									<a href="application.php?table=gatheringbattle">
										<div class="infobox infobox-green">
											<div class="infobox-icon">
												<i class="ace-icon fa fa-comments"></i>
											</div>
	
											<div class="infobox-data">
												<span class="infobox-data-number"><?= $newgatheringbattle ?></span>
												<div class="infobox-content">新約戰申請</div>
											</div>
	
											<!--<div class="stat stat-success">8%</div>-->
										</div>
									</a>
									
									<a href="application.php?table=privatebooking">
										<div class="infobox infobox-blue">
											<div class="infobox-icon">
												<i class="ace-icon fa fa-twitter"></i>
											</div>
	
											<div class="infobox-data">
												<span class="infobox-data-number"><?= $newprivatebooking ?></span>
												<div class="infobox-content">新包場申請</div>
											</div>
	
											<!--<div class="badge badge-success">-->
											<!--	+32%-->
											<!--	<i class="ace-icon fa fa-arrow-up"></i>-->
											<!--</div>-->
										</div>
									</a>

									<a href="application.php?table=boardgamebooking">
										<div class="infobox infobox-pink">
											<div class="infobox-icon">
												<i class="ace-icon fa fa-shopping-cart"></i>
											</div>
	
											<div class="infobox-data">
												<span class="infobox-data-number"><?= $newboardgamebooking ?></span>
												<div class="infobox-content">新遊戲預定</div>
											</div>
											<!--<div class="stat stat-important">4%</div>-->
										</div>
									</a>

									<!--<div class="infobox infobox-red">-->
									<!--	<div class="infobox-icon">-->
									<!--		<i class="ace-icon fa fa-flask"></i>-->
									<!--	</div>-->

									<!--	<div class="infobox-data">-->
									<!--		<span class="infobox-data-number">7</span>-->
									<!--		<div class="infobox-content">新意見</div>-->
									<!--	</div>-->
									<!--</div>-->

									<!--<div class="infobox infobox-orange2">-->
									<!--	<div class="infobox-chart">-->
									<!--		<span class="sparkline" data-values="196,128,202,177,154,94,100,170,224"></span>-->
									<!--	</div>-->

									<!--	<div class="infobox-data">-->
									<!--		<span class="infobox-data-number">6,251</span>-->
									<!--		<div class="infobox-content">pageviews</div>-->
									<!--	</div>-->

									<!--	<div class="badge badge-success">-->
									<!--		7.2%-->
									<!--		<i class="ace-icon fa fa-arrow-up"></i>-->
									<!--	</div>-->
									<!--</div>-->

									<!--<div class="infobox infobox-blue2">-->
									<!--	<div class="infobox-progress">-->
									<!--		<div class="easy-pie-chart percentage" data-percent="42" data-size="46">-->
									<!--			<span class="percent">42</span>%-->
									<!--		</div>-->
									<!--	</div>-->

									<!--	<div class="infobox-data">-->
									<!--		<span class="infobox-text">traffic used</span>-->

									<!--		<div class="infobox-content">-->
									<!--			<span class="bigger-110">~</span> 58GB remaining-->
									<!--		</div>-->
									<!--	</div>-->
									<!--</div>-->

									<!--<div class="space-6"></div>-->

									<!--<div class="infobox infobox-green infobox-small infobox-dark">-->
									<!--	<div class="infobox-progress">-->
									<!--		<div class="easy-pie-chart percentage" data-percent="61" data-size="39">-->
									<!--			<span class="percent">61</span>%-->
									<!--		</div>-->
									<!--	</div>-->

									<!--	<div class="infobox-data">-->
									<!--		<div class="infobox-content">Task</div>-->
									<!--		<div class="infobox-content">Completion</div>-->
									<!--	</div>-->
									<!--</div>-->

									<!--<div class="infobox infobox-blue infobox-small infobox-dark">-->
									<!--	<div class="infobox-chart">-->
									<!--		<span class="sparkline" data-values="3,4,2,3,4,4,2,2"></span>-->
									<!--	</div>-->

									<!--	<div class="infobox-data">-->
									<!--		<div class="infobox-content">Earnings</div>-->
									<!--		<div class="infobox-content">$32,000</div>-->
									<!--	</div>-->
									<!--</div>-->

									<!--<div class="infobox infobox-grey infobox-small infobox-dark">-->
									<!--	<div class="infobox-icon">-->
									<!--		<i class="ace-icon fa fa-download"></i>-->
									<!--	</div>-->

									<!--	<div class="infobox-data">-->
									<!--		<div class="infobox-content">Downloads</div>-->
									<!--		<div class="infobox-content">1,205</div>-->
									<!--	</div>-->
									<!--</div>-->
								</div>
							</div>
							<!-- /.row -->

							<div class="hr hr32 hr-dotted"></div>
							
							<div class="row center">
								<div class="space-6"></div>

								<div class="col-sm-12">
									<div class="widget-box">
										<div class="widget-header">
											<h4 class="widget-title lighter smaller">
													<i class="ace-icon fa fa-comment blue"></i>
													最新消息 (5)
												</h4>
										</div>

										<div class="widget-body">
											<div class="widget-main no-padding">
												<div class="dialogs" id="message">
													<!--<div class="dialogs ace-scroll">-->
													<!--	<div class="scroll-track scroll-active" style="display:block; height: 300px;">-->
													<!--		<div class="scroll-bar" style="height: 236px; top: 0px;"></div>-->
													<!--	</div>-->
													<!--	<div class="scroll-content" style="max-height: 1000px;" id="message">-->
															
													<!--	</div>-->
													<!--</div>-->
							
												</div>

												<form method="post" action="api/addNotification.php" id="notificationForm">
													<div class="form-actions">
														<div class="input-group">
															<input placeholder="Type a title here ..." type="text" class="form-control" name="title" id="title"/>
															<input placeholder="Type your message here ..." type="text" class="form-control" name="body" id="body"/>
															<input type="hidden" name="name" value="<?= $user['name'] ?>" id="name"/>
															<input type="hidden" name="uid" value="<?= $user['id'] ?>" id="uid"/>
															
															<span class="input-group-btn">
																<button class="btn btn-sm btn-info no-radius" type="button" id="submit">
																	<i class="ace-icon fa fa-share"></i>
																	Send
																</button>
															</span>
														</div>
													</div>
												</form>
											</div>
											<!-- /.widget-main -->
										</div>
										<!-- /.widget-body -->
									</div>
									<!-- /.widget-box -->
								</div>
								<!-- /.col -->
							</div>
							<!-- /.row -->
							
							<div class="hr hr32 hr-dotted"></div>

							
							<?php require_once('calendar-index.php'); ?>
							
							<div class='space'> </div>
									
							<div class="hr hr32 hr-dotted"></div>


							<!-- PAGE CONTENT ENDS -->
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->
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
	<!-- /.main-container -->

	<!-- basic scripts -->

	<!--[if !IE]> -->
	<script src="assets/js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="function/js/navActive.js"></script>
	<!-- <![endif]-->

	<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
	<script type="text/javascript">
		if ('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
	</script>
	<script src="assets/js/bootstrap.min.js"></script>

	<!-- page specific plugin scripts -->
	<script src="function/js/function.js"></script>

	<!--[if lte IE 8]>
		  <script src="assets/js/excanvas.min.js"></script>
		<![endif]-->
	<script src="assets/js/jquery-ui.custom.min.js"></script>
	<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
	<script src="assets/js/jquery.easypiechart.min.js"></script>
	<script src="assets/js/jquery.sparkline.index.min.js"></script>
	<script src="assets/js/jquery.flot.min.js"></script>
	<script src="assets/js/jquery.flot.pie.min.js"></script>
	<script src="assets/js/jquery.flot.resize.min.js"></script>

	<!-- ace scripts -->
	<script src="assets/js/ace-elements.min.js"></script>
	<script src="assets/js/ace.min.js"></script>

	<!-- inline scripts related to this page -->
	<script type="text/javascript">
		jQuery(function($) {
			$('.easy-pie-chart.percentage').each(function() {
				var $box = $(this).closest('.infobox');
				var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
				var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
				var size = parseInt($(this).data('size')) || 50;
				$(this).easyPieChart({
					barColor: barColor,
					trackColor: trackColor,
					scaleColor: false,
					lineCap: 'butt',
					lineWidth: parseInt(size / 10),
					animate: ace.vars['old_ie'] ? false : 1000,
					size: size
				});
			})

			$('.sparkline').each(function() {
				var $box = $(this).closest('.infobox');
				var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
				$(this).sparkline('html', {
					tagValuesAttribute: 'data-values',
					type: 'bar',
					barColor: barColor,
					chartRangeMin: $(this).data('min') || 0
				});
			});


			//flot chart resize plugin, somehow manipulates default browser resize event to optimize it!
			//but sometimes it brings up errors with normal resize event handlers
			$.resize.throttleWindow = false;

			var placeholder = $('#piechart-placeholder').css({
				'width': '90%',
				'min-height': '150px'
			});
			var data = [{
				label: "social networks",
				data: 38.7,
				color: "#68BC31"
			}, {
				label: "search engines",
				data: 24.5,
				color: "#2091CF"
			}, {
				label: "ad campaigns",
				data: 8.2,
				color: "#AF4E96"
			}, {
				label: "direct traffic",
				data: 18.6,
				color: "#DA5430"
			}, {
				label: "other",
				data: 10,
				color: "#FEE074"
			}]

			function drawPieChart(placeholder, data, position) {
				$.plot(placeholder, data, {
					series: {
						pie: {
							show: true,
							tilt: 0.8,
							highlight: {
								opacity: 0.25
							},
							stroke: {
								color: '#fff',
								width: 2
							},
							startAngle: 2
						}
					},
					legend: {
						show: true,
						position: position || "ne",
						labelBoxBorderColor: null,
						margin: [-30, 15]
					},
					grid: {
						hoverable: true,
						clickable: true
					}
				})
			}
			drawPieChart(placeholder, data);

			/**
			we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
			so that's not needed actually.
			*/
			placeholder.data('chart', data);
			placeholder.data('draw', drawPieChart);


			//pie chart tooltip example
			var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
			var previousPoint = null;

			placeholder.on('plothover', function(event, pos, item) {
				if (item) {
					if (previousPoint != item.seriesIndex) {
						previousPoint = item.seriesIndex;
						var tip = item.series['label'] + " : " + item.series['percent'] + '%';
						$tooltip.show().children(0).text(tip);
					}
					$tooltip.css({
						top: pos.pageY + 10,
						left: pos.pageX + 10
					});
				}
				else {
					$tooltip.hide();
					previousPoint = null;
				}

			});

			/////////////////////////////////////
			$(document).one('ajaxloadstart.page', function(e) {
				$tooltip.remove();
			});




			var d1 = [];
			for (var i = 0; i < Math.PI * 2; i += 0.5) {
				d1.push([i, Math.sin(i)]);
			}

			var d2 = [];
			for (var i = 0; i < Math.PI * 2; i += 0.5) {
				d2.push([i, Math.cos(i)]);
			}

			var d3 = [];
			for (var i = 0; i < Math.PI * 2; i += 0.2) {
				d3.push([i, Math.tan(i)]);
			}


			var sales_charts = $('#sales-charts').css({
				'width': '100%',
				'height': '220px'
			});
			$.plot("#sales-charts", [{
				label: "Domains",
				data: d1
			}, {
				label: "Hosting",
				data: d2
			}, {
				label: "Services",
				data: d3
			}], {
				hoverable: true,
				shadowSize: 0,
				series: {
					lines: {
						show: true
					},
					points: {
						show: true
					}
				},
				xaxis: {
					tickLength: 0
				},
				yaxis: {
					ticks: 10,
					min: -2,
					max: 2,
					tickDecimals: 3
				},
				grid: {
					backgroundColor: {
						colors: ["#fff", "#fff"]
					},
					borderWidth: 1,
					borderColor: '#555'
				}
			});


			$('#recent-box [data-rel="tooltip"]').tooltip({
				placement: tooltip_placement
			});

			function tooltip_placement(context, source) {
				var $source = $(source);
				var $parent = $source.closest('.tab-content')
				var off1 = $parent.offset();
				var w1 = $parent.width();

				var off2 = $source.offset();
				//var w2 = $source.width();

				if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2)) return 'right';
				return 'left';
			}


			$('.dialogs,.comments').ace_scroll({
				size: 300
			});


			//Android's default browser somehow is confused when tapping on label which will lead to dragging the task
			//so disable dragging when clicking on label
			var agent = navigator.userAgent.toLowerCase();
			if (ace.vars['touch'] && ace.vars['android']) {
				$('#tasks').on('touchstart', function(e) {
					var li = $(e.target).closest('#tasks li');
					if (li.length == 0) return;
					var label = li.find('label.inline').get(0);
					if (label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation();
				});
			}

			$('#tasks').sortable({
				opacity: 0.8,
				revert: true,
				forceHelperSize: true,
				placeholder: 'draggable-placeholder',
				forcePlaceholderSize: true,
				tolerance: 'pointer',
				stop: function(event, ui) {
					//just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
					$(ui.item).css('z-index', 'auto');
				}
			});
			$('#tasks').disableSelection();
			$('#tasks input:checkbox').removeAttr('checked').on('click', function() {
				if (this.checked) $(this).closest('li').addClass('selected');
				else $(this).closest('li').removeClass('selected');
			});


			//show the dropdowns on top or bottom depending on window height and menu position
			$('#task-tab .dropdown-hover').on('mouseenter', function(e) {
				var offset = $(this).offset();

				var $w = $(window)
				if (offset.top > $w.scrollTop() + $w.innerHeight() - 100)
					$(this).addClass('dropup');
				else $(this).removeClass('dropup');
			});

		})
	</script>
</body>

</html>
<?php  ?>
