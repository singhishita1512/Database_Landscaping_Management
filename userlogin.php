<?php include('server.php') ?>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>

    <div class="container">

        <div class="header">
            <h2>User Login</h2>
        </div>

        <form action="userlogin.php" method="post" class="form">

            <?php include('errors.php') ?>

            <div class="input-group">
                <label for="regno"> Registration Number : </label>
                <input type="text" name="regno" required>
            </div>

            <div class="input-group">
                <label for="password1"> Password : </label>
                <input type="password" name="password1" required>
            </div>

            <div class="input-group">
            <button type="submit" class="btn" name="login_user">Login</button>
            </div>

            <p>New User? <a href="userregistration.php" style="color: red;">User Registration</a> </p>
            <p><a href="home.php" style="color: red;">Home</a> </p>

        </form>

    </div>

</body>

</html>