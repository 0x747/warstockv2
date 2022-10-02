<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" tyoe="text/css" href="../css/form.css">
    <link rel="icon" type="image/x-icon" href="../assets/icons/favicon.ico"/>
    <title>Forgot Password - Warstock</title>
</head>
<body>
    <div class="navbar" id="navbar">
        <div class="logo">
            <a href="../index.html" class="logo">[Warstock]</a>
        </div>
    </div> 
    <form action="forgot_password.php" method="post">
        <h2>Forgot Password</h2>
        <input type="text" name="email" placeholder="Email" class="textbox" autocomplete="off" style="width: 525px;"><br>
        <?php 
                session_start();
                require "db_essentials.php";

                if(isset($_POST["sendemail"])) {
                    $email = $_POST["email"];
                    $_SESSION["forgotemail"] = $email;

                    $sql = "SELECT * FROM `user_credentials` WHERE `email` = '$email' && `verified` = 1";
                    $result = $conn -> query($sql);

                    if($result -> num_rows > 0) {
                        if(is_email_valid($email)) {
                            $code = rand(100000, 999999);
                            $expires = time() + 120;
                            $subject = "Password reset verification code";
                            $message = "Your verification code is<br><h1>$code</h1>"; 

                            $sql = "INSERT INTO `forgot_password` (`email`, `code`, `expires`) VALUES ('$email', '$code', $expires)";

                            if($conn -> query($sql)) {
                                send_email($email, $subject, $message);
                                header("Location: reset_password.php");
                                //echo "<p class='error-message' style='background-color: rgb(0, 180, 0); margin-top: 7px;'>A verification code and link has been sent to " . $email . "</p>";
                            }
                        }
                    } else {
                        echo "<p class='error-message' style='background-color: rgb(180, 0, 0); margin-top: 7px;'>Email does not exist. Please use a different email or verify.</p>";
                    }
                }
            ?>
        <input type="submit" name="sendemail" value="Send Email" class="submitbutton" style="margin-top: 25px;"><br>
    </form>
</body>
</html>