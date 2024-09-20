<?php

// echo "Password Recovery";
include("./dbConnection.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);
$email = $_POST["rec_email"];
$sql = "SELECT * FROM student WHERE stu_email = '$email'";
$result = $conn->query($sql);
if($result->num_rows > 0){
    $row = $result->fetch_assoc();
    $email_to = $row['stu_email'];
    $password = $row['stu_pass'];
    $body = "Your Password is: ";

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'kalilinux157@gmail.com'; // Your Gmail address
        $mail->Password = 'ysnchjgxvgyxvbad'; // Your Gmail password or app-specific password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('kalilinux157@gmail.com', 'Mailer');
        $mail->addAddress($email_to, 'User');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Recovery';
        $mail->Body    = $body.$password;
        
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}else{
    echo "We could not found any user against this email!";

}
