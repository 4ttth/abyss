<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/vendor/autoload.php'; // Autoload PHPMailer

require_once 'dbh.inc.php'; // Database connection

function sendEmailToSquad($pdo, $squadID, $subject, $body) {
    // Fetch the email address of the target squad
    $stmt = $pdo->prepare("SELECT Email_Address FROM tbl_useraccount WHERE Squad_ID = ?");
    $stmt->execute([$squadID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result || empty($result['Email_Address'])) {
        throw new Exception("Email address not found for Squad_ID: $squadID");
    }

    $emailAddress = $result['Email_Address'];

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'abyssscrimmagesystem@gmail.com'; // Replace with your email
        $mail->Password = 'bogy swxm vvpr dkgu'; // Replace with your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('abyssscrimmagesystem@gmail.com', 'ABYSS Scrimmage System'); // Replace with your email and name
        $mail->addAddress($emailAddress); // Target squad's email address

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        // Send the email
        $mail->send();
        return true;
    } catch (Exception $e) {
        throw new Exception("Email could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}