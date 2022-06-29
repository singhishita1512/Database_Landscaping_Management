<!-- Home Page -->
<?php include('server.php') ?>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
    body {
    background-image: url('Images/iitpatna3.jpg' );
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: 100% 100%;
    margin: 120px;
}
</style>
</head>

<body>

    <div class="container">

        <div class="header">
            <h2>Home</h2>
        </div>

        <form action="home.php" method="post" class="form">

            <?php include('errors.php') ?>

            <p><a href="adminlogin.php" style="color: red;">Admin Login</a> </p>
            <p><a href="userregistration.php" style="color: red;">User Registration</a> </p>
            <p><a href="userlogin.php" style="color: red;">User Login</a> </p>
        </form>
    </div>
</body>

</html>
