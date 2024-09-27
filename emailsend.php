<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST["submit"])) {
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'lahiruheshan454@gmail.com';
    $mail->Password = 'gtcktsbskbquqyly'; 
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

   
    $mail->setFrom('lahiruheshan454@gmail.com', 'Your Name'); 
   

    $mail->addAddress($_POST["email"]);
    $mail->isHTML(true);

    $mail->Subject = $_POST["subject"];
    $mail->Body = $_POST["message"];

    if ($mail->send()) {
        echo "<script>alert('Sent successfully!');
        document.location.href='';
        
        </script>";
       
    } else {
        echo "<script>alert('Something went wrong. Please try again.');</script>";
        echo 'Mailer Error: ' . $mail->ErrorInfo; // Add error message for debugging
    }
}
?>
