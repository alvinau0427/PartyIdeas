<?php 
	
    session_start(); // session_start();
    require_once('connection/conn.php');
	require_once('fb_detail.php');
	$permissions = ['email']; // optional
	$loginUrl = $helper->getLoginUrl('http://localhost/MyWebSite/partyideas/login-callback.php', $permissions);//取得權限後要跳轉的頁面
	
	if(isset($_SESSION['fb_access_token'])){
		try {
		  // Returns a `Facebook\FacebookResponse` object
		  $response = $fb->get('/me?fields=id,name,email', $_SESSION['fb_access_token']);
	          //取得登入者的 id,name,email(若fb使用者本身的mail未認證即取不到此值，即便有取得該使用者的mail權限)
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}
		
		$user = $response->getGraphUser();
		//header('Location: main.php');
		require_once('isAdmin.php');
		
		if($_SESSION['isAdmin'] == 0 )
			header('Location: error-200.html');
	} else
		header('Location: login.php');
		
	
		

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php require_once('head.php'); ?>
</head>

<body class="no-skin">

	<?php require_once('header.php'); ?>

	<div class="main-container ace-save-state" id="main-container">
		<script type="text/javascript">
			try {
				ace.settings.loadState('main-container')
			}
			catch (e) {}
		</script>


		<?php require_once('nav.php'); ?>
		<!-- /.nav-list -->

					<!-- /.breadcrumb -->

					<!--<div class="nav-search" id="nav-search">-->
					<!--	<form class="form-search">-->
					<!--		<span class="input-icon">-->
					<!--				<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />-->
					<!--				<i class="ace-icon fa fa-search nav-search-icon"></i>-->
					<!--			</span>-->
					<!--	</form>-->
					<!--</div>-->
					<!-- /.nav-search -->
					
					<?php //去到 <div class="page-header"> ?>

