<?php
require 'PHPMailer/PHPMailer/PHPMailerAutoload.php';

header('Content-Type: application/json'); // Ensure response is JSON
if (isset($_POST['pdf'])) {
    $base64Pdf = $_POST['pdf'];
    $pdfData = base64_decode($base64Pdf);

    $tempPdfPath = 'temp_application.pdf';
    file_put_contents($tempPdfPath, $pdfData);

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'movesketsi@gmail.com';
    $mail->Password = 'tkhjmdhoevlwfpxx';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('movesketsi@gmail.com', 'Mailer');
    $mail->addAddress('blacksugarbakery7@gmail.com', 'User');
    $mail->addAttachment($tempPdfPath);
    $mail->isHTML(true);
    $mail->Subject = 'Application PDF';
    $mail->Body = 'Please find the attached application form.';

    try {
        if ($mail->send()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $mail->ErrorInfo]);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No PDF data received.']);
}
?>
