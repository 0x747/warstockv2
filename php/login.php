<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/form.css">
    <link rel="icon" type="image/x-icon" href="../assets/icons/favicon.ico"/>
    <title>Login - Warstock</title>
</head>
<body>
    <div class="navbar" id="navbar">
        <div class="logo">
            <a href="../index.html" class="logo">[Warstock]</a>
        </div>
    </div> 
        <form action="login.php" method="post">
            <h2>Sign In</h2>
            <input type="text" name="username" placeholder="Email" class="textbox" autocomplete="off" style="width: 525px;"><br><br>
            <input type="password" name="password" placeholder="Password" class="textbox" style="width: 525px;" spellcheck="false"><br>
            <?php 
                require "db_essentials.php";

                if(isset($_POST["signin"])) {
                    $username = $_POST["username"];
                    $password = $_POST["password"];

                    $sql = "SELECT * FROM `user_credentials` WHERE `email` = '$username' && `password` = '$password' && `verified` = 1";
                    $result = $conn -> query($sql);

                    if($result -> num_rows > 0) {
                        echo "<p class='error-message' style='background-color: rgb(0, 180, 0); margin-top: 7px;'>Success.</p>";
                    } else {
                        echo "<p class='error-message' style='background-color: rgb(180, 0, 0); margin-top: 7px;'>Email or password is incorrect, or check your email to verify.</p>";
                    }
                }
            ?>
            <a href="forgot_password.php" style="color: rgb(35, 56, 252); text-decoration: none;">Forgot Password?</a><br>
            <input type="submit" name="signin" value="Sign In" class="submitbutton" style="margin-top: 25px;"><br>
        </form>
        <script defer src="../scripts/hide_navbar.js"></script>
</body>
</html>

<?php 

?>