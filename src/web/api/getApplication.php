<?php

require_once ('../require/connection/conn.php');

$output['data'] = array();

switch($_POST['current_table']) {
    
    case "gatheringbattle":
        $sql = "SELECT gb.EventID, bg.BoardGameName, bg.photo, gb.MemberName, gb.Contact, gb.Date, gb.Time, gb.EndTime, l.Place, gb.ParticipantRequirement, gb.JoinedParticipant, gb.JoinedParticipantToken  
                FROM gatheringbattle as gb, boardgame as bg, location as l 
                WHERE gb.BoardGameID = bg.BoardGameID and gb.place = l.LocationID and gb.Status = 0 ORDER BY gb.EventID";
                
        $rs = mysqli_query($conn, $sql);
        while($rc = mysqli_fetch_assoc($rs)){
            $output['data'][] = array(
                                $rc['EventID'],
                                $rc['BoardGameName'],
                                $rc['photo'],
                                $rc['MemberName'],
                                $rc['Contact'],
                                $rc['Date'],
                                $rc['Time'],
                                $rc['EndTime'],
                                $rc['Place'],
                                $rc['ParticipantRequirement'],
                                $rc['JoinedParticipant'],
                                $rc['JoinedParticipantToken']
                            );
        }
        break;
    
    case "privatebooking":
        $sql = "SELECT pb.BookingID, pb.MemberName, pb.Contact, pb.Date, pb.Time, pb.EndTime, l.Place, pb.NumberOfPeople, pb.TotalPrice, pb.Remark, pb.Account 
                FROM privatebooking as pb, location as l WHERE pb.Place = l.LocationID and pb.Status = 0 ORDER BY pb.BookingID";
        
        $rs = mysqli_query($conn, $sql);
        while($rc = mysqli_fetch_assoc($rs)){
            $output['data'][] = array(
                                $rc['BookingID'],
                                $rc['MemberName'],
                                $rc['Contact'],
                                $rc['Date'],
                                $rc['Time'],
                                $rc['EndTime'],
                                $rc['Place'],
                                $rc['NumberOfPeople'],
                                $rc['TotalPrice'],
                                $rc['Remark'],
                                $rc['Account']
                            );
        }
        break;
    
    case "boardgamebooking":
        $sql = "SELECT bg.BoardGameName, bg.Price, bg.Photo, bgb.BookingID, bgb.Quantity, bgb.TotalPrice, bgb.MemberName, bgb.Contact, bgb.OrderDate, bgb.OrderTime 
                FROM boardgamebooking as bgb, boardgame as bg WHERE bgb.BoardGameID = bg.BoardGameID and bgb.Status = 0 ORDER BY bgb.BookingID";
                
        $rs = mysqli_query($conn, $sql);
        while($rc = mysqli_fetch_assoc($rs)){
            $output['data'][] = array(
                                $rc['BookingID'],
                                $rc['BoardGameName'],
                                $rc['Photo'],
                                $rc['MemberName'],
                                $rc['Contact'],
                                $rc['Price'],
                                $rc['Quantity'],
                                $rc['OrderDate'],
                                $rc['OrderTime'],
                                $rc['TotalPrice']
                            );
        }
        break;
        
    default:
        die();
}

echo json_encode($output);

mysqli_close($conn);
?>