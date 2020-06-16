<?php

require_once ('../require/connection/conn.php');

$output['data'] = array();

$status = $_POST['status_id'];

$actionButton = null;

switch($_POST['current_table']) {
    
    case "gatheringbattle":
        $sql = "SELECT gb.EventID, bg.BoardGameName, gb.MemberName, gb.Contact, gb.Date, gb.Time, gb.EndTime, l.Place, gb.ParticipantRequirement  
                FROM gatheringbattle as gb, boardgame as bg, location as l 
                WHERE gb.BoardGameID = bg.BoardGameID and gb.place = l.LocationID and gb.Status = $status ORDER BY gb.EventID";
        
        $rs = mysqli_query($conn, $sql);
        while($rc = mysqli_fetch_assoc($rs)){
			if($status == "1") {
				$actionButton = '<div class="btn-group">
									<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#successEventModal" onclick="updateEvent('.$rc['EventID'].')">
										<i class="ace-icon fa fa-check bigger-110"></i><span>完成</span>
									</button>
			
									<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#cancelEventModal" onclick="updateEvent('.$rc['EventID'].')" >
										<i class="ace-icon fa fa-times bigger-110"></i><span>取消</span>
									</button>
								</div>';
			}
        					
            $memberButton = '<div class="btn-group">
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#memberModal" onclick="loadMember('.$rc['EventID'].')">
            						<span>所有成員</span>
            					</button>
        					</div>';
        					
            $output['data'][] = array(
                                $rc['EventID'],
                                $rc['BoardGameName'],
                                $rc['MemberName'],
                                $rc['Contact'],
                                $rc['Date'],
                                $rc['Time'],
                                $rc['EndTime'],
                                $rc['Place'],
                                $rc['ParticipantRequirement'],
                                $memberButton,
                                $actionButton
                            );
        }
        break;
        
    case "privatebooking":
        $sql = "SELECT pb.BookingID, pb.MemberName, pb.Contact, pb.Date, pb.Time, pb.EndTime, l.Place, pb.NumberOfPeople, pb.TotalPrice, pb.Account 
                FROM privatebooking as pb, location as l WHERE pb.Place = l.LocationID and pb.Status = $status ORDER BY pb.BookingID";
        
        $rs = mysqli_query($conn, $sql);
        while($rc = mysqli_fetch_assoc($rs)){
			if($status == "1") {
				$actionButton = '<div class="btn-group">
									<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#successEventModal" onclick="updateEvent('.$rc['BookingID'].')">
										<i class="ace-icon fa fa-check bigger-110"></i><span>完成</span>
									</button>
				
									<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#cancelEventModal" onclick="updateEvent('.$rc['BookingID'].')" >
										<i class="ace-icon fa fa-times bigger-110"></i><span>取消</span>
									</button>
								</div>';
			}
				
            $memberButton = '<div class="btn-group">
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#memberModal" onclick="loadMember('.$rc['BookingID'].')">
            						<span>所有成員</span>
            					</button>
        					</div>';
        					
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
                                $memberButton,
                                $actionButton
                            );
        }
        break;
        
    case "boardgamebooking":
        $sql = "SELECT bgb.BookingID, bg.BoardGameName, bgb.Quantity, bgb.TotalPrice, bgb.MemberName, bgb.Contact, bgb.OrderDate, bgb.OrderTime 
                FROM boardgamebooking as bgb, boardgame as bg WHERE bgb.BoardGameID = bg.BoardGameID and bgb.Status = $status ORDER BY bgb.BookingID";
                
        $rs = mysqli_query($conn, $sql);
        while($rc = mysqli_fetch_assoc($rs)){
			if($status == "1") {
				$actionButton = '<div class="btn-group">
									<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#successEventModal" onclick="updateEvent('.$rc['BookingID'].')">
										<i class="ace-icon fa fa-check bigger-110"></i><span>完成</span>
									</button>
				
									<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#cancelEventModal" onclick="updateEvent('.$rc['BookingID'].')" >
										<i class="ace-icon fa fa-times bigger-110"></i><span>取消</span>
									</button>
								</div>';
			}
        					
            $output['data'][] = array(
                                $rc['BookingID'],
                                $rc['BoardGameName'],
                                $rc['MemberName'],
                                $rc['Contact'],
                                $rc['OrderDate'],
                                $rc['OrderTime'],
                                $rc['Quantity'],
                                $rc['TotalPrice'],
                                $actionButton
                            );
        }
        break;
        
    default:
            die();
}

echo json_encode($output);

mysqli_close($conn);

?>