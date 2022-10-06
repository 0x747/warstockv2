<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "warstock";

    $conn = new mysqli($servername, $username, $password, $dbname);

    function send_email($email, $subject, $message) {
        $headers = "From: Warstock <youremail@example.com>\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        mail($email, $subject, $message, $headers);
    }

    function is_email_valid($email) {
        
        global $conn;

        $sql = "SELECT `email` FROM `user_credentials` WHERE `email` = '$email'";
        $result = $conn -> query($sql);

        if($result -> num_rows > 0) {
            return true;
        }

        return false;
    }

    function is_record_duplicate($email) {
        
        global $conn;

        $sql = "SELECT * FROM `user_credentials` WHERE `email` = '$email'";
        $result = $conn -> query($sql);

        if($result -> num_rows > 0) {
            return true; // Record is a duplicate.
        }

        return false; // Record is not a duplicate. 
    }
?>
