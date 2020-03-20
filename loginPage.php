
<?php
session_start();
require_once 'connection.php';
$txtreg =$txtemail=$errPL="";
if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$txtemail =trim($_POST['txtemail']); 
	$txtreg =trim($_POST['txtreg']);
	$txttype =trim($_POST['txttype']);
	if($txtemail!="" && $txtreg!=""){
        // if($txttype=="itstudent"){
            $stmt_in = $conn->prepare("SELECT * FROM abuadlecturer where staffid=? and staffpassword=? Limit 1");
            $stmt_in->execute(array($txtreg,$txtemail));
            $affected_rows_in = $stmt_in->rowCount();
            if($affected_rows_in < 1) 
            {	
                $errPL="Error: The RegNo or Password does not exist . Contact ICT !!!";
            }else{
                    $row_two = $stmt_in->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['staffid'] = $row_two['staffid'];
                    $_SESSION['logName'] = $row_two['fullname'];
                    $_SESSION['type'] = $row_two['type'];
                    if ($row_two['type'] == 1)
                        header("location: adminHome.php");
                    else
                        header("location: adminHome.php");
                    
            }
        // }
		
	}else{
		$errPL="Error: Empty or Invalid Data's Provided !!!";
	}									
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
    <?php include 'header.php'?>
    <link rel="stylesheet" type="text/css" href="css/mystyle.css">
    <body>
        <nav role="navigation"  class="navbar  navbar-fixed-top navbar-inverse">
            <h2 style="text-align: center;color:white">ABUAD INDUSTRIAL TRAINNING (IT) PLATFORM</h2>
        </nav>
        <div class="container">
            <div class="login">
                    <h2 style="margin-bottom:20px;padding:10px;text-align:center">Please Login</h2>
                    <hr/>
                    <form role="form"  name="reg_form"  id="form" class="form-vertical" action="" enctype="multipart/form-data" method="POST">
                            
                            <div class="form-group">
                                <label for="txtreg">Login Type : </label>
                                <div class="input-group">
                                    <select class="form-control js-example-basic-single" style="padding: 15px; height:60px; font-size: 24px;width: 100%;" name="txttype">
                                        
                                        <option value="company">COMPANY / ORGANIZATION</option>
                                        <option value="staff">ABUAD STAFF</option>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="txtreg">Staff ID N<u>o</u> : </label>
                                <div class="input-group">
                                   
                                    <input type="text" class="form-control" id="txtreg" name="txtreg" value="" required="true" placeholder="Enter Matriculation / Registration No"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="txtemail">Password : </label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="txtemail" name="txtemail" required="true" placeholder="Enter Password"/>
                                </div>
                                <span class="help-block" id="result4" style="color:brown;text-align:center;"></span>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="submit" name="proceed" style="margin-bottom:10px;padding:5px 20px 5px 20px" value="Continue" class="btn btn-primary btn-md"></input>
                                    <?php echo  $errPL; ?>
                                </div>
                        </div>
                    </form>
            </div>
            
        </div>
        <?php require_once 'footer.php'?>
    </body>
</html> 