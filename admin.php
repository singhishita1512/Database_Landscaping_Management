<?php include('server.php') ?>
<?php 

  if (!isset($_SESSION['admin'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: adminlogin.php');
  }
  if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['admin']);
    header("location: adminlogin.php");
  }
?>

<!DOCTYPE html>
<html>

<head>
    <title>Administration Operations</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="table.css">
    
</head>

<body>

    <br>

    <div class="header" form style= 'width:60%; height:40px'>
        <h2>Choose your Desired Operation</h2>
    </div>


    <form action="admin.php" method="post" class="form" form style= 'width:60%'>

    <?php include('errors.php') ?>

    <br><br>
        <button type="submit" name="VGR" class="btn">View Gardener Information</button>
        <button type="submit" name="V" class="btn">View Gardener Information by Area</button>
        <button type="submit" name="VG" class="btn">View Garden Information</button>
        
        <br><br>
        <button type="submit" name="VDR" class="btn">View Monthly Duty Roster</button>
        
        <button type="submit" name="VMR" class="btn">View Equipment Stock and Maintenance Records</button>
        
        <button type="submit" name="VPR" class="btn">View Pending Requests</button>

        <br><br>
        <button type="submit" name="CA" class="btn">Mark and Check Monthly Attendance</button>

        <br><br><br>






