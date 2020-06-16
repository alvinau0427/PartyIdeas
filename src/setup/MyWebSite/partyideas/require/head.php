<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta charset="utf-8" />
<title>Party Ideas - CMS</title>

<meta name="description" content="overview &amp; stats" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

<!-- bootstrap & fontawesome important-->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

<!-- page dropzone styles -->
<link rel="stylesheet" href="assets/css/dropzone.min.css" />

<!-- page specific plugin styles -->
<!--<link rel="stylesheet" href="assets/css/jquery-ui.min.css" />-->
<!--<link rel="stylesheet" href="assets/css/bootstrap-datepicker3.min.css" />-->
<!--<link rel="stylesheet" href="assets/css/ui.jqgrid.min.css" />-->

<!-- text fonts -->
<!--<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />-->

<!-- ace styles important-->
<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
<!--<link rel="stylesheet" href="assets/css/ace-skins.min.css" />-->
<!--<link rel="stylesheet" href="assets/css/ace-rtl.min.css" />-->

<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

<!-- inline styles related to this page -->

<!-- ace settings handler -->
<!--<script src="assets/js/ace-extra.min.js"></script>-->

<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
		
<?php if(basename($_SERVER['PHP_SELF']) == "event.php") {
	switch($_GET['table']) {
		
		case "gatheringbattle":
			echo '<style>
					.table-header{
						background-color:#404040;
					}
					#dynamic-table_wrapper > .row{
						background-color:#909090;
						color:white;
					}
				</style>';
			break;
			
		case "privatebooking":
			echo '<style>
					.table-header{
						background-color:#ffb752;
					}
					#dynamic-table_wrapper > .row{
						background-color:#ffefd9
					}
				</style>';
			break;
	}
		
} ?>

<style>
	.w-box:hover{
		box-shadow: 0px 0px 30px rgba(0,0,0, .2);
	}
	
	.boardGame-img{
		height: 150px;
	}
	
	.w-box{
		width: 380px;
		-moz-transition: all .3s ease;
		-o-transition:  all .3s ease;
		-webkit-transition:  all .3s ease;
	}
	
	.p-box{
		width: 380px;
		margin:0px 15px 15px 15px;
	}
	
	.bookingID{
		float:left;
		padding:0 10px 0 0px;
	}
	
	.hideOverflow{
	    overflow:hidden;
	    white-space:nowrap;
	    text-overflow:ellipsis;
	    display:block;
	}
	
	.glyphicon-refresh-animate {
	    -animation: spin .7s infinite linear;
	    -ms-animation: spin .7s infinite linear;
	    -webkit-animation: spinw .7s infinite linear;
	    -moz-animation: spinm .7s infinite linear;
	}
	
	@keyframes spin {
	    from { transform: scale(1) rotate(0deg);}
	    to { transform: scale(1) rotate(360deg);}
	}
	  
	@-webkit-keyframes spinw {
	    from { -webkit-transform: rotate(0deg);}
	    to { -webkit-transform: rotate(360deg);}
	}
	
	@-moz-keyframes spinm {
	    from { -moz-transform: rotate(0deg);}
	    to { -moz-transform: rotate(360deg);}
}

.center {
    margin: auto;
    width: 60%;
    border: 3px solid #73AD21;
    padding: 10px;
    
}

#message{
	text-align: left;
}

.space {
	padding: 30px;
}

</style>