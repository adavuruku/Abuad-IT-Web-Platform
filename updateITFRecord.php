<?php
    
    session_start();
    require_once 'connection.php';
    if (!isset($_SESSION['currentUser']) || $_SESSION['currentUser'] == ""){
        header("location: ?out=out");
    }
    $stmt_in = $conn->prepare("SELECT * FROM abuadstudent where regno = ? limit 1 ");
    $stmt_in->execute(array($_SESSION['currentUser']));
    $affected_rows_in = $stmt_in->rowCount();
    if($affected_rows_in < 1){
        header("location: ?out=out");
    }


    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['proceed'])){
           
		$txttime=trim($_POST['txttime']);
        $txtdate=trim($_POST['txtdate']);$txtwith=trim($_POST['txtwith']);
        $txtpurpose=trim($_POST['txtpurpose']);
               
        if( $txtpurpose=="" || $txtdate=="" || $txtwith=="" ||  $txttime=="")
            {
                $err = $errPL = "Unable to Save and Preview Your Application.. Please Verify Your Entries to Ensure they are all Provided !!";
                $notice_msg='<div class="alert alert-danger alert-dismissable">
                           <button type="button" class="close" data-dismiss="alert" 
                              aria-hidden="true">
                              &times;
                           </button>'.$errPL.' </div>';
            }else{
                    
                    $sth = $conn->prepare("REPLACE INTO userschedule (HID, dateSchedule, timeSchedule, purpose,docid,byId,valid) VALUES (?,?,?,?,?,?,?)");
                    $sth->bindValue (1, $_SESSION['currentUser']);
                    $sth->bindValue (2, $txtdate);
                    $sth->bindValue (3, $txttime);
                    $sth->bindValue (4, $txtpurpose);
                    $sth->bindValue (5, $txtwith);
                    $sth->bindValue (6, $_SESSION['currentUser']);
                    $sth->bindValue (7, "0");
                    if($sth->execute()){
                        $err = $errPL = "Success: New Appointment Information Created and Saved Successfully!!";
                                $notice_msg='<div class="alert alert-success alert-dismissable">
                                           <button type="button" class="close" data-dismiss="alert" 
                                              aria-hidden="true">
                                              &times;
                                           </button>'.$errPL.' </div>';
                            
                    }else{
                                $err = $errPL = "Unable to Save Your Application.. Please Verify Your Entries to Ensure they are all Provided !!";
                                $notice_msg='<div class="alert alert-danger alert-dismissable">
                                           <button type="button" class="close" data-dismiss="alert" 
                                              aria-hidden="true">
                                              &times;
                                           </button>'.$errPL.' </div>';
                        
                        }
                
            }
    }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<?php include 'header.php'?>
    <link rel="stylesheet" type="text/css" href="css/content.css">
    <link rel="stylesheet" type="text/css" href="plugins/css/select2.css"/>
    <link rel="stylesheet" type="text/css" href="plugins/css/bootstrap-datepicker.css"/>
    <link rel="stylesheet" type="text/css" href="plugins/css/bootstrap-datepicker3.min.css"/>
    <script type="text/javascript" src="plugins/js/select2.js"></script>
    <script type="text/javascript" src="plugins/js/select2.min.js"></script>
    <script type="text/javascript" src="plugins/js/bootstrap-datepicker.js"></script>
    <body>
    <?php require_once 'adminTopNav.php'?>
        <div class="container">
            <div class="login">
                <div class="content">
                    <div class="row">
                        <div class="col-xs-12 col-md-4">
                            <?php require_once 'nav_left_staff.php'?>
                        </div>
                        <div class="col-xs-12 col-md-8">
                            <h3 style="margin-bottom:20px;font-weight:bolder">UPDATE / APPROVE IT STUDENTS INFORMATION.</h3>
                            <form role="form"  name="reg_form"  id="form" class="form-vertical" action="" enctype="multipart/form-data" method="POST">
                                <div class="form-group">
                                    <label for="txtname">Start Date: </label>
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="text" class="form-control" id="txtdate" name="txtdate" value="" required="true" placeholder="HH:MM"/>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="txtduration"> ITF Duration: </label>
                                    <select class="form-control js-example-basic-single" name="txtduration">
                                        <option value="3">3 Months</option>
                                        <option value="6">6 Months</option>
                                        <option value="12">12 Months (1 year)</option>
                                    </select>
                                </div>
                                
                                
                                <div class="form-group">
                                    <input type="submit" name="proceed" style="margin-bottom:10px;padding:10px 10px 10px 10px" value="UPDATE RECORD" class="btn btn-primary btn-lg"/>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
            <?php require_once 'footer.php'?>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                    $('.date').datepicker({
                        format: 'yyyy/mm/dd'
                    });
            });
    </script>
    </body>
</html> 