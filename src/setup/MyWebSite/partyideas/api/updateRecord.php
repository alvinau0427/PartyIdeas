<?php

require_once ('../require/connection/conn.php');

if(isset($_POST)) {
    
    $validator = array('success' => false,
                    'messages' => array());

    $id = $_POST['record_id'];
    
    $affRows = 0;
    
    switch($_POST['current_table']) {
        case "admin":
            $sql = "UPDATE admin SET Name = '{$_POST['editName']}' , LoginAccount = '{$_POST['editLoginAccount']}' WHERE AdminID = '{$id}'";
            break;
        
        case "blacklist":
            $sql = "UPDATE blacklist SET Account = '{$_POST['editAccount']}' , Status = '{$_POST['editStatus']}' , 
            BlackListDate = '{$_POST['editBlackListDate']}', Admin = '{$_POST['editAdmin']}' WHERE BlacklistID = '{$id}'";
            break;
                    
        case "boardgame":
            $sql = "UPDATE boardgame SET BoardGameName = '{$_POST['editBoardGameName']}' , BoardGameDetail = '{$_POST['editBoardGameDetail']}' , BoardGameType = '{$_POST['editBoardGameType']}' , 
            Year = '{$_POST['editYear']}', Price = '{$_POST['editPrice']}', Quantity = '{$_POST['editQuantity']}' , Player_Minimum = '{$_POST['editPlayer_Minimum']}' , 
            Player_Maximum = '{$_POST['editPlayer_Maximum']}' , LimitationAge = '{$_POST['editLimitationAge']}' , Photo = '{$_POST['editPhoto']}' , Status = '{$_POST['editStatus']}' WHERE BoardGameID = '{$id}'";
            break;
                    
        case "boardgamebooking":
            $sql = "UPDATE boardgamebooking SET BoardGameID = '{$_POST['editBoardGameID']}' , Quantity = '{$_POST['editQuantity']}' , 
            TotalPrice = '{$_POST['editTotalPrice']}', MemberName = '{$_POST['editMemberName']}', Contact = '{$_POST['editContact']}' , OrderDate = '{$_POST['editOrderDate']}' , 
            OrderTime = '{$_POST['editOrderTime']}' , ReceiptDate = '{$_POST['editReceiptDate']}' , ReceiptTime = '{$_POST['editReceiptTime']}' , Status = '{$_POST['Status']}' WHERE BookingID = '{$id}'";
            break;
            
        case "boardgametype":
            $sql = "UPDATE boardgametype SET Type = '{$_POST['editType']}' WHERE ID = '{$id}'";
            break;
            
        case "gatheringbattle":
            $sql = "UPDATE gatheringbattle SET BoardGameID = '{$_POST['editBoardGameID']}' , MemberName = '{$_POST['editMemberName']}' , 
            Account = '{$_POST['editAccount']}', Contact = '{$_POST['editContact']}', Date = '{$_POST['editDate']}' , Time = '{$_POST['editTime']}' , 
            EndTime = '{$_POST['editEndTime']}' , Place = '{$_POST['editPlace']}' , ParticipantRequirement = '{$_POST['editParticipantRequirement']}' , Status = '{$_POST['editStatus']}' ,
            JoinedParticipant = '{$_POST['editJoinedParticipant']}' , JoinedParticipantToken = '{$_POST['editJoinedParticipantToken']}' WHERE EventID = '{$id}'";
            break;
        
        case "location":
            $sql = "UPDATE location SET Place = '{$_POST['editPlace']}' WHERE LocationID = '{$id}'";
            break;
                    
        case "notification":
            $sql = "UPDATE notification SET Title = '{$_POST['editTitle']}' , Body = '{$_POST['editBody']}' , 
            Uid = '{$_POST['editUid']}', Name = '{$_POST['editName']}' , Date = '{$_POST['editDate']}' WHERE NotificationID = '{$id}'";
            break;
            
        case "photo":
            $sql = "UPDATE photo SET PhotoName = '{$_POST['editPhotoName']}' , Status = '{$_POST['editStatus']}' WHERE ID = '{$id}'";
            break;
                    
        case "privatebooking":
            $sql = "UPDATE privatebooking SET MemberName = '{$_POST['editMemberName']}' , Account = '{$_POST['editAccount']}' , 
            Contact = '{$_POST['editContact']}', Date = '{$_POST['editDate']}', Time = '{$_POST['editTime']}' , EndTime = '{$_POST['editEndTime']}' , 
            Place = '{$_POST['editPlace']}' , NumberOfPeople = '{$_POST['editNumberOfPeople']}' , TotalPrice = '{$_POST['editTotalPrice']}' , Discount = '{$_POST['editDiscount']}' ,
            Remark = '{$_POST['editRemark']}' , Photo = '{$_POST['editPhoto']}' , Status = '{$_POST['editStatus']}' WHERE BookingID = '{$id}'";
            break;
                                
        case "users":
            $sql = "UPDATE users SET Token = '{$_POST['editToken']}', Account = '{$_POST['editAccount']}', ReceiveNotification = '{$_POST['ReceiveNotification']}' WHERE ID = '{$id}'";
            break;
        
        case "gatheringbattleprice":
            $sql = "UPDATE gatheringbattleprice SET Monday = '{$_POST['Monday']}', Tuesday = '{$_POST['Tuesday']}', Wednesday = '{$_POST['Wednesday']}', 
             Thursday = '{$_POST['Thursday']}', Friday = '{$_POST['Friday']}', Saturday = '{$_POST['Saturday']}', Sunday = '{$_POST['Sunday']}' WHERE PriceID = '{$id}'";
            break;
        
        case "privatebookingprice":
            $sql = "UPDATE privatebookingprice SET BasicPrice = '{$_POST['BasicPrice']}', BasicPeople = '{$_POST['BasicPeople']}', BasicHour = '{$_POST['BasicHour']}', 
             ExtraFoodPricePerPeople = '{$_POST['ExtraFoodPricePerPeople']}', ExtraPricePerHour = '{$_POST['ExtraPricePerHour']}', ExtraPricePerPeople = '{$_POST['ExtraPricePerPeople']}' WHERE PriceID = '{$id}'";
            break;
            
        case "message":
            $sql = "UPDATE message SET SuccessTitle = '{$_POST['GBSuccessTitle']}', CancelTitle = '{$_POST['GBCancelTitle']}', SuccessBody = '{$_POST['GBSuccessBody']}', 
             CancelBody = '{$_POST['GBCancelBody']}' WHERE ID = '1';";
             
            $sql .= "UPDATE message SET SuccessTitle = '{$_POST['PBSuccessTitle']}', CancelTitle = '{$_POST['PBCancelTitle']}', SuccessBody = '{$_POST['PBSuccessBody']}', 
             CancelBody = '{$_POST['PBCancelBody']}' WHERE ID = '2'";
            break;
        
        case "indexsetting":
            $sql = "UPDATE indexsetting SET ShowItem = '{$_POST['BGShowItem']}' WHERE ID = '1';";
            
            $sql .= "UPDATE indexsetting SET ShowItem = '{$_POST['GBShowItem']}' WHERE ID = '2'";
            break;
        
        default:
            die();
    }

    mysqli_multi_query($conn,$sql);
    
    do{
        $affRows += mysqli_affected_rows($conn);
    } while(mysqli_more_results($conn) && mysqli_next_result($conn));
    
    if($affRows >= 1) {
        
        $validator['success'] = true;
        $validator['messages'] = "成功修改紀錄!";

    } else {
        
        $validator['success'] = false;
        $validator['messages'] = "Error!";

    }
    
    echo json_encode($validator);
}

mysqli_close($conn);

?>