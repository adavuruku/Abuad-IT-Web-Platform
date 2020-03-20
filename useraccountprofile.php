<?php
    session_start();
    require_once 'connection.php';
    if (!isset($_GET['abuaditid']) || $_GET['abuaditid'] == ""){
        header("location: ?out=out");
    }
    $_SESSION['currentUser'] = $_GET['abuaditid'];
    $stmt_in = $conn->prepare("SELECT * FROM abuadstudent where regno = ? limit 1 ");
    $stmt_in->execute(array($_SESSION['currentUser']));
    $affected_rows_in = $stmt_in->rowCount();
    if($affected_rows_in < 1){
        header("location: ?out=out");
    }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<?php include 'header.php'?>
    <link rel="stylesheet" type="text/css" href="css/content.css">
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
                            <h3 style="margin-bottom:20px;font-weight:bolder">ITF STUDENT ACCOUNT HOME</h3>
                            <?php 
                                while($row_two_in = $stmt_in->fetch(PDO::FETCH_ASSOC))
                                {
                                    echo '<table class="table table-responsive">

                                            <tr >
                                                <td><h3>Name</h3></td>
                                                <td><h3>'.$row_two_in['fullname'].'<h3></td>
                                            </tr>
                                            <tr>
                                                <td><h3>Phone / Email</h3></td>
                                                <td><h3>'.$row_two_in['phone'].' / '.$row_two_in['email'].'</h3></td>
                                            </tr>
                                            <tr>
                                                <td><h3>Abuad Info</td>
                                                <td><h3>'.$row_two_in['faculty'].' / '.$row_two_in['department'].' / '.$row_two_in['itLevel'].'</h3></td>
                                            </tr>
                                            <tr>
                                                <td><h3>Contact Add</h3></td>
                                                <td><h3>'.$row_two_in['itState'].' - '.$row_two_in['itLgov'].' / '.$row_two_in['contactAddress'].'</h3></td>
                                            </tr>
                                            <tr>
                                                <td><h3 style="color:red">Start / End Date / Duration </h3></td>
                                                <td><h3></h3></td>
                                            </tr>
                                            
                                            <tr>
                                                <td colspan="2"><h3 style="color:red">Company / IT Placement Information</h3></td>
                                            </tr>
                                            <tr>
                                                <td ><h3>IT Placement Information</h3></td>
                                                <td ><h3></h3></td>
                                            </tr>
                                            <tr>
                                                <td ><h3>Address Information</h3></td>
                                                <td ><h3></h3></td>
                                            </tr>
                                            <tr>
                                                <td ><h3>State / Local Government </h3></td>
                                                <td ><h3></h3></td>
                                            </tr>
                                            <tr>
                                                <td ><h3>Phone / Email </h3></td>
                                                <td ><h3></h3></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><h3 style="color:red">University Base Supervisor Information</h3></td>
                                            </tr>
                                            <tr>
                                                <td ><h3>Name </h3></td>
                                                <td ><h3></h3></td>
                                            </tr>
                                            <tr>
                                                <td ><h3>Faculty / Department </h3></td>
                                                <td ><h3></h3></td>
                                            </tr>
                                            <tr>
                                                <td ><h3>Email / Phone N<u>o</u></h3></td>
                                                <td ><h3></h3></td>
                                            </tr>

                                        </table>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php require_once 'footer.php'?>
        </div>
    </body>
</html> 