<?php
    session_start();
    require_once 'connection.php';
    $notice_msg = "";
    $txtgender =$txtname =$txttype =$txtphone =$txtemail =$txtemail =$txtcontact =$proceed="";
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['proceed'])){
		$txtstaffid=$_POST['txtstaffid'];$txtphone=trim($_POST['txtphone']);
        $txtname=trim($_POST['txtname']);$txttype=trim($_POST['txttype']);
        $txtemail=trim($_POST['txtemail']);$txtcontact=trim($_POST['txtcontact']);
        $txtfaculty =trim($_POST['txtfaculty']); $txtdept= trim($_POST['txtdept']); $txttitle=trim($_POST['txttitle']);
               
        if( $txtphone=="" || $txtname=="" || $txtcontact=="" || $txtstaffid=="" ||  $txtemail=="" || $txttitle=="" || $txtdept=="" || $txtfaculty=="" || $txttype=="")
            {
                $err = $errPL = "Unable to Save or Create New Staff .. Please Verify Your Entries to Ensure they are all Provided !!";
                $notice_msg='<div class="alert alert-danger alert-dismissable">
                           <button type="button" class="close" data-dismiss="alert" 
                              aria-hidden="true">
                              &times;
                           </button>'.$errPL.' </div>';
            }else{
                    //generate the staff id
                    $numL=mt_rand(100000,999999);
				    $doc_id = "ABUTH".$numL;
                    $sth = $conn->prepare("REPLACE INTO abuadlecturer (staffid, fullname, department, faculty, phone,email,staffaddress,stafftype,staffpassword) 
                    VALUES (?,?,?,?,?,?,?,?,?)");
                    $sth->bindValue (1, $txtstaffid);
                    $sth->bindValue (2, $txttitle .' '.$txtname);
                    $sth->bindValue (3, $txtdept);
                    $sth->bindValue (4, $txtfaculty);
                    $sth->bindValue (5, $txtphone);
                    $sth->bindValue (6, $txtemail);
                    $sth->bindValue (7, $txtcontact);
                    $sth->bindValue (8, $txttype);
                    $sth->bindValue (9, "abuad");
                    if($sth->execute()){
                        $err = $errPL = "Success: New Staff Record Created and Saved Successfully!!";
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
<script type="text/javascript" src="plugins/js/select2.js"></script>
<script type="text/javascript" src="plugins/js/select2.min.js"></script>
<script type="text/javascript" src="js/state_change_localgov.js"></script>
    <body>
    <?php include 'adminTopNav.php'?>
        <div class="container">
            <div class="row">
                <div class="content col-xs-12">
                    <form role="form"  name="reg_form"  id="form" class="form-vertical" action="" enctype="multipart/form-data" method="POST">
                        <div class="col-xs-12 col-md-6">
                            <h3>ADD NEW STAFF (AS UNIVERSITY BASE SUPERVISOR) </h3>
                            <?php echo $notice_msg; ?>
                            <hr/>
                                
                                <div class="form-group">
                                    <label for="txttitle"> Tile: </label>
                                    <select class="form-control" name="txttitle">
                                        <option value="Mr.">Mr.</option>
                                        <option value="Mrs.">Mrs.</option>
                                        <option value="Miss.">Miss.</option>
                                        <option value="Dr..">Dr.</option>
                                        <option value="Prof.">Prof.</option>
                                    </select>
                                </div>                               
                                 <div class="form-group">
                                    <label for="txtname">Full Name: </label>
                                    <input type="text" class="form-control" id="txtname" name="txtname" value="" required="true" placeholder="First Name Middle Name Last Name"/>
                                </div>
                                <div class="form-group">
                                    <label for="txtname">Staff ID: </label>
                                    <input type="text" class="form-control" id="txtstaffid" name="txtstaffid" value="" required="true" placeholder="Enter Staff ID"/>
                                </div>
                                <div class="form-group">
                                <label for="txtfaculty"> Faculty : </label> 
                                <select class="form-control js-example-basic-single" name="txtfaculty" id="faculty" onchange="schoolComboChange();">    
        
                                    <option value="Agriculture">Agriculture</option>
                                    <option value="Bussiness Studies">Bussiness Studies</option>
                                    <option value="Engineering">Engineering</option>
                                    <option value="Environmental Studies">Environmental Studies</option>
                                    <option value="Science">Science</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="txtdept"> Department : </label>
                                <select class="form-control js-example-basic-single" id="department" name="txtdept">
                                    <option value="<?php //echo $txtdept; ?>" ><?php //echo $txtdept; ?></option>
                                </select>
                            </div>
                        
                                    
                            </div>
                            <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                        <label for="txttype"> Type : </label>
                                        <select class="form-control js-example-basic-single"  name="txttype">
                                            <option value="1">Admin</option>
                                            <option value="0">Supervisor</option>
                                        </select>
                                    </div>
                                <div class="form-group">
                                    <label for="txtphone">Phone Number: </label>
                                    <input type="phone" class="form-control" id="txtphone" name="txtphone" required="true" placeholder="Enter Phone Number"/>
                                        
                                </div>
                                <div class="form-group">
                                    <label for="txtemail">Email Address: </label>
                                    <input type="email" class="form-control"  id="txtemail" name="txtemail" required="true" placeholder="Enter Email Address"/>
                                    
                                </div>
                                <div class="form-group">
                                    <label for="txtcontact">Contact Address: </label>
                                    <textarea rows="5" colunms="12" class="form-control" id="txtcontact" name="txtcontact" required="true" placeholder="Enter Contact Address"></textarea>
                                    
                                    <span class="help-block" id="result4" style="color:brown;text-align:center;"></span>
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="proceed" style="width:100%;margin-bottom:10px;padding:20px 20px 20px 20px" value="CREATE ACCOUNT" class="btn btn-primary btn-lg"></input>
                                </div>
                            </div>
                        </form>
                    
                </div>
            </div>
            <?php require_once 'footer.php'?>
        </div>
    </body>
</html> 