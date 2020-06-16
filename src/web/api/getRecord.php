<?php

require_once ('../require/connection/conn.php');

$output['data'] = array();

switch($_POST['current_table']) {
    
    case "admin":
        $sql = "SELECT * FROM admin";
        $rs = mysqli_query($conn, $sql);
        
        if(mysqli_num_rows($rs) == 1){
            $rc = mysqli_fetch_assoc($rs);
            $actionButton = '<div class="btn-group">
            						<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editRecordModal" onclick="editRecord('.$rc[ 'AdminID'].')">
            							<i class="ace-icon fa fa-pencil bigger-120"></i>
            						</button>
            
            						<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#removeRecordModal" disabled="disabled" onclick="removeRecord('.$rc[ 'AdminID'].')" >
            							<i class="ace-icon fa fa-trash-o bigger-120"></i>
            						</button>
            					</div>';
                
            $output['data'][] = array(
                                $rc[ 'AdminID'],
                                $rc[ 'Name'],
                                $rc[ 'LoginAccount'],
                                $actionButton
                            );
                                
        } else {
            
            while($rc = mysqli_fetch_assoc($rs)){
                $actionButton = '<div class="btn-group">
            						<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editRecordModal" onclick="editRecord('.$rc[ 'AdminID'].')">
            							<i class="ace-icon fa fa-pencil bigger-120"></i>
            						</button>
            
            						<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#removeRecordModal" onclick="removeRecord('.$rc[ 'AdminID'].')" >
            							<i class="ace-icon fa fa-trash-o bigger-120"></i>
            						</button>
            					</div>';
                
                $output['data'][] = array(
                                    $rc[ 'AdminID'],
                                    $rc[ 'Name'],
                                    $rc[ 'LoginAccount'],
                                    $actionButton
                                );
            }
        }
        break;
    
    case "blacklist":
        $sql = "SELECT b.BlacklistID, b.Account, b.Status, b.BlackListDate, a.Name FROM blacklist as b, admin as a WHERE b.Admin = a.AdminID";
        $rs = mysqli_query($conn, $sql);
        while($rc = mysqli_fetch_assoc($rs)) {
            $actionButton = '<div class="btn-group">
            					<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editRecordModal" onclick="editRecord('.$rc[ 'BlacklistID'].')">
            						<i class="ace-icon fa fa-pencil bigger-120"></i>
            					</button>
            
            					<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#removeRecordModal" onclick="removeRecord('.$rc[ 'BlacklistID'].')" >
            						<i class="ace-icon fa fa-trash-o bigger-120"></i>
            					</button>
            				</div>';
            
            switch($rc[ 'Status']) {
                case '0':
                    $status = '<span class="label label-warning">黃牌 (警告)</span>';
                    break; 
                
                case '1':
                    $status = '<span class="label label-danger">紅牌 (封鎖)</span>';
                    break; 
                    
            }
            
            $output['data'][] = array(
                                $rc[ 'BlacklistID'],
                                $rc[ 'Account'],
                                $status,
                                $rc[ 'BlackListDate'],
                                $rc[ 'Name'],
                                $actionButton
                            );
        }
        break;
                    
    case "boardgame":
        $sql = "SELECT bg.BoardGameID, bg.BoardGameName, bg.BoardGameDetail, bgt.Type, bg.Year, bg.Price, bg.Quantity, bg.Player_Minimum, bg.Player_Maximum, 
				bg.LimitationAge, bg.Photo, bg.Status FROM boardgame as bg, boardgametype as bgt WHERE bg.BoardGameType = bgt.ID;";
        $rs = mysqli_query($conn, $sql);
        while($rc = mysqli_fetch_assoc($rs)) {
            $actionButton = '<div class="btn-group">
            					<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editRecordModal" onclick="editRecord('.$rc[ 'BoardGameID'].')">
            						<i class="ace-icon fa fa-pencil bigger-120"></i>
            					</button>
            
            					<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#removeRecordModal" onclick="removeRecord('.$rc[ 'BoardGameID'].')" >
            						<i class="ace-icon fa fa-trash-o bigger-120"></i>
            					</button>
            				</div>';

            switch($rc[ 'Status']) {
                case '0':
                    $status = '<span class="label label-success">售賣</span>';
                    break; 
                
                case '1':
                    $status = '<span class="label label-danger">已售罄</span>';
                    break; 
                    
            }

            $output['data'][] = array(
                                $rc[ 'BoardGameID'],
                                $rc[ 'BoardGameName'],
                                $rc[ 'BoardGameDetail'],
                                $rc[ 'Type'],
                                $rc[ 'Year'],
                                $rc[ 'Price'],
                                $rc[ 'Quantity'],
                                $rc[ 'Player_Minimum'],
                                $rc[ 'Player_Maximum'],
                                $rc[ 'LimitationAge'],
                                $rc[ 'Photo'],
                                $status,
                                $actionButton
                            );
        }
        break;
                
    case "boardgamebooking":
        $sql = "SELECT * FROM boardgamebooking";
        $rs = mysqli_query($conn, $sql);
        while($rc = mysqli_fetch_assoc($rs)) {
            $actionButton = '<div class="btn-group">
            					<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editRecordModal" onclick="editRecord('.$rc[ 'BookingID'].')">
            						<i class="ace-icon fa fa-pencil bigger-120"></i>
            					</button>
            
            					<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#removeRecordModal" onclick="removeRecord('.$rc[ 'BookingID'].')" >
            						<i class="ace-icon fa fa-trash-o bigger-120"></i>
            					</button>
            				</div>';
            
            switch($rc[ 'Status']) {
                case '0':
                    $status = '<span class="label label-default">等待審批</span>';
                    break; 
                
                case '1':
                    $status = '<span class="label label-info">已接受</span>';
                    break; 
                    
                case '2':
                    $status = '<span class="label label-warning">已拒絕</span>';
                    break; 
                    
                case '3':
                    $status = '<span class="label label-success">已完成</span>';
                    break; 
                
                case '4':
                    $status = '<span class="label label-danger">已取消</span>';
                    break; 
            }
            
            $output['data'][] = array(
                                $rc[ 'BookingID'],
                                $rc[ 'BoardGameID'],
                                $rc[ 'Quantity'],
                                $rc[ 'TotalPrice'],
                                $rc[ 'MemberName'],
                                $rc[ 'Contact'],
                                $rc[ 'OrderDate'],
                                $rc[ 'OrderTime'],
                                $rc[ 'ReceiptDate'],
                                $rc[ 'ReceiptTime'],
                                $status,
                                $actionButton
                            );
        }
        break;
        
    case "boardgametype":
        $sql = "SELECT * FROM boardgametype";
        $rs = mysqli_query($conn, $sql);
        while($rc = mysqli_fetch_assoc($rs)) {
            $actionButton = '<div class="btn-group">
            					<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editRecordModal" onclick="editRecord('.$rc[ 'ID'].')">
            						<i class="ace-icon fa fa-pencil bigger-120"></i>
            					</button>
            
            					<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#removeRecordModal" onclick="removeRecord('.$rc[ 'ID'].')" >
            						<i class="ace-icon fa fa-trash-o bigger-120"></i>
            					</button>
            				</div>';

            $output['data'][] = array(
                                $rc[ 'ID'],
                                $rc[ 'Type'],
                                $actionButton
                            );
        }
        break;
                
    case "gatheringbattle":
        $sql = "SELECT * FROM gatheringbattle";
        $rs = mysqli_query($conn, $sql);
        while($rc = mysqli_fetch_assoc($rs)) {
            $actionButton = '<div class="btn-group">
            					<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editRecordModal" onclick="editRecord('.$rc[ 'EventID'].')">
            						<i class="ace-icon fa fa-pencil bigger-120"></i>
            					</button>
            
            					<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#removeRecordModal" onclick="removeRecord('.$rc[ 'EventID'].')" >
            						<i class="ace-icon fa fa-trash-o bigger-120"></i>
            					</button>
            				</div>';
            
            switch($rc[ 'Status']) {
                
                case '-1':
                    $status = '<span class="label label-primary">人數未滿</span>';
                    break; 
                
                case '0':
                    $status = '<span class="label label-default">等待審批</span>';
                    break; 
                
                case '1':
                    $status = '<span class="label label-info">已接受</span>';
                    break; 
                    
                case '2':
                    $status = '<span class="label label-warning">已拒絕</span>';
                    break; 
                    
                case '3':
                    $status = '<span class="label label-success">已完成</span>';
                    break; 
                
                case '4':
                    $status = '<span class="label label-danger">已取消</span>';
                    break; 
            }
            
            $output['data'][] = array(
                                $rc[ 'EventID'],
                                $rc[ 'BoardGameID'],
                                $rc[ 'MemberName'],
                                $rc[ 'Account'],
                                $rc[ 'Contact'],
                                $rc[ 'Date'],
                                $rc[ 'Time'],
                                $rc[ 'EndTime'],
                                $rc[ 'Place'],
                                $rc[ 'ParticipantRequirement'],
                                $status,
                                $rc[ 'JoinedParticipant'],
                                $rc[ 'JoinedParticipantToken'],
                                $actionButton
                            );
        }
        break;

    case "location":
        $sql = "SELECT * FROM location";
        $rs = mysqli_query($conn, $sql);
        while($rc = mysqli_fetch_assoc($rs)) {
            $actionButton = '<div class="btn-group">
            					<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editRecordModal" onclick="editRecord('.$rc[ 'LocationID'].')">
            						<i class="ace-icon fa fa-pencil bigger-120"></i>
            					</button>
            
            					<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#removeRecordModal" onclick="removeRecord('.$rc[ 'LocationID'].')" >
            						<i class="ace-icon fa fa-trash-o bigger-120"></i>
            					</button>
            				</div>';

            $output['data'][] = array(
                                $rc[ 'LocationID'],
                                $rc[ 'Place'],
                                $actionButton
                            );
        }
        break;
                
    case "notification":
        $sql = "SELECT * FROM notification";
        $rs = mysqli_query($conn, $sql);
        while($rc = mysqli_fetch_assoc($rs)) {
            $actionButton = '<div class="btn-group">
            					<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editRecordModal" onclick="editRecord('.$rc[ 'NotificationID'].')">
            						<i class="ace-icon fa fa-pencil bigger-120"></i>
            					</button>
            
            					<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#removeRecordModal" onclick="removeRecord('.$rc[ 'NotificationID'].')" >
            						<i class="ace-icon fa fa-trash-o bigger-120"></i>
            					</button>
            				</div>';

            $output['data'][] = array(
                                $rc[ 'NotificationID'],
                                $rc[ 'Title'],
                                $rc[ 'Body'],
                                $rc[ 'Uid'],
                                $rc[ 'Name'],
                                $rc[ 'Date'],
                                $actionButton
                            );
        }
        break;
        
    case "photo":
        $sql = "SELECT * FROM photo";
        $rs = mysqli_query($conn, $sql);
        while($rc = mysqli_fetch_assoc($rs)) {
            $actionButton = '<div class="btn-group">
            					<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editRecordModal" onclick="editRecord('.$rc[ 'ID'].')">
            						<i class="ace-icon fa fa-pencil bigger-120"></i>
            					</button>
            
            					<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#removeRecordModal" onclick="removeRecord('.$rc[ 'ID'].')" >
            						<i class="ace-icon fa fa-trash-o bigger-120"></i>
            					</button>
            				</div>';
            				
            $img = '<img src="Photo/'.$rc['PhotoName'].'" class="img-rounded" style="height:40px">';
            
            switch($rc[ 'Status']) {
                case '0':
                    $status = '<span class="label label-default">不顯示</span>';
                    break; 
                
                case '1':
                    $status = '<span class="label label-success">首頁顯示</span>';
                    break; 
                    
                case '2':
                    $status = '<span class="label label-info">包場價錢</span>';
                    break; 
            }

            $output['data'][] = array(
                                $rc[ 'ID'],
                                $rc['PhotoName'],
                                $img,
                                $status,
                                $actionButton
                            );
        }
        break;
                
    case "privatebooking":
        $sql = "SELECT * FROM privatebooking";
        $rs = mysqli_query($conn, $sql);
        while($rc = mysqli_fetch_assoc($rs)) {
            $actionButton = '<div class="btn-group">
            					<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editRecordModal" onclick="editRecord('.$rc[ 'BookingID'].')">
            						<i class="ace-icon fa fa-pencil bigger-120"></i>
            					</button>
            
            					<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#removeRecordModal" onclick="removeRecord('.$rc[ 'BookingID'].')" >
            						<i class="ace-icon fa fa-trash-o bigger-120"></i>
            					</button>
            				</div>';
            
            switch($rc[ 'Status']) {
                
                case '0':
                    $status = '<span class="label label-default">等待審批</span>';
                    break; 
                
                case '1':
                    $status = '<span class="label label-info">已接受</span>';
                    break; 
                    
                case '2':
                    $status = '<span class="label label-warning">已拒絕</span>';
                    break; 
                    
                case '3':
                    $status = '<span class="label label-success">已完成</span>';
                    break; 
                
                case '4':
                    $status = '<span class="label label-danger">已取消</span>';
                    break; 
            }
            
            $output['data'][] = array(
                                $rc[ 'BookingID'],
                                $rc[ 'MemberName'],
                                $rc[ 'Account'],
                                $rc[ 'Contact'],
                                $rc[ 'Date'],
                                $rc[ 'Time'],
                                $rc[ 'EndTime'],
                                $rc[ 'Place'],
                                $rc[ 'NumberOfPeople'],
                                $rc[ 'TotalPrice'],
                                $rc[ 'Discount'],
                                $rc[ 'Remark'],
                                $rc[ 'Photo'],
                                $status,
                                $actionButton
                            );
        }
        break;
                            
    case "users":
        $sql = "SELECT * FROM users";
        $rs = mysqli_query($conn, $sql);
        while($rc = mysqli_fetch_assoc($rs)) {
            $actionButton = '<div class="btn-group">
            					<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#editRecordModal" onclick="editRecord('.$rc[ 'ID'].')">
            						<i class="ace-icon fa fa-pencil bigger-120"></i>
            					</button>
            
            					<button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#removeRecordModal" onclick="removeRecord('.$rc[ 'ID'].')" >
            						<i class="ace-icon fa fa-trash-o bigger-120"></i>
            					</button>
            				</div>';
            
            switch($rc[ 'ReceiveNotification']) {
                
                case '0':
                    $receiveNotification = '<span class="label label-success">接受訊息</span>';
                    break; 
                
                case '1':
                    $receiveNotification = '<span class="label label-danger">不接受訊息</span>';
                    break; 
            }
            
            $output['data'][] = array(
                                $rc[ 'ID'],
                                $rc[ 'Token'],
                                $rc[ 'Account'],
                                $receiveNotification,
                                $actionButton
                            );
        }
        break;
        
    case "gatheringbattleprice":
        $sql = "SELECT * FROM gatheringbattleprice";
        $rs = mysqli_query($conn, $sql);
        $rc = mysqli_fetch_assoc($rs);
        
        $output = $rc;
        break;
            
    case "privatebookingprice":
        $sql = "SELECT * FROM privatebookingprice";
        $rs = mysqli_query($conn, $sql);
        $rc = mysqli_fetch_assoc($rs);
        
        $output = $rc;
        break;
        
    case "message":
        $sql = "SELECT * FROM message ORDER BY ID";
        $rs = mysqli_query($conn, $sql);
        
        while($rc = mysqli_fetch_assoc($rs)) {
            $output["{$rc['ID']}"] = $rc;
        }
        break;
        
    case "indexsetting":
        $sql = "SELECT * FROM indexsetting ORDER BY ID";
        $rs = mysqli_query($conn, $sql);
        
        while($rc = mysqli_fetch_assoc($rs)) {
            $output["{$rc['ID']}"] = $rc;
        }
        break;
    
    default:
        die();

}


echo json_encode($output);

mysqli_close($conn);

?>