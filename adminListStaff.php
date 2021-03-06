<?php
    session_start();
    require_once 'connection.php';
    $txtSearch = "";
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['txtSearch'])){
        $stmt_in = $conn->prepare("SELECT * FROM abuadlecturer where fullname like ? or phone like ? or email like ?
        or staffid like ?  ORDER BY stafftype, id DESC ");
        $txtSearch = trim($_POST['txtSearch']);
        $search = "%".$txtSearch."%";
        $stmt_in->execute(array($search,$search,$search,$search));
        $affected_rows_in = $stmt_in->rowCount();
    }else{
        $stmt_ina = $conn->prepare("SELECT * FROM abuadlecturer");
        $stmt_ina->execute(array());
        $affected_rows_ina = $stmt_ina->rowCount();
        $current_page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
        $total_count = $affected_rows_ina;
        $per_page = 1;//26
        $total_pages = ceil($total_count/$per_page);
        $offset = ($current_page - 1) * $per_page;
        $previous_page = $current_page - 1;	
        $next_page = $current_page + 1;
        $has_previous_page =  $previous_page >= 1 ? true : false;
        $has_next_page = $next_page <= $total_pages ? true : false;
        $stmt_in = $conn->prepare("SELECT * FROM abuadlecturer ORDER BY stafftype, id DESC Limit {$per_page} OFFSET {$offset}");
        $stmt_in->execute();
        $affected_rows_in = $stmt_in->rowCount();
    }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<?php include 'header.php'?>
    <link rel="stylesheet" type="text/css" href="css/content.css">
    <script type="text/javascript" src="js/state_change_localgov.js"></script>
    <body>
    <?php include 'adminTopNav.php'?>
        <div class="container">
            <div class="login">
                <div class="content">
                    <h3 style="margin-bottom:20px;font-weight:bolder">LIST OF ALL STAFF</h3>
                    <form role="form" class="form-horizontal" action="" enctype="multipart/form-data" method="POST">
                        <div class="form-group">
                            <div class="col-xs-6">
                                    <input type="text" value="<?php echo $txtSearch ?>" name="txtSearch" placeholder="Enter Staff ID / Part Or Full Name / Phone / Email To Search" class="form-control">
                            </div>
                            <div class="col-xs-6">
                                <input class="btn btn-primary"   name="search" style="width:15%;margin-bottom:10px;padding:5px 5px 5px 5px;" type="submit" Value="Search" />
                            </div>
                        </div>
                    </form>
                    <hr/>
                    <table class="table table-responsive table-stripped">
                        <thead style="background-color:grey;color:white">
                            <tr >
                                <td>#</td>
                                <td>Staff ID</td>
                                <td>Name</td>
                                <td>Phone / Email</td>
                                <td>Contact Address</td>
                                <td>Type</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                if($affected_rows_in >= 1)
                                {
                                    $r=0;
                                    while($row_two_in = $stmt_in->fetch(PDO::FETCH_ASSOC))
                                    {
                                       $r+=1;
                                       $type = $row_two_in['stafftype'] ==1? "Admin" : "Supervisor" ;
                                       echo '
                                       <tr>
                                            <td>'.$r.'</td>
                                            <td>'.$row_two_in['staffid'].'</td>
                                            <td>'.$row_two_in['fullname'].'</td>
                                            <td>'.$row_two_in['phone'].' / '.$row_two_in['email'].'</td>
                                            <td>'.$row_two_in['staffaddress'].'</td>
                                            <td>'.$type.'</td>
                                            <td><a class="btn btn-danger" href="" ><i class="glyphicon glyphicon-remove"></i></td>
                                        </tr>
                                       ';
                                    }
                                }
                            ?>
                        </tbody>
                    </table>	
                        <ul class="pagination">
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] != "POST"){
                                if ($total_pages > 1)
                                {
                                    if ($has_previous_page)
                                    {
                                        echo '<li><a href=?page='.$previous_page.'>&laquo; </a> </li>';
                                    }
                                    for($i = 1; $i <= $total_pages; $i++)
                                    {
                                        if ($i == $current_page)
                                        {
                                            echo '<li class="active"><span>'. $i.' <span class="sr-only">(current)</span></span></li>';
                                        }
                                        else
                                        {
                                            echo ' <li><a href=?page='.$i.'> '. $i .' </a></li>';
                                        }
                                    }	
                                    if ($has_next_page)
                                    {
                                        echo ' <li><a href=?page='.$next_page.'>&raquo;</a></li> ';
                                    }
                                    
                                }
                            }							
                               
                            ?>
                        </ul>
                </div>
            </div>
            
        </div>
        <nav role="navigation"  class="navbar  navbar-fixed-bottom navbar-inverse">
                <h5 style="text-align: center;color:white">Copyright &copy; 2020 - Alright Reserved</h5>
        </nav>
    </body>
</html> 