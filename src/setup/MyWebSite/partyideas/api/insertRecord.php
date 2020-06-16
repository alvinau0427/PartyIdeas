<?php

require_once ('../require/connection/conn.php');

if(isset($_POST)) {
    
    $validator = array('success' => false,
                        'messages' => array());
    
    switch($_POST['current_table']) {
        case "admin":
            $sql = "INSERT INTO admin(Name, LoginAccount) VALUES('{$_POST['Name']}' , '{$_POST['LoginAccount']}' )";
            break;
        
        case "blacklist":
            $sql = "INSERT INTO blacklist(Account, Status, BlackListDate, Admin) 
            VALUES('{$_POST['Account']}', '{$_POST['Status']}', '{$_POST['BlackListDate']}', '{$_POST['Admin']}')";
            break;
                    
        case "boardgame":
            $sql = "INSERT INTO boardgame(BoardGameName, BoardGameDetail, BoardGameType, Year, Price, Quantity, Player_Minimum, Player_Maximum, LimitationAge, Photo, Status) 
            VALUES('{$_POST['BoardGameName']}', '{$_POST['BoardGameDetail']}', '{$_POST['BoardGameType']}', '{$_POST['Year']}', '{$_POST['Price']}', '{$_POST['Quantity']}', '{$_POST['Player_Minimum']}', '{$_POST['Player_Maximum']}', '{$_POST['LimitationAge']}', '{$_POST['Photo']}', '{$_POST['Status']}')";
            break;
                    
        case "boardgamebooking":
            $sql = "INSERT INTO boardgamebooking(BoardGameID, Quantity, TotalPrice, MemberName, Contact, OrderDate, OrderTime, ReceiptDate, ReceiptTime, Status) 
            VALUES('{$_POST['BoardGameID']}', '{$_POST['Quantity']}', '{$_POST['TotalPrice']}', '{$_POST['MemberName']}', '{$_POST['Contact']}', '{$_POST['OrderDate']}', '{$_POST['OrderTime']}', '{$_POST['ReceiptDate']}', '{$_POST['ReceiptTime']}', '{$_POST['Status']}')";
            break;
                    
        case "boardgametype":
            $sql = "INSERT INTO boardgametype(Type) VALUES('{$_POST['Type']}')";
            break;
                    
        case "gatheringbattle":
            $sql = "INSERT INTO gatheringbattle(BoardGameID, MemberName, Account, Contact, Date, Time, EndTime, Place, ParticipantRequirement, Status, JoinedParticipant, JoinedParticipantToken) 
            VALUES('{$_POST['BoardGameID']}', '{$_POST['MemberName']}', '{$_POST['AccountToken']}', '{$_POST['Contact']}', '{$_POST['Date']}', '{$_POST['Time']}', '{$_POST['EndTime']}', '{$_POST['Place']}', '{$_POST['ParticipantRequirement']}', '{$_POST['Status']}', '{$_POST['JoinedParticipant']}', '{$_POST['JoinedParticipantToken']}')";
            break;
        
        case "location":
            $sql = "INSERT INTO location(Place) VALUES('{$_POST['Place']}')";
            break;
                    
        case "notification":
            $sql = "INSERT INTO notification(Title, Body, Uid, Name, Date) 
            VALUES('{$_POST['Title']}', '{$_POST['Body']}', '{$_POST['Uid']}', '{$_POST['Name']}', '{$_POST['Date']}')";
            break;
            
        case "photo":
            $sql = "INSERT INTO photo(PhotoName, Status) VALUES('{$_POST['PhotoName']}', '{$_POST['Status']}')";
            break;
                    
        case "privatebooking":
            $sql = "INSERT INTO privatebooking(MemberName, Account, Contact, Date, Time, EndTime, Place, NumberOfPeople, TotalPrice, Discount, Remark, Photo, Status) 
            VALUES('{$_POST['MemberName']}', '{$_POST['Account']}', '{$_POST['Contact']}', '{$_POST['Date']}', '{$_POST['Time']}', '{$_POST['EndTime']}', '{$_POST['Place']}', '{$_POST['NumberOfPeople']}', '{$_POST['TotalPrice']}', '{$_POST['Discount']}', '{$_POST['Remark']}', '{$_POST['Photo']}', '{$_POST['Status']}')";
            break;
                                
        case "users":
            $sql = "INSERT INTO users(Token, Account, ReceiveNotification) VALUES('{$_POST['Token']}', '{$_POST['Account']}', '{$_POST['ReceiveNotification']}')";
            break;
        
        default:
            die();
    }
    
    
    
    mysqli_query($conn,$sql);
    if(mysqli_affected_rows($conn) >= 1) {
        
        $validator['success'] = true;
        $validator['messages'] = "成功新增紀錄!";

    } else {
        
        $validator['success'] = false;
        $validator['messages'] = "Error!";

    }
    
    echo json_encode($validator);
}

mysqli_close($conn);

?>