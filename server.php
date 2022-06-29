<?php
    session_start();

    $errors = array();
    // connect to dbms
    $db = mysqli_connect('localhost', 'root', '', 'csproject','3307') or die("could not connect to database");


    //adminlogin
    if(isset($_POST['admin_login'])) {
        $pass = mysqli_real_escape_string($db, $_POST['password']);
        if($pass == '1234') {
            $_SESSION['admin'] = "good";
            header('location: admin.php');
        }
        else {
            array_push($errors, "Wrong Password");
        }
        
    }





    // Register Users
    if (isset($_POST['reg_user'])) {

        // storing the user input in variables
        $name1 = mysqli_real_escape_string($db, $_POST['name1']);
        $category = mysqli_real_escape_string($db, $_POST['category']);
        $regno = mysqli_real_escape_string($db, $_POST['regno']);
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $dob = mysqli_real_escape_string($db, $_POST['dob']);
        $phoneno = mysqli_real_escape_string($db, $_POST['phoneno']);
        $password1 = mysqli_real_escape_string($db, $_POST['password1']);
        $password2 = mysqli_real_escape_string($db, $_POST['password2']);

        // form validation
        if (empty($name1)) {
            array_push($errors, "Name is a required field");
        }
        if (empty($category)) {
            array_push($errors, "Category is a required field");
        }
        if (empty($regno)) {
            array_push($errors, "Registration Number is a required field");
        }
        if (empty($email)) {
            array_push($errors, "Email ID is a required field");
        }
        if (empty($dob)) {
            array_push($errors, "Date of Birth is a required field");
        }
        if (empty($phoneno)) {
            array_push($errors, "Phone Number is a required field");
        }
        if (empty($password1) || empty($password2)) {
            array_push($errors, "Password is required");
        }
        if ($password1 != $password2) {
            array_push($errors, "Passwords do not match");
        }

        
        $user_check_query = "SELECT * FROM user WHERE regno = '$regno'";
        $results = mysqli_query($db, $user_check_query);

        //if( $results) echo "YES";
        //else echo "NO";

        $user1 = mysqli_fetch_assoc($results);

        if ($user1) {  
            array_push($errors, "Registration Number already exists, please proceed to login");
        }
            
    
        // if no errors then proceed to enter into database
        if (count($errors) == 0) {
            $query = "INSERT INTO user (name, category, regno, email, dob, phoneno, password) VALUES ( '$name1', '$category', '$regno', '$email', '$dob', '$phoneno', '$password1') ";
            $check = mysqli_query($db, $query);

            //if( $check) echo "YES";
            //else echo "NO";
            
            $_SESSION['name1'] = $name1;        
            $_SESSION['category'] = $category;   
            $_SESSION['regno'] = $regno;   
            $_SESSION['email'] = $email;   
            $_SESSION['dob'] = $dob;   
            $_SESSION['phoneno'] = $phoneno;   
            $_SESSION['password1'] = $password1;   

            $_SESSION['success'] = "You are now registered! Login again to continue.";
            header('location: index.php');
        }
    }





    // LOGIN USER
    if (isset($_POST['login_user'])) {

        // storing input from user in variables
        $regno = mysqli_real_escape_string($db, $_POST['regno']);
        $password1 = mysqli_real_escape_string($db, $_POST['password1']);

    //echo '$password1';

        // neither of fields should be empty
        if (empty($regno)) {
            array_push($errors, "Registration Number is required");
        }
        if (empty($password1)) {
            array_push($errors, "Password is required");
        }
        
        if (count($errors) == 0) {
            $query = "SELECT * FROM user WHERE regno = '$regno' AND BINARY password = '$password1' ";
            $results = mysqli_query($db, $query);
                
            if (mysqli_num_rows($results) == 1) {
                $row = mysqli_fetch_assoc($results);

                //stored in SESSION for further display in index.php
                $_SESSION['name1'] = $regno;                
                $_SESSION['password1'] = $password1; 
                $_SESSION['success'] = "You are now Logged In!";
                header('location: userrequests.php');
            } else {
                array_push($errors, "Wrong Registration Number / Password combination!");
            }
        }
    }





