<?php
require_once "core/init.php";
require_once "core/no-session-allowed.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'assets/vendor/PHPMailer/src/Exception.php';
require 'assets/vendor/PHPMailer/src/PHPMailer.php';
require 'assets/vendor/PHPMailer/src/SMTP.php';


if (isset($_GET['apl'])) {
    $email = $_GET['apl'];
    if (isexist($email)) {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($link, $query);

        $data = mysqli_fetch_assoc($result);
        $validity = $data['validity'];
        if ($validity != "invalid") {
            header("Location: login.php");
        } else {
            $JSON_creds     = file_get_contents("core/mail-credentials.json");
            $credentials    = json_decode($JSON_creds, true);
            $email_address  = $credentials['creds']['email'];
            $email_password = $credentials['creds']['password'];


            $query = "SELECT * FROM users WHERE email='$email'";
            $result = mysqli_query($link, $query);
            $data = mysqli_fetch_assoc($result);
            $uniqueid = $data['uniqueid'];

            $mail           = new PHPMailer;
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->Host     = 'smtp.gmail.com';
            $mail->Port     = 587;
            $mail->Username = $email_address;
            $mail->Password = $email_password;
            $mail->setFrom($email_address);
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Co-Lab - Account Verification';
            $mail->Body    = "Click this link to activate your account : <br> " . $home . "/activation.php?apl=" . $email . "&uid=" . $uniqueid;
            if ($mail->send()) {
                header("Location: registration-successful.php?apl=" . $email);
            } else {
                echo "user already active";
            }
        }
    } else {
        header("Location: login.php");
    }
} else {
    header("Location: login.php");
}
