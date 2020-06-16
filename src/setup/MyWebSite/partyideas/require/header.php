<div id="navbar" class="navbar navbar-default ace-save-state">
	<div class="navbar-container ace-save-state" id="navbar-container">
		<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
			<span class="sr-only">Toggle sidebar</span>

			<span class="icon-bar"></span>

			<span class="icon-bar"></span>

			<span class="icon-bar"></span>
		</button>

		<div class="navbar-header pull-left">
			<a href="index.php" class="navbar-brand">
				<small>
					<!--<i class="fa fa-leaf"></i>-->
					Party Ideas CMS
				</small>
			</a>
		</div>

		<div class="navbar-buttons navbar-header pull-right" role="navigation">
			<ul class="nav ace-nav">
				<li class="light-blue dropdown-modal">
					<a data-toggle="dropdown" href="#" class="dropdown-toggle">
						<?php if(isset($_SESSION['fb_access_token'])){ ?>
							
							<img class="nav-user-photo" src='https://graph.facebook.com/<?= $user['id'] ?>/picture'>
							<span class="user-info"><small>Welcome,</small> <?= $user['name'] ?> </span>
						
						<?php } ?>

						<i class="ace-icon fa fa-caret-down"></i>
					</a>

					<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
						
						<li class="divider"></li>

						<li>
							<a href="fb_logout.php">
								<i class="ace-icon fa fa-power-off"></i> Logout
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!-- /.navbar-container -->
</div>