// Fence Maintenance Request
if (isset($_POST['FM'])) {

    // storing input from user in variables
    $GID = mysqli_real_escape_string($db, $_POST['GID']);
    $request= "Fence Maintenance";

    // field should not be empty
    if (empty($GID)) {
        array_push($errors, "Garden ID is required");
    }
    
    if (count($errors) == 0) {
        
        $query = "SELECT * FROM garden WHERE GID = '$GID' ";
        $results = mysqli_query($db, $query);
            
        if (mysqli_num_rows($results) == 1) {

            $row = mysqli_fetch_assoc($results);
            $query2 = "SELECT * FROM requests WHERE GID = '$GID' AND work = '$request' ";
            $results2 = mysqli_query($db, $query2);
            $query12 = "SELECT * FROM `roster` WHERE GID = '$GID' AND work = '$request' and Date_of_work> Current_date() ";
            $results12 = mysqli_query($db, $query12);
            if(($results12 === false || mysqli_num_rows($results12) ==0) && ($results2 === false || mysqli_num_rows($results2) ==0 )) {
                $query3 = "INSERT INTO requests (GID, work) VALUES ( '$GID', '$request') ";
                $check = mysqli_query($db, $query3);
                            
                $_SESSION['success1'] = "Request has been made to Landscaping Department.";

                header('location: requestconfirmed.php');
            }
            else {
                array_push($errors, "Request is either already registered/ or under work!");
            }
        } 
        else {
            array_push($errors, "Garden ID not in database!");
        }
    }
}






// Weeding Request
if (isset($_POST['WD'])) {

    // storing input from user in variables
    $GID = mysqli_real_escape_string($db, $_POST['GID']);
    $request= "Weeding";

    // field should not be empty
    if (empty($GID)) {
        array_push($errors, "Garden ID is required");
    }
    
    if (count($errors) == 0) {
        
        $query = "SELECT * FROM garden WHERE GID = '$GID' ";
        $results = mysqli_query($db, $query);
            
        if (mysqli_num_rows($results) == 1) {

            $row = mysqli_fetch_assoc($results);
            $query2 = "SELECT * FROM requests WHERE GID = '$GID' AND work = '$request' ";
            $results2 = mysqli_query($db, $query2);
            $query12 = "SELECT * FROM `roster` WHERE GID = '$GID' AND work = '$request' and Date_of_work> Current_date() ";
            $results12 = mysqli_query($db, $query12);
            if(($results12 === false || mysqli_num_rows($results12) ==0) && ($results2 === false || mysqli_num_rows($results2) ==0 )) {
                $query3 = "INSERT INTO requests (GID, work) VALUES ( '$GID', '$request') ";
                $check = mysqli_query($db, $query3);
                            
                $_SESSION['success1'] = "Request has been made to Landscaping Department.";

                header('location: requestconfirmed.php');
            }
            else {
                array_push($errors, "Request is either already registered/ or under work!");
            }
        } else {
            array_push($errors, "Garden ID not in database!");
        }
    }
}






