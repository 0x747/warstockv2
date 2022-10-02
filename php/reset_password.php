<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/form.css">
    <link rel="icon" type="image/x-icon" href="../assets/icons/favicon.ico"/>
    <title>Reset Password - Warstock</title>
</head>
<body>
    <div class="navbar" id="navbar">
        <div class="logo">
            <a href="../index.html" class="logo">[Warstock]</a>
        </div>
    </div> 
    <form action="reset_password.php" method="post">
        <h2>Verify code and reset password</h2>
        <input type="text" name="code"  placeholder="Verification Code" class="textbox" autocomplete="off" style="width: 500px; margin-top: 5px;"><br>
        <?php 
            session_start();
            require "db_essentials.php";
            if(isset($_POST["changepassword"]) && isset($_SESSION["forgotemail"])) {
                $code = $_POST["code"];
                $email = $_SESSION["forgotemail"];
                $new_password = $_POST["password"];
                $password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";

                $sql = "SELECT * FROM `forgot_password` WHERE `email` = '$email' && `code` = '$code'";
                $result = $conn -> query($sql);

                if($result -> num_rows > 0) {

                    $row = $result -> fetch_assoc();
                    
                    if($row["expires"] > time() && preg_match($password_regex, $new_password)) {

                        // FIX FIX FIX FIX FIX FIX FIX FIX FIX FIX FIX FIX FIX FIX.
                        $sql = "UPDATE `user_credentials` SET `password` = '$new_password' WHERE `email` = '$email' && `password` != '$new_password'"; // Does not work if passwords match.
                        
                        if($conn -> query($sql)) {
                            echo "<script>alert('Password Updated')</script>";
                        }
                    } 
                } 
                else {
                    echo "<p class='error-message' style='background-color: rgb(180, 0, 0);'>Incorrect verification code.</p>";
                }
            }
        ?>
        <input type="password" name="password" placeholder="Password" class="textbox" style="width: 500px; margin-top: 20px;" spellcheck="false">
        <?php 
            if(isset($_POST["changepassword"])) {
                $password = $_POST["password"];
                $password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";
                
                if(!preg_match($password_regex, $password)) {
                    echo "<p class='error-message' style='background-color: rgb(180, 0, 0);'>Password must be between 8-30 characters, including one uppercase,<br> one lowercase and one special character.</p>";
                }
            }
        ?>
        <br><input type="submit" name="changepassword" value="Change Password" class="submitbutton" style="margin-top: 25px;"><br>
    </form>
    <script defer src="../scripts/hide_navbar.js"></script>
</body>
</html>