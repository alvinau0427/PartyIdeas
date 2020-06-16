<?php

require_once ('../require/connection/conn.php');
$output = "";
$sql = "SELECT * FROM (SELECT * FROM notification order by NotificationID desc LIMIT 5) AS a ORDER BY a.NotificationID ASC";
$rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));


if(mysqli_num_rows($rs) >= 1) {
    
    //date_default_timezone_set("Asia/Hong_Kong");
                
    while($rc = mysqli_fetch_assoc($rs)){
?>
        <div class='itemdiv dialogdiv'>
        	<div class='user'>
        		<img alt="<?= $rc['Name'] ?>'s Avatar" src='https://graph.facebook.com/<?= $rc['Uid'] ?>/picture' />
        	</div>
        
        	<div class='body'>
        		<div class='time'>
        			<i class='ace-icon fa fa-clock-o'></i>
        			<span class='green'><?= $rc['Date'] ?></span>
        		</div>
        
        		<div class='name'>
        			<a href='#'><?= $rc['Name'] ?></a>
        			<span class="label label-info arrowed arrowed-in-right">admin</span>
        		</div>
        		<div class='text'><?= $rc['Title'] . ' - ' . $rc['Body']; ?></div>
        
        		<!--<div class='tools'>-->
        		<!--	<a href='#' class='btn btn-minier btn-info'>-->
        		<!--		<i class='icon-only ace-icon fa fa-share'></i>-->
        		<!--	</a>-->
        		<!--</div>-->
        	</div>
        </div>
        
<?php }

} else {
    echo '<h2> No record </h2>';
}
?>
    
