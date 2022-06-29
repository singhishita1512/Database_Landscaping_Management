<?php include('server.php') ?>
<?php 

  if (!isset($_SESSION['name1'])) {
      //echo "yes";
    $_SESSION['msg'] = "You must log in first";
    header('location: userlogin.php');
  }

  if (isset($_GET['logout'])) {
      //echo "yes1";
    session_destroy();
    unset($_SESSION['name1']);
    header("location: userlogin.php");
  }

  
?>


<?php include('errors.php') ?>

<!DOCTYPE html>
<html>

<head>
    <title>Landscaping Requests</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="table.css">
</head>

<body>

    <br>

    <div class="header">
        <h2>Please make Desired Request</h2>
    </div>


    <form action="userrequests.php" method="post" class="form">


            <div class="input-group">
                <label for="GID"> Enter Garden ID : </label>
                <input type="text" name="GID" required>
            </div>

        <br>
        <button type="submit" name="FM" class="btn">Fence Maintenance</button>
        <br>
        <br>
        <button type="submit" name="WD" class="btn">Weeding</button>
        <br>
        <br>
        <button type="submit" name="FRT" class="btn">Fertilizing</button>
        <br>
        <br>
        <button type="submit" name="GTR" class="btn">Grass Trimming</button>
        <br>
        <br>
        <button type="submit" name="HTR" class="btn">Hedge Trimming</button>
        <br>
        <br>
        <p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
        <br>

</form>

<br><br>
</body>
</html>
