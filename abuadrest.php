<?php
    require_once 'connection.php';
    $opr = urldecode($_POST['opr']);
    // $opr = "loadCompanyApplication";
    $err=null;
	$two = $one = array();
    if ($opr == "login"){
        $userID = urldecode($_POST['userID']);
        $userPassword = urldecode($_POST['userPassword']);
            // $userID = "13u2314";
            // $userPassword = "12345";
        $stmt_inAll = $conn->prepare("SELECT *,abuadlecturer.fullname as lecturerName,
        abuadlecturer.email as lecturerEmail, abuadlecturer.phone as lecturerPhone,
        abuadlecturer.department as lecturerDept, abuadlecturer.faculty as lecturerFaculty,
        abuadstudent.fullname as studName, abuadstudent.faculty as studFaculty,
        abuadstudent.department as studDept, abuadstudent.email as studEmail,
        abuadstudent.phone as studPhone FROM abuadstudent INNER JOIN abuaditinfo 
        ON  abuadstudent.regno = abuaditinfo.regno INNER JOIN abuadlecturer ON
            abuaditinfo.staffid = abuadlecturer.staffid INNER JOIN abuadcompany ON
            abuaditinfo.companyid = abuadcompany.companyId  where abuadstudent.regno=?  and abuadstudent.studentPassword=? Limit 1");
        $stmt_inAll->execute(array($userID,$userPassword));
        $affected_rows_inAll = $stmt_inAll->rowCount();
        if($affected_rows_inAll < 1) 
        {
            // $errPL="Error=> Wrong Username Or Password !!!";
            $outResponse ="";
        }else{
                $row_two = $stmt_inAll->fetch(PDO::FETCH_ASSOC);
                $outResponse =  json_encode($row_two);
        }
        print $outResponse;           
    }
    if ($opr == "loadnews"){
        $outResponse = $one = array();
        $stmt_inAll = $conn->prepare("SELECT *,abuaditnotice.id as noticeid, abuadlecturer.fullname as author, abuadlecturer.staffid from abuaditnotice
        INNER JOIN abuadlecturer ON  abuaditnotice.byId = abuadlecturer.staffid where delStatus=? order by abuaditnotice.id desc");
        $stmt_inAll->execute(array("0"));
        $affected_rows_inAll = $stmt_inAll->rowCount();
        
        if($affected_rows_inAll < 1)
        {
            $outResponse =array();
        }else{
            while ($row_two = $stmt_inAll->fetch(PDO::FETCH_ASSOC)){
                $NoticeDescription = htmlspecialchars_decode($row_two['NoticeDescription']);
                $NoticeDescription = strip_tags($NoticeDescription);

                // $subj_two = substr($NoticeDescription,0,300)."...";

                $title = htmlspecialchars_decode($row_two['title']);
                $title = strip_tags($title);
                
                $date500_two = new DateTime($row_two['noticeDate']);
                $J = date_format($date500_two,'l');
                $Q = date_format($date500_two,'d F, Y  h:i:s A');
                $date_two = $J.', '.$Q;

                $one =  array(
                    "noticeid"=> $row_two['noticeid'],
                    "author"=> $row_two['author'],
                    "NoticeDescription"=> $NoticeDescription,
                    "delStatus"=> $row_two['delStatus'],
                    "title"=> $title,
                    "noticeDate"=> $date_two
                );
                array_push($outResponse,$one);
            }
        }
        print json_encode($outResponse);
    }


    if ($opr == "loadCompany"){
        $outResponse = $one = array();
        $stmt_inAll = $conn->prepare("SELECT * from abuadcompany order by companyName asc");
        $stmt_inAll->execute();
        $affected_rows_inAll = $stmt_inAll->rowCount();
        
        if($affected_rows_inAll < 1)
        {
            $outResponse =array();
        }else{
            while ($row_two = $stmt_inAll->fetch(PDO::FETCH_ASSOC)){
                $one =  array(
                    "companyName"=> $row_two['companyName'],
                    "companyAddress"=> $row_two['companyAddress'],
                    "companyState"=> $row_two['companyState'],
                    "companyLocalGov"=> $row_two['companyLocalGov'],
                    "companyPhone"=> $row_two['companyPhone'],
                    "companyEmail"=> $row_two['companyEmail'],
                    "companyId"=> $row_two['companyId'],
                    "companyDescription"=> $row_two['companyDescription']
                );
                array_push($outResponse,$one);
            }
        }
        print json_encode($outResponse);
    }
    // 
    if ($opr == "loadStudentApplication"){
        $outResponse = $one = array();
        $userId = urldecode($_POST['userId']);
        $stmt_inAll = $conn->prepare("SELECT * from abuadapplication INNER JOIN abuadcompany ON
        abuadapplication.companyId = abuadcompany.companyId Where  abuadapplication.studentId=? order by abuadapplication.appstatus desc");
        $stmt_inAll->execute(array($userId));
        $affected_rows_inAll = $stmt_inAll->rowCount();
        
        if($affected_rows_inAll >= 1)
        {
            while ($row_two = $stmt_inAll->fetch(PDO::FETCH_ASSOC)){
                $one =  array(
                    "companyName"=> $row_two['companyName'],
                    "companyAddress"=> $row_two['companyAddress'],
                    "companyState"=> $row_two['companyState'],
                    "companyLocalGov"=> $row_two['companyLocalGov'],
                    "companyPhone"=> $row_two['companyPhone'],
                    "companyEmail"=> $row_two['companyEmail'],
                    "companyId"=> $row_two['companyId'],
                    "appStatus"=> $row_two['appstatus'],
                    "userId"=> $row_two['studentId'],
                    "companyDescription"=> $row_two['companyDescription']
                );
                array_push($outResponse,$one);
            }
        }
        print json_encode($outResponse);
    }

    if ($opr == "apply"){
        $outResponse = array();
        $userId = urldecode($_POST['userId']);
        $companyID = urldecode($_POST['companyID']);
        $stmt_inAll = $conn->prepare("SELECT * from abuadapplication where companyId=? and studentId=?");
        $stmt_inAll->execute(array($companyID,$userId));
        $affected_rows_inAll = $stmt_inAll->rowCount();
        if($affected_rows_inAll < 1)
        {
            $sth = $conn->prepare("INSERT INTO abuadapplication (companyId, studentId, appstatus) VALUES (?,?,?)");
            $sth->bindValue (1, $companyID);
            $sth->bindValue (2, $userId);
            $sth->bindValue (3, "0");
            if($sth->execute()){
                $outResponse =array(
                    "success"=>"success"
                );
            }
        }
        print json_encode($outResponse);
    }
    if ($opr == "updateApplication"){
        $outResponse = array();
        $userId = urldecode($_POST['userId']);
        $companyID = urldecode($_POST['companyID']);
        $sth = $conn->prepare("UPDATE abuadapplication SET  appstatus =? WHERE  companyId=? and studentId=? Limit 1");
        $sth->bindValue (1, "2");
        $sth->bindValue (2, $companyID);
        $sth->bindValue (3, $userId);
        if($sth->execute()){

            $sth1 = $conn->prepare("UPDATE abuaditinfo SET  companyid =? WHERE regno=? Limit 1");
            $sth1->bindValue (1, $companyID);
            $sth1->bindValue (2, $userId);
            if($sth1->execute()){
                $outResponse =array(
                    "success"=>"success"
                );
            }
            
        }
        
        print json_encode($outResponse);
    }
    
    if ($opr == "updateCompanyApplication"){
        $outResponse = array();
        $userId = urldecode($_POST['userId']);
        $companyID = urldecode($_POST['companyID']);
        $sth = $conn->prepare("UPDATE abuadapplication SET  appstatus =? WHERE  companyId=? and studentId=? Limit 1");
        $sth->bindValue (1, "1");
        $sth->bindValue (2, $companyID);
        $sth->bindValue (3, $userId);
        if($sth->execute()){

            $sth1 = $conn->prepare("UPDATE abuaditinfo SET  companyid =? WHERE regno=? Limit 1");
            $sth1->bindValue (1, $companyID);
            $sth1->bindValue (2, $userId);
            if($sth1->execute()){
                $outResponse =array(
                    "success"=>"success"
                );
            }
            
        }
        
        print json_encode($outResponse);
    }

    if ($opr == "loginCompany"){
        $userID = urldecode($_POST['userID']);
        $userPassword = urldecode($_POST['userPassword']);
            // $userID = "ABUAD194878564";
            // $userPassword = "12345";
        $stmt_inAll = $conn->prepare("SELECT * from abuadcompany  where companyId=?  and companyPassword=? Limit 1");
        $stmt_inAll->execute(array($userID,$userPassword));
        $affected_rows_inAll = $stmt_inAll->rowCount();
        if($affected_rows_inAll < 1) 
        {
            $outResponse ="";
        }else{
                $row_two = $stmt_inAll->fetch(PDO::FETCH_ASSOC);
                $outResponse =  json_encode($row_two);
        }
        print $outResponse;           
    }

    if ($opr == "loadCompanyApplication"){
        $outResponse = $one = array();
        $companyId = urldecode($_POST['companyId']);
        // $companyId = urldecode("ABUAD194878564");
        $stmt_inAll = $conn->prepare("SELECT * from abuadapplication INNER JOIN abuadstudent ON
        abuadapplication.studentId = abuadstudent.regno  Where  abuadapplication.companyId=? order by abuadapplication.appstatus desc");
        $stmt_inAll->execute(array($companyId));
        $affected_rows_inAll = $stmt_inAll->rowCount();
        
        if($affected_rows_inAll >= 1)
        {
                
            while ($row_two = $stmt_inAll->fetch(PDO::FETCH_ASSOC)){
                $one =  array(
                    "studName"=> $row_two['fullname'],
                    "contactAddress"=> $row_two['contactAddress'],
                    "itState"=> $row_two['itState'],
                    "itLgov"=> $row_two['itLgov'],
                    "itLevel"=> $row_two['itLevel'],
                    "gender"=> $row_two['gender'],
                    "studEmail"=> $row_two['email'],
                    "studPhone"=> $row_two['phone'],
                    "regno"=> $row_two['regno'],
                    "studDept"=> $row_two['department'],
                    "studFaculty"=> $row_two['faculty'],
                    "mode"=> $row_two['mode'],
                    "companyId"=> $row_two['companyId'],
                    "appStatus"=> $row_two['appstatus'],
                    "profilePics"=> $row_two['profilePics'],
                    "degree"=> $row_two['degree']
                );
                array_push($outResponse,$one);
            }
        }
        print json_encode($outResponse);
    }

    if ($opr == "uploaddata"){
        $outResponse =array();
        $records = urldecode($_POST['records']);
        $someArray = json_decode($records, true);
        $f = count($someArray['allrecord']);
        for($i=0; $i<$f; $i++){   
            $companyId = $someArray['allrecord'][$i]["companyId"];
            $stReg = $someArray['allrecord'][$i]["stReg"];
            $recordStatus = $someArray['allrecord'][$i]["recordStatus"];
            $recordDate = $someArray['allrecord'][$i]["recordDate"];

            $stmt_inAll = $conn->prepare("SELECT * from abuadregister where  regNo=? and companyId=? and recordDate=?");
            $stmt_inAll->execute(array($stReg, $companyId,$recordDate));
            $affected_rows_inAll = $stmt_inAll->rowCount();
            if($affected_rows_inAll >= 1)
            {
                //update
                $sth = $conn->prepare("UPDATE abuadregister 
                SET  regNo =?, companyId=?,recordDate=?, recordStatus=?  
                WHERE  regNo=? and companyId=? and recordDate=? Limit 1");
                $sth->bindValue (1, $stReg);
                $sth->bindValue (2, $companyId);
                $sth->bindValue (3, $recordDate);
                $sth->bindValue (4, $recordStatus);
                $sth->bindValue (5, $stReg);
                $sth->bindValue (6, $companyId);
                $sth->bindValue (7, $recordDate);
                $sth->execute();
                
            }else{
                //insert
                $sth = $conn->prepare("INSERT INTO abuadregister (companyId, regNo, recordDate,recordStatus) 
                VALUES (?,?,?,?)");
                $sth->bindValue (1, $companyId);
                $sth->bindValue (2, $stReg);
                $sth->bindValue (3, $recordDate);
                $sth->bindValue (4, $recordStatus);
                $sth->execute();
            }
        }
        if($f>=1){
            $outResponse = array("Error" => "Error");
        }else{
            $outResponse = array("Error" => "Error: Not Uploaded !!!");
        }
        print json_encode($outResponse);
    }

    

    if ($opr == "loadStudentAttendance"){
        $outResponse = $one = array();
        $userId = urldecode($_POST['userId']);
        $stmt_inAll = $conn->prepare("SELECT * from abuadregister  Where  regNo=? order by recordDate desc");
        $stmt_inAll->execute(array($userId));
        $affected_rows_inAll = $stmt_inAll->rowCount();
        
        if($affected_rows_inAll >= 1)
        {
                
            while ($row_two = $stmt_inAll->fetch(PDO::FETCH_ASSOC)){
                $one =  array(
                    "companyId"=> $row_two['companyId'],
                    "recordDate"=> $row_two['recordDate'],
                    "recordStatus"=> $row_two['recordStatus']
                );
                array_push($outResponse,$one);
            }
        }
        print json_encode($outResponse);
    }
?>