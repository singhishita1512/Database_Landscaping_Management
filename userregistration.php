<!-- User Registration page -->
<?php include('server.php') ?>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registration</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>


    <div class="container">

        <div class="header">
            <h2>User Registration</h2>
        </div>

        <form action="userregistration.php" method="post" class="form">

            <?php include('errors.php') ?>

            <div class="input-group">
                <label for="name1"> Name : </label>
                <input type="text" name="name1" required>
            </div>

            <div class="input-group">
                <label for="category"> Staff/Student : </label>
                <input type="text" name="category" required>
            </div>

            <div class="input-group">
                <label for="regno"> Registration Number : </label>
                <input type="text" name="regno" required>
            </div>

            <div class="input-group">
                <label for="email"> Email ID : </label>
                <input type="email" name="email" required>
            </div>

            <div class="input-group">
                <label for="dob"> Date of Birth : </label>
                <input type="date" name="dob" required>
            </div>

            <div class="input-group">
                <label for="phoneno"> Phone Number : </label>
                <input type="text" name="phoneno" required>
            </div>

            <div class="input-group">
                <label for="password1"> Password : </label>
                <input type="password" name="password1" required>
            </div>

            <div class="input-group">
                <label for="password2"> Confirm Password : </label>
                <input type="password" name="password2" required>
            </div>

            <div class="input-group">
            <button type="submit" class="btn" name="reg_user">Register</button>
            </div>

            <p>Existing User? <a href="userlogin.php" style="color: red;">User Login</a> </p>
            <p><a href="home.php" style="color: red;">Home</a> </p>

        </form>
    </div>
</body>

</html>
