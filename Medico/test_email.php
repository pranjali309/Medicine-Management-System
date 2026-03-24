<?php
require 'vendor/autoload.php'; // Ensure you have PHPMailer installed via Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Enable verbose debug output (for troubleshooting)
    $mail->SMTPDebug = 2;
    $mail->Debugoutput = 'html';

    // SMTP settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'sagarmedico29@gmail.com'; // Your Gmail
    $mail->Password = 'unzbfzjowhqqyncw'; // ⚠ Use an App Password, NOT your real password!
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Correct encryption method
    $mail->Port = 587;

    // Email headers
    $mail->setFrom('sagarmedico29@gmail.com', 'Your Name'); // Must match Username
    $mail->addAddress('hruta009@gmail.com'); // Replace with recipient email

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'PHPMailer Test';
    $mail->Body = 'This is a test email using PHPMailer.';

    // Send email
    $mail->send();
    echo '✅ Email sent successfully!';
} catch (Exception $e) {
    echo '❌ Email could not be sent. Error: ', $mail->ErrorInfo;
}
?>