// Fertilizing Request
if (isset($_POST['FRT'])) {

    // storing input from user in variables
    $GID = mysqli_real_escape_string($db, $_POST['GID']);
    $request= "Fertilizing";

    // field should not be empty
    if (empty($GID)) {
        array_push($errors, "Garden ID is required");
    }
    
    if (count($errors) == 0) {
        
        $query = "SELECT * FROM garden WHERE GID = '$GID' ";
        $results = mysqli_query($db, $query);
            
        if (mysqli_num_rows($results) == 1) {

            $row = mysqli_fetch_assoc($results);
            $query2 = "SELECT * FROM requests WHERE GID = '$GID' AND work = '$request' ";
            $results2 = mysqli_query($db, $query2);
            $query12 = "SELECT * FROM `roster` WHERE GID = '$GID' AND work = '$request' and Date_of_work> Current_date() ";
            $results12 = mysqli_query($db, $query12);
            if(($results12 === false || mysqli_num_rows($results12) ==0) && ($results2 === false || mysqli_num_rows($results2) ==0 )) {
                $query3 = "INSERT INTO requests (GID, work) VALUES ( '$GID', '$request') ";
                $check = mysqli_query($db, $query3);
                            
                $_SESSION['success1'] = "Request has been made to Landscaping Department.";

                header('location: requestconfirmed.php');
            }
            else {
                array_push($errors, "Request is either already registered/ or under work!");
            }
        } else {
            array_push($errors, "Garden ID not in database!");
        }
    }
}






// Grass Trimming Request
if (isset($_POST['GTR'])) {

    // storing input from user in variables
    $GID = mysqli_real_escape_string($db, $_POST['GID']);
    $request= "Grass Trimming";

    // field should not be empty
    if (empty($GID)) {
        array_push($errors, "Garden ID is required");
    }
    
    if (count($errors) == 0) {
        
        $query = "SELECT * FROM garden WHERE GID = '$GID' ";
        $results = mysqli_query($db, $query);
            
        if (mysqli_num_rows($results) == 1) {

            $row = mysqli_fetch_assoc($results);
            $query2 = "SELECT * FROM requests WHERE GID = '$GID' AND work = '$request' ";
            $results2 = mysqli_query($db, $query2);
            $query12 = "SELECT * FROM `roster` WHERE GID = '$GID' AND work = '$request' and Date_of_work> Current_date() ";
            $results12 = mysqli_query($db, $query12);
            if(($results12 === false || mysqli_num_rows($results12) ==0) && ($results2 === false || mysqli_num_rows($results2) ==0 )) {
                $query3 = "INSERT INTO requests (GID, work) VALUES ( '$GID', '$request') ";
                $check = mysqli_query($db, $query3);
                            
                $_SESSION['success1'] = "Request has been made to Landscaping Department.";

                header('location: requestconfirmed.php');
            }
            else {
                array_push($errors, "Request is either already registered/ or under work!");
            }
        } else {
            array_push($errors, "Garden ID not in database!");
        }
    }
}






// Hedge Trimming Request
if (isset($_POST['HTR'])) {

    // storing input from user in variables
    $GID = mysqli_real_escape_string($db, $_POST['GID']);
    $request= "Hedge Trimming";

    // field should not be empty
    if (empty($GID)) {
        array_push($errors, "Garden ID is required");
    }
    
    if (count($errors) == 0) {
        
        $query = "SELECT * FROM garden WHERE GID = '$GID' ";
        $results = mysqli_query($db, $query);
            
        if (mysqli_num_rows($results) == 1) {

            $row = mysqli_fetch_assoc($results);
            $query2 = "SELECT * FROM requests WHERE GID = '$GID' AND work = '$request' ";
            $results2 = mysqli_query($db, $query2);
            $query12 = "SELECT * FROM `roster` WHERE GID = '$GID' AND work = '$request' and Date_of_work> Current_date() ";
            $results12 = mysqli_query($db, $query12);
            if(($results12 === false || mysqli_num_rows($results12) ==0) && ($results2 === false || mysqli_num_rows($results2) ==0 )) {
                $query3 = "INSERT INTO requests (GID, work) VALUES ( '$GID', '$request') ";
                $check = mysqli_query($db, $query3);
                            
                $_SESSION['success1'] = "Request has been made to Landscaping Department.";

                header('location: requestconfirmed.php');
            }
            else {
                array_push($errors, "Request is either already registered/ or under work!");
            }
        } else {
            array_push($errors, "Garden ID not in database!");
        }
    }
}


?>