<!-- Gardener Details -->
<?php if(isset($_POST['VGR'])) :?>
    <?php $db = mysqli_connect('localhost', 'root', '', 'csproject','3307') or die("could not connect to database");?>

        <?php $query = mysqli_query($db, "Select * from gardener"); ?>
        <table class="styled-table">
            <tr>
                <th colspan="6">
                    <h2>Gardener Details</h2>
                </th>
            </tr>
            <thead>
            </thead>
            <thead>
                <tr>
                    <th>Gardener ID</th>
                    <th>Name</th>
                    <th>Date of Birth</th>
                    <th>Contact Number</th>
                    <th>Address</th>
                    <th>Date of Joining</th>
                </tr>
            </thead>
            <tbody>
                <?php while(($row=mysqli_fetch_array($query)))  { ?>
                
                <tr>
                    <td><?php echo $row[0]?></td>
                    <td><?php echo $row[1] ?></td>
                    <td><?php echo $row[2] ?></td>
                    <td><?php echo $row[3] ?></td>
                    <td><?php echo $row[4] ?></td>
                    <td><?php echo $row[5] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php endif ?>







<!-- Getting garden information using GID -->

<?php if(isset($_POST['sep_btn'])) :?>
        <?php 
                include('errors.php');
                $ar = mysqli_real_escape_string($db, $_POST['id1']);
                $_SESSION['ar'] = $ar;
                $checkquery=mysqli_query($db, "select * from garden where GID = '$ar'" );
                if($ar===false || empty($ar) ) {
                    array_push($errors, "Please enter valid Garden ID" ); }
                    else {
                            if($checkquery==false || mysqli_num_rows($checkquery) == 0){
                                array_push($errors, "Invalid GID" );
                            }
                            else{
                                $query=mysqli_query($db, "select Date_of_Work,GrID,work from roster where GID = '$ar'" );
                                if($query==false || mysqli_num_rows($query) == 0)  {
                                array_push($errors, "No gardener assigned in this area" );
                            }
                        }}?>

        <?php if(count($errors) == 0) :?>
        <table class="styled-table">
            <tr>
                <th colspan="3">
                    <h2>Gardener Information for GID </h2>
                    <?php echo $ar;?>
                </th>
            </tr>
            <thead>
            </thead>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Gardener ID</th>
                    <th>Work Assigned</th>
                </tr>
            </thead>
            <tbody>
                <?php while(($row=mysqli_fetch_array($query)))  { ?>
                
                <tr>
                    <td><?php echo $row[0]?></td>
                    <td><?php echo $row[1] ?></td>
                    <td><?php echo $row[2] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php else : ?>
        <div class="form">
            <?php include('errors.php') ?>
        </div>
        <?php endif?>
        <?php endif ?>







<!-- Enter garden id to get gardeners details -->

<?php if(isset($_POST['V'])) :?>
        <div class="form">
            <?php include('errors.php') ?>
            <div class="container">
                <div class="input-group">
                    <label>Enter GID : </label>
                    <input type="text" name="id1">
                </div>
            </div>
            <br>
            <button class="btn" type='submit' name="sep_btn">
                Get Gardener Information by Garden ID
            </button>
        </div>
        <?php endif ?>






<!-- Garden Details -->
<?php if(isset($_POST['VG'])) :?>
    <?php $db = mysqli_connect('localhost', 'root', '', 'csproject','3307') or die("could not connect to database");?>

        <?php $query = mysqli_query($db, "Select * from garden"); ?>
        <table class="styled-table">
            <tr>
                <th colspan="4">
                    <h2>Garden Details</h2>
                </th>
            </tr>
            <thead>
            </thead>
            <thead>
                <tr>
                    <th>Garden ID</th>
                    <th>Location</th>
                    <th>Jurisdiction</th>
                    <th>Area(m2)</th>
                </tr>
            </thead>
            <tbody>
                <?php while(($row=mysqli_fetch_array($query)))  { ?>
                
                <tr>
                    <td><?php echo $row[0]?></td>
                    <td><?php echo $row[1] ?></td>
                    <td><?php echo $row[2] ?></td>
                    <td><?php echo $row[3] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php endif ?>







<!-- Monthly Duty Roster -->

<?php if(isset($_POST['dr_btn'])) :?>
        <?php 
                include('errors.php');
                $monthNo = mysqli_real_escape_string($db, $_POST['month1']);
                $_SESSION['monthNo'] = $monthNo;
                if($monthNo===false || empty($monthNo) || (!($monthNo >=1 && $monthNo <= 12))) {
                    array_push($errors, "Please enter valid month number between 1 and 12" ); }
                    else {
                    $query=mysqli_query($db, "select * from roster where MONTH(date_of_work) = '$monthNo'" );  
                    if(empty($errors) && mysqli_num_rows($query) == 0) {
                        array_push($errors, "No work assigned in this month" ); 
                    }} ?>

        <?php if(count($errors) == 0) :?>
        <table class="styled-table">
            <tr>
                <th colspan="4">
                    <h2>Monthly Duty Roster</h2>
                </th>
            </tr>
            <thead>
            </thead>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Gardener ID</th>
                    <th>Garden ID</th>
                    <th>Work Assigned</th>
                </tr>
            </thead>
            <tbody>
                <?php while(($row=mysqli_fetch_array($query)))  { ?>
                
                <tr>
                    <td><?php echo $row[1]?></td>
                    <td><?php echo $row[2] ?></td>
                    <td><?php echo $row[3] ?></td>
                    <td><?php echo $row[4] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php else : ?>
        <div class="form">
            <?php include('errors.php') ?>
        </div>
        <?php endif?>
        <?php endif ?>






        
<!-- Enter month to get monthly roster details -->

<?php if(isset($_POST['VDR'])) :?>
        <div class="form">
            <?php include('errors.php') ?>
            <div class="container">
                <div class="input-group">
                    <label>Enter Month Number : </label>
                    <input type="text" name="month1">
                </div>
            </div>
            <br>
            <button class="btn" type='submit' name="dr_btn">
                Get Monthly Duty Roster
            </button>
        </div>
        <?php endif ?>

        





<!-- Marking Attendance Present-->        

<?php if(isset($_GET['id2'])){ 
    $db = mysqli_connect('localhost', 'root', '', 'csproject','3307') or die("could not connect to database");
    $id2 = $_GET['id2'];
    unset($_GET['id2']);
    
    $var1 = mysqli_query($db, " select `Task_ID`,`GrID` from roster where Task_ID='$id2';");
    $row = mysqli_fetch_array($var1);
    $query_attend = mysqli_query($db, " insert into `attendance` values ('$row[0]','$row[1]','Present');");
}?>
   
   





<!-- Marking Attendance Absent-->        

<?php if(isset($_GET['id3'])){ 
    $db = mysqli_connect('localhost', 'root', '', 'csproject','3307') or die("could not connect to database");
    $id3 = $_GET['id3'];
    unset($_GET['id3']);
    
    $var1 = mysqli_query($db, " select `Task_ID`,`GrID` from roster where Task_ID='$id3';");
    $row = mysqli_fetch_array($var1);
    $query_attend = mysqli_query($db, " insert into `attendance` values ('$row[0]','$row[1]','Absent');");
}?>







<!-- Monthly Attendance -->

<?php if(isset($_POST['at_btn'])) :?>
        <?php 
                include('errors.php');
                $monthNo2 = mysqli_real_escape_string($db, $_POST['month2']);
                $_SESSION['monthNo2'] = $monthNo2;
                if(empty($monthNo2) || (!($monthNo2 >=1 && $monthNo2 <= 12))) {
                    array_push($errors, "Please enter valid month number between 1 and 12" ); }
                    else {
                    $query=mysqli_query($db, "select roster.Task_ID, roster.Date_of_Work, roster.GrID, roster.GID, roster.work, attendance_mark from `roster` left join `attendance` on roster.Task_ID=attendance.Task_ID where MONTH(roster.Date_of_work) = '$monthNo2';" ); 
                    if(mysqli_num_rows($query) == 0) {
                        array_push($errors, "No tasks in this month" ); 
                    }} ?>

        <?php if(count($errors) == 0) :?>
        <table class="styled-table">
            <tr>
                <th colspan="6">
                    <h2>Monthly Attendance Sheet</h2>
                </th>
            </tr>
            <thead>
            </thead>
            <thead>
                <tr>
                    <th>Task ID</th>
                    <th>Date</th>
                    <th>Gardener ID</th>
                    <th>Garden ID</th>
                    <th>Work Assigned</th>
                    <th>Attendance Details</th>
                </tr>
            </thead>
            <tbody>
                <?php while(($row=mysqli_fetch_array($query)))  { ?>
                <tr>
                    <td><?php echo $row[0] ?></td>
                    <td><?php echo $row[1] ?></td>
                    <td><?php echo $row[2] ?></td>
                    <td><?php echo $row[3] ?></td>
                    <td><?php echo $row[4] ?></td>
                    <?php if($row[5]===NULL){ ?>
                        <td>
                        <?php echo "Attendance not marked yet!";?>    
                        <button type="submit" name="Present" class="btn" button style='background-color: green';><a href="admin.php?id2=<?php echo $row[0]; ?>">Present</a></button>
                        <br><br><button type="submit" name="Absent" class="btn" button style='background-color: red';><a href="admin.php?id3=<?php echo $row[0]; ?>">Absent</a></button></td>
                    <?php } else { ?>
                        <td> <?php echo $row[5];?> </td>
                        <?php } ?>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php else : ?>
        <div class="form">
            <?php include('errors.php') ?>
        </div>
        <?php endif?>
        <?php endif ?>







<!-- Enter month to get attendance details -->

<?php if(isset($_POST['CA'])) :?>
        <div class="form">
            <?php include('errors.php') ?>
            <div class="container">
                <div class="input-group">
                    <label>Enter Month Number : </label>
                    <input type="text" name="month2">
                </div>
            </div>
            <br>
            <button class="btn" type='submit' name="at_btn">
                Get Monthly Attendance Details
            </button>
        </div>
        <?php endif ?>







<!-- Stock and Maintenance Record Details -->
<?php if(isset($_POST['VMR'])) :?>
    <?php $db = mysqli_connect('localhost', 'root', '', 'csproject','3307') or die("could not connect to database");?>

        <?php $query = mysqli_query($db, "select stock.tool, quantity, repair_quantity, sent_on, receival_on from `stock` left join `repairs` on stock.tool=repairs.tool;"); ?>
        <table class="styled-table">
            <tr>
                <th colspan="6">
                    <h2>Stock and Maintenance Record Details</h2>
                </th>
            </tr>
            <thead>
            </thead>
            <thead>
                <tr>
                    <th>Equipment Picture</th>
                    <th>Tool</th>
                    <th>Total Quantity</th>
                    <th>Quantity for Repair</th>
                    <th>Sent On</th>
                    <th>Receival On</th>
                </tr>
            </thead>
            <tbody>
                <?php while(($row=mysqli_fetch_array($query)))  { ?>
                <?php if($row[2]===NULL){
                    $row[2]=0;
                    $row[3]="N/A";
                    $row[4]="N/A";
                }?>

                <tr>
                    <?php if($row[0]=="Gloss White Fence Paint"){?>
                    <td><img src="Images/fencepaint.jpg" alt="Equipment pic" width="80" height="80"></td>
                    <?php } else if($row[0]=="Hedge Trimmer"){?>
                    <td><img src="Images/hedgetrimmer.jpg" alt="Equipment pic" width="80" height="80"></td>
                    <?php } else if($row[0]=="Lawn Mower"){?>
                    <td><img src="Images/lawnmower.jpeg" alt="Equipment pic" width="80" height="80"></td>
                    <?php } else if($row[0]=="Leaf Rake"){?>
                    <td><img src="Images/leafrake.jpg" alt="Equipment pic" width="80" height="80"></td>
                    <?php } else if($row[0]=="Magic Potassium Fertilizer"){?>
                    <td><img src="Images/fertilizer.jpg" alt="Equipment pic" width="80" height="80"></td>
                    <?php } else if($row[0]=="Paint Brush"){?>
                    <td><img src="Images/paintbrush.jpg" alt="Equipment pic" width="80" height="80"></td>
                    <?php } else if($row[0]=="Showel"){?>
                    <td><img src="Images/showel.jpg" alt="Equipment pic" width="80" height="80"></td>
                    <?php } else if($row[0]=="Spade"){?>
                    <td><img src="Images/spadefinal.jpg" alt="Equipment pic" width="80" height="80"></td>
                    <?php } else if($row[0]=="Weeder"){?>
                    <td><img src="Images/weeder.jpg" alt="Equipment pic" width="80" height="80"></td>
                    <?php } else {?>
                    <td><?php echo "Pic unavailable";?></td><?php }?>
                    <td><?php echo $row[0]?></td>
                    <td><?php echo $row[1] ?></td>
                    <td><?php echo $row[2] ?></td>
                    <td><?php echo $row[3] ?></td>
                    <td><?php echo $row[4] ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php endif ?>







<!-- Pending Requests rejection -->     

<?php if(isset($_GET['id6'])){ 
    $db = mysqli_connect('localhost', 'root', '', 'csproject','3307') or die("could not connect to database");
    $id6 = $_GET['id6'];
    unset($_GET['id6']);
    $id66 = $_GET['id66'];
    unset($_GET['id66']);

    $querry1 = mysqli_query($db, "delete from `requests` where `GID`='$id6' and `work`='$id66' ;" );
}?>







<!-- Pending Requests acception final insertion -->

<?php if(isset($_POST['prf'])) :?>
        <?php 
                include('errors.php');
                $db = mysqli_connect('localhost', 'root', '', 'csproject','3307') or die("could not connect to database");
                
                $tsk = mysqli_real_escape_string($db, $_POST['tsk']);
                $grd = mysqli_real_escape_string($db, $_POST['grd']);
                $dtsk = mysqli_real_escape_string($db, $_POST['dtsk']);
                $key1 = $_POST['key1'];
                $key2 = $_POST['key2'];
                $_SESSION['tsk'] = $tsk;
                $_SESSION['grd'] = $grd;
                $_SESSION['dtsk'] = $dtsk;
                
                if($tsk===false || $dtsk===false || $grd===false || empty($tsk) || empty($dtsk) || empty($grd)) {
                    array_push($errors, "Please enter valid details" ); 
                    }
                    else {
                        $check1= mysqli_query($db, "select `GrID` from `gardener` where `GrID`= '$grd';" ); 
                        $check2= mysqli_query($db, "select `Task_ID` from `roster` where `Task_ID`= '$tsk';" );
                        if($check1 === false || mysqli_num_rows($check1) ==0 ){
                            array_push($errors, "Non-existant Garden ID" ); 
                        }
                        else{
                            if($check2 === false || mysqli_num_rows($check2) ==0 ){
                                $query=mysqli_query($db, "INSERT INTO `roster`(`Task_ID`, `Date_of_work`, `GrID`, `GID`, `work`) VALUES ('$tsk','$dtsk','$grd','$key1','$key2');" ); 
                                $quer=mysqli_query($db, "delete from `requests` where `GID`='$key1' and `work`='$key2' ;" );
                            }
                            else{
                                array_push($errors, "Task ID already exists" ); 
                            }
                        }
                    } ?>


        <?php if(count($errors) != 0) :?>
        <div class="form">
            <?php include('errors.php') ?>
        </div>
        <?php endif?>
        <?php endif?>





<!-- Pending Requests acception final -->     

<?php if(isset($_GET['id5'])){ 
    $db = mysqli_connect('localhost', 'root', '', 'csproject','3307') or die("could not connect to database");
    $id5 = $_GET['id5'];
    unset($_GET['id5']);
    $id55 = $_GET['id55'];
    unset($_GET['id55']);
    ?>
    <div>
    <form action="admin.php" method="post" class="form">
            <?php include('errors.php') ?>
            <div class="container">
                <div class="input-group">
                    <input type="text" name="key1" value="<?php echo $id5;?>" />
                </div>
                <div class="input-group">
                    <input type="text" name="key2" value="<?php echo $id55;?>" />
                </div>
                <div class="input-group">
                    <label>Enter Task ID : </label>
                    <input type="text" name="tsk">
                </div>
                <div class="input-group">
                    <label>Enter Gardener ID : </label>
                    <input type="text" name="grd">
                </div>
                <div class="input-group">
                    <label>Enter Date of Task : </label>
                    <input type="date" name="dtsk">
                </div>
                
            </div>
            <br>
            <button type="submit" name="prf" class="btn">Update Duty Roster</button>
        </form>
        </div>
    <?php }?>







<!-- Pending Requests -->
<?php if(isset($_POST['VPR'])) :?>
    <?php $db = mysqli_connect('localhost', 'root', '', 'csproject','3307') or die("could not connect to database");?>

        <?php $query = mysqli_query($db, "Select * from requests"); ?>
        <table class="styled-table">
            <tr>
                <th colspan="4">
                    <h2>Pending Requests</h2>
                </th>
            </tr>
            <thead>
            </thead>
            <thead>
                <tr>
                    <th>Garden ID</th>
                    <th>Work Requested</th>
                    <th>Accept</th>
                    <th>Reject</th>
                </tr>
            </thead>
            <tbody>
                <?php while(($row=mysqli_fetch_array($query)))  { ?>                    
                <tr>
                    <td><?php echo $row[0]?></td>
                    <td><?php echo $row[1] ?></td>
                    <td><button type="submit" name="Accept" class="btn" button style='background-color: green';><a href="admin.php?id5=<?php echo $row[0]?>&id55=<?php echo $row[1]?>">Accept</a></button></td>
                    <td><button type="submit" name="Reject" class="btn" button style='background-color: red';><a href="admin.php?id6=<?php echo $row[0]?>&id66=<?php echo $row[1]?>">Reject</a></button></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php endif ?>
        <br>

        <p> <a href="adminlogin.php?logout='1'" style="color: red;">logout</a> </p>
        <br>
   
</form>
</body>
</html>
