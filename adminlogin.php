<!-- Password= 1234 -->

<?php include('server.php') ?>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

    <div class="container">

        <div class="header">
            <h2>Administration Login</h2>
        </div>

        <form action="adminlogin.php" method="post" class="form">

            <?php include('errors.php') ?>

            <div class="input-group">
                <label for="password">Password : </label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" name="admin_login" class="btn">Login</button>
            
            <p><a href="home.php" style="color: red;">Home</a> </p>
        </form>

    </div>

</body>

</html>