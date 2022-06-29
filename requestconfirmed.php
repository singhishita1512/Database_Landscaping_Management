<!-- Shows Confirmation page after succesfull payment -->

<?php include('server.php') ?>
<?php 
  if (!isset($_SESSION['name1'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
  }
  if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['name1']);
    header("location: login.php");
  }

?>

<!DOCTYPE html>
<html>

<head>
    <title>Confirmation Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

    <div class="header">
        <h2>Request Confirmation Page</h2>
    </div>


    <form action="index.php" method="post" class="form">


        <div>
            <!-- notification message -->
            <?php if (isset($_SESSION['success1'])) : ?>
            <div class="error success">
                <h3>
                    <?php 
            echo $_SESSION['success1']; 
            unset($_SESSION['success1']);
          ?>

                </h3>
            </div>
            <?php endif ?>

            <!-- logged in user information -->
            <?php  if (isset($_SESSION['name1'])) : ?>
            <div style="text-align:center">
                <h2>It will soon be discussed by the Administration</h2>
                <br>
            </div>


            <p> <a href="userlogin.php?logout='1'" style="color: red;">Logout</a> </p>
            <p> <a href="userrequests.php" style="color: red;">Back</a> </p>
            <?php endif ?>
        </div>
    </form>

</body>

</html>