<?php

// Notice: Undefined index: txtdescription in /Applications/MAMP/htdocs/abuadit/newITCompany.php on line 12


session_start();
require_once 'connection.php';
 $txtname =$txtphone =$txtemail =$txtcpword =$cmbstate =$cmblgov =$txtcontact =$txtregno =$txtofficeadd=$notice_msg="";
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['proceed'])){
        $txtname =$_POST['txtname']; $txtphone =$_POST['txtphone']; $txtemail =$_POST['txtemail'];
        $cmbstate =$_POST['cmbstate']; $cmblgov =$_POST['cmblgov'];$txtcontact =$_POST['txtcontact'];
        $txtdescription =$_POST['txtdescription'];
        $txtpword =$_POST['txtpword'];$txtcpword=$_POST['txtcpword'];
    
               
        if( $txtphone=="" || $txtname=="" || $txtcontact=="" || 
            $txtemail=="" || $cmbstate =="" || $cmblgov =="" ||
            $txtcontact =="" || $txtdescription=="" || $txtpword=="" || $txtcpword=="" || $txtpword!=$txtcpword)
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
				    $company_id = "ABUAD".$numL;
                    $sth = $conn->prepare("REPLACE INTO abuadcompany (companyName, companyEmail, companyAddress, 
                    companyDescription, companyPhone, companyState, 
                    companyLocalGov, companyId, companyPassword, dateReg) VALUES (?,?,?,?,?,?,?,?,?,now())");
                    $sth->bindValue (1, $txtname);
                    $sth->bindValue (2, $txtemail);
                    $sth->bindValue (3, $txtcontact);
                    $sth->bindValue (4, $txtdescription);
                    $sth->bindValue (5, $txtphone);
                    $sth->bindValue (6, $cmbstate);
                    $sth->bindValue (7, $cmblgov);
                    $sth->bindValue (8, $company_id);
                    $sth->bindValue (9, $txtpword);
                    if($sth->execute()){
                        $err = $errPL = "<p>Success: You Have Successfully Register For ABUAD Student Industrial Trainning Programm !!</p>
                        <p>Company ID : ".$company_id."</p>";
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
                            <h3>REGISTER YOUR COMPANY OR ORGANIZATION WITH ABUAD</h3>
                            <?php echo $notice_msg?>
                            <hr/>
                        
                        <div class="form-group">
                            <label for="txtname">Company Name: </label>
                            <input type="text" class="form-control" id="txtname" name="txtname" value="<?php echo $txtname; ?>" required="true" placeholder="Enter Company Name"/>
                        </div>
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
                                    <label for="txtpword">Choose Password : </label>
                                    <input type="password" class="form-control"  id="txtpword" name="txtpword" required="true" placeholder="Enter Your Password"/>
                                </div>
                                <div class="form-group">
                                    <label for="txtcpword">Confirm Password : </label>
                                    <input type="password" class="form-control"  id="txtcpword" name="txtcpword" required="true" placeholder="Re Type Password"/>
                                </div>
                        
                    </div>
                    
                    <div class="col-xs-12 col-md-6">
                            
                            
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
                                    <textarea rows="4" colunms="12" class="form-control" id="txtcontact" name="txtcontact" required="true" placeholder="Enter Contact Address"><?php echo $txtcontact; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="txtdescription">Company Description: </label>
                                    <textarea rows="4" colunms="12" class="form-control" id="txtdescription" name="txtdescription" required="true" 
                                    placeholder="List the Course of study and types of students Your oranization may want to apply for IT Programme"><?php echo $txtdescription; ?></textarea>
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