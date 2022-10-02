<?php 
    session_start();
    require "db_essentials.php";
    
    $code_error = "";

    if($conn -> connect_error) {
        die('could not connect');
    }

    if(isset($_POST["register"])) {
        $name = $_POST["fname"] . " " . $_POST["lname"];
        $email = $_POST["email"];
        $_SESSION["email"] = $email;
        $password = $_POST["password"];
        $dob = $_POST["day"] . "/" . $_POST["month"] . "/" . $_POST["year"];
        $code = rand(100000, 999999);

        $sql = "INSERT INTO `user_credentials` (`NAME`, `EMAIL`, `PASSWORD`, `DOB`, `VERIFIED`, `CODE`) VALUES ('$name', '$email', '$password', '$dob', 0, $code)";


        // Check if record isn't a duplicate. 
        if(!is_record_duplicate(($email)) && $conn -> query($sql)) {
            
            if(is_email_valid($email)) {
                $subject = "Verify your Warstock account.";
                $message = "Your verification code is<br><h1>". $code . "</h1>";
                echo("sending");
                send_email($email, $subject, $message);
            }
        }
    }

    if(isset($_POST["verify"])) {
        $code = $_POST["code"];
        $session_email = $_SESSION["email"];
        
        $sql = "SELECT * FROM `user_credentials` WHERE `CODE` = '$code' && `email` = '$session_email' && `verified` = 0";
        $result = $conn -> query($sql);

        if($result -> num_rows > 0) {
            $sql = "UPDATE `user_credentials` SET `VERIFIED` = 1 WHERE `code` = '$code' && `email` = '$email'";  
            if($conn -> query($sql)) {
                $code_error = "";
                header("Location: login.php");
            }
        }
        else {
            $code_error = "<p class='error-message' style='color: white; background-color: rgb(180,0,0);'>Incorrect code or email is already verified.</p>";
        }
    }

    echo '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="../css/form.css" type="text/css">
                <link rel="icon" type="image/x-icon" href="../assets/icons/favicon.ico"/>
                <title>Verify Account - Warstock</title>
            </head>
            <body>
                <div class="navbar" id="navbar">
                    <div class="logo">
                        <a href="../index.html" class="logo">[Warstock]</a>
                    </div>
                </div> 
                <form action="verify_new_user.php" method="post">
                    <h2>Verify your email</h2>
                    <label for="otp" style="font-size: 20px;">Enter the verification code sent to your email</label><br>
                    <input type="text" name="code"  placeholder="Verification Code" class="textbox" autocomplete="off" style="width: 390px; margin-top: 5px;">
                    ' . $code_error . '
                    <br><br><input type="submit" value="Verify" name="verify" class="submitbutton">
                </form>
                <script defer src="../scripts/hide_navbar.js"></script>
            </body>
            </html>';
    
?>