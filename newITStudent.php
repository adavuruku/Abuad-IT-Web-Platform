<?php

// Notice: Undefined index: txtpword in /Applications/MAMP/htdocs/abuadit/newITStudent.php on line 10


session_start();
require_once 'connection.php';
 $txtname =$txtphone =$txtemail =$txtcpword =$cmbstate =$cmblgov =$txtcontact =$txtregno =$txtofficeadd=$notice_msg="";
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['proceed'])){
        $txtname =$_POST['txtname']; $txtphone =$_POST['txtphone']; $txtemail =$_POST['txtemail'];
        $cmbstate =$_POST['cmbstate']; $cmblgov =$_POST['cmblgov'];$txtcontact =$_POST['txtcontact'];
        $txtaward =$_POST['txtaward'];$txtmodestudy=$_POST['txtmodestudy'];
        $txtfaculty =$_POST['txtfaculty'];$txtgender =$_POST['txtgender'];$txtdept=$_POST['txtdept'];
        $txtpword =$_POST['txtpword'];$txtcpword=$_POST['txtcpword']; $txtregno =$_POST['txtregno'];$txtlevel=$_POST['txtlevel'];$txtdept =$_POST['txtdept'];
    
               
        if( $txtphone=="" || $txtname=="" || $txtcontact=="" || 
            $txtemail=="" || $txtdept =="" ||
            $txtdept=="" || $cmbstate =="" || $cmblgov =="" || $txtregno =="" || $txtlevel =="" ||
            $txtcontact =="" || $txtaward=="" || $txtmodestudy=="" || $txtfaculty=="" || $_FILES['image-file']['name']=="" || $txtgender=="" || $txtpword=="" || $txtcpword=="" || $txtpword!=$txtcpword)
            {
                $err = $errPL = "Unable to Save and Preview Your Application.. Please Verify Your Entries to Ensure they are all Provided !!";
                $notice_msg='<div class="alert alert-danger alert-dismissable">
                           <button type="button" class="close" data-dismiss="alert" 
                              aria-hidden="true">
                              &times;
                           </button>'.$errPL.' </div>';
            }else{
                    //generate the staff id
                    $numL=mt_rand(10000000,99999999);
				    $patience_id = "ABUTH".$numL;
                    $sth = $conn->prepare("REPLACE INTO abuadstudent (regno, fullname, faculty, itlevel, phone, email,contactAddress,gender,
                    degree,studentPassword, mode,itState, itLgov, department, dateReg) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,now())");
                    $sth->bindValue (1, $txtregno);
                    $sth->bindValue (2, $txtname);
                    $sth->bindValue (3, $txtfaculty);
                    $sth->bindValue (4, $txtlevel);
                    $sth->bindValue (5, $txtphone);
                    $sth->bindValue (6, $txtemail);
                    $sth->bindValue (7, $txtcontact);
                    $sth->bindValue (8, $txtgender);
                    $sth->bindValue (9, $txtaward);
                    $sth->bindValue (10, $txtpword);
                    $sth->bindValue (11, $txtmodestudy);
                    $sth->bindValue (12, $cmbstate);
                    $sth->bindValue (13, $cmblgov);
                    $sth->bindValue (14, $txtdept);
                    if($sth->execute()){
                        $tmpName  = $_FILES['image-file']['tmp_name'];
                        $extension = substr(strrchr($_FILES['image-file']['name'], "."), 1);
                        $newpath= $txtregno.".$extension";
                        $moveto= "resource/".$newpath;
                        move_uploaded_file($tmpName,$moveto);
                        $err = $errPL = "Success: You Have Successfully Register For ABUAD Student Industrial Trainning Programm !!";
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
    <script type="text/javascript" src="js/state_change_localgov.js"></script>
    <link rel="stylesheet" type="text/css" href="plugins/css/select2.css"/>
    <script type="text/javascript" src="plugins/js/select2.js"></script>
    <script type="text/javascript" src="plugins/js/select2.min.js"></script>
    
    <body>
    <nav role="navigation"  class="navbar  navbar-fixed-top navbar-inverse">
            <h2 style="text-align: center;color:white">ABUAD INDUSTRIAL TRAINNING (IT) PLATFORM</h2>
        </nav>
        <div class="container">
            <div class="row">
                <div class="content col-xs-12">
                    <form role="form"  name="reg_form"  id="form" class="form-vertical" action="" enctype="multipart/form-data" method="POST">
                    <div class="col-xs-12 col-md-6">
                            <h3>REGISTER FOR INDUSTRIAL TRAINNING (IT)</h3>
                            <?php echo $notice_msg?>
                            <hr/>
                        <div class="imageupload panel panel-primary" id="my-imageupload">
                            <div class="panel-heading clearfix">
                                <h3 class="panel-title pull-left">Upload Passport - jpg / jpeg - <= 500kb - 250 X 250</h3>
                            </div>
                            <div class="file-tab panel-body">
                                <label class="btn btn-default btn-file">
                                    <span>Browse</span>
                                    <!-- The file is stored here. -->
                                    <input type="file" name="image-file">
                                </label>
                                <button type="button" class="btn btn-default">Remove</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="txtname">Full Name: </label>
                            <input type="text" class="form-control" id="txtname" name="txtname" value="<?php echo $txtname; ?>" required="true" placeholder="First Name Middle Name Last Name"/>
                        </div>
                        <script src="js/bootstrap-imageupload.js"></script>
                        <script>
                            var $imageupload = $('.imageupload');
                            $imageupload.imageupload();
                            $('#my-imageupload').imageupload({
                                allowedFormats: [ 'jpg','jpeg' ],
                                maxFileSizeKb: 500,
                                maxWidth: auto,
                                maxHeight: 250
                            });
                        </script>
                        <div class="form-group">
                            <label for="txtregno">Registration N<u>o</u> </label>
                            <input type="text" class="form-control" id="txtregno" name="txtregno" value="<?php echo $txtregno; ?>" required="true" placeholder="Enter School Registration No."/>
                        </div>
                        <div class="form-group">
                            <label for="txtgender"> Gender: </label>
                            <select class="form-control js-example-basic-single" name="txtgender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
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
                            <select class="form-control js-example-basic-single" id="txtdept" name="txtdept">
                                <option value="<?php //echo $txtdept; ?>" ><?php //echo $txtdept; ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtlevel" > Level : </label>
                            <select class="form-control js-example-basic-single" name="txtlevel">
                                <option value="200">200</option>
                                <option value="300">300</option>
                                <option value="400">400</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtlevel" > Mode Of Study: </label>
                            <select class="form-control js-example-basic-single" name="txtmodestudy">
                                <option value="Full Time">Full Time</option>
                                <option value="Part Time">Part Time</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtaward" > Award in View : </label>
                            <select class="form-control js-example-basic-single" name="txtaward">
                                <option value="Diploma">Diploma</option>
                                <option value="Degree">Degree</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-md-6">
                            
                            <div class="form-group">
                                <label for="txtphone">Phone Number: </label>
                                <input type="phone" class="form-control"  onkeydown="return noNumbers(event,this)" id="txtphone" value="<?php echo $txtphone; ?>" name="txtphone" required="true" placeholder="Enter Phone Number"/>
                            </div>

                            <div class="form-group">
                                <label for="txtemail">Email Address: </label>
                                <input type="email" class="form-control" id="txtemail" 
                                value="<?php echo $txtemail; ?>" name="txtemail" required="true" placeholder="Enter Email Address"/>
                            </div>
                            <div class="form-group">
                                    <label for="cmbstate"> State: </label>
                                    <select class="form-control js-example-basic-single"  id="cmbstate" name="cmbstate" onchange="stateComboChange();">
                                        
                                        <option value="Abuja" title="Abuja">Abuja</option>
                                        <option value="Abia" title="Abia">Abia</option>
                                        <option value="Adamawa" title="Adamawa">Adamawa</option>
                                        <option value="Akwa Ibom" title="Akwa Ibom">Akwa Ibom</option>
                                        <option value="Anambra" title="Anambra">Anambra</option>
                                        <option value="Bauchi" title="Bauchi">Bauchi</option>
                                        <option value="Bayelsa" title="Bayelsa">Bayelsa</option>
                                        <option value="Benue" title="Benue">Benue</option>
                                        <option value="Bornu" title="Bornu">Bornu</option>
                                        <option value="Cross River" title="Cross River">Cross River</option>
                                        <option value="Delta" title="Delta">Delta</option>
                                        <option value="Ebonyi" title="Ebonyi">Ebonyi</option>
                                        <option value="Edo" title="Edo">Edo</option>
                                        <option value="Ekiti" title="Ekiti">Ekiti</option>
                                        <option value="Enugu" title="Enugu">Enugu</option>
                                        <option value="Gombe" title="Gombe">Gombe</option>
                                        <option value="Imo" title="Imo">Imo</option>
                                        <option value="Jigawa" title="Jigawa">Jigawa</option>
                                        <option value="Kaduna" title="Kaduna">Kaduna</option>
                                        <option value="Kano" title="Kano">Kano</option>
                                        <option value="Katsina" title="Katsina">Katsina</option>
                                        <option value="Kebbi" title="Kebbi">Kebbi</option>
                                        <option  value="Kogi" title="Kogi">Kogi</option>
                                        <option value="Kwara" title="Kwara">Kwara</option>
                                        <option value="Lagos" title="Lagos">Lagos</option>
                                        <option value="Nassarawa" title="Nassarawa">Nassarawa</option>
                                        <option value="Niger" title="Niger">Niger</option>
                                        <option value="Ogun" title="Ogun">Ogun</option>
                                        <option value="Ondo" title="Ondo">Ondo</option>
                                        <option value="Osun" title="Osun">Osun</option>
                                        <option value="Oyo" title="Oyo">Oyo</option>
                                        <option value="Plateau" title="Plateau">Plateau</option>
                                        <option value="Rivers" title="Rivers">Rivers</option>
                                        <option value="Sokoto" title="Sokoto">Sokoto</option>
                                        <option value="Taraba" title="Taraba">Taraba</option>
                                        <option value="Yobe" title="Yobe">Yobe</option>
                                        <option value="Zamfara" title="Zamfara">Zamfara</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="cmblgov"> Local Government: </label>
                                    <select class="form-control js-example-basic-single"  id="cmblgov" name="cmblgov">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="txtcontact">Contact Address: </label>
                                    <textarea rows="6" colunms="12" class="form-control" id="txtcontact" name="txtcontact" required="true" placeholder="Enter Contact Address"><?php echo $txtcontact; ?></textarea>
                                </div>
                        
                                <div class="form-group">
                                    <label for="txtpword">Choose Password : </label>
                                    <input type="password" class="form-control"  id="txtpword" name="txtpword" required="true" placeholder="Enter Your Password"/>
                                </div>
                                <div class="form-group">
                                    <label for="txtcpword">Confirm Password : </label>
                                    <input type="password" class="form-control"  id="txtcpword" name="txtcpword" required="true" placeholder="Re Type Password"/>
                                </div>
                        <div class="form-group">
                                <input type="submit" name="proceed" style="width:100%;margin-bottom:10px;padding:20px 20px 20px 20px" value="CREATE ACCOUNT" class="btn btn-primary btn-lg"/>
                        </div>
                    </div>
                </form>
                </div>
            </div>
            
        </div>
        <?php require_once 'footer.php'?>
    </body>
</html> 