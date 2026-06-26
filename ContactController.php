<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'includes/phpmailer/PHPMailer.php';
require 'includes/phpmailer/SMTP.php';
require 'includes/phpmailer/Exception.php';

class ContactController
{
    public function __construct(
        private DatabaseTable $contactTable
    ) {
    }

    // -------------------------------
    // Show Contact Page
    // -------------------------------
    public function index(): array
    {
        return [
            'template' => 'contact.html.php',
            'title' => 'Contact Us',
            'variables' => [
                'success' => false,
                'error' => null,
                'postedValues' => ['name' => '', 'email' => '', 'message' => '']
            ]
        ];
    }

    // -------------------------------
    // Handle Contact Form Submit
    // -------------------------------
    public function submit(): array
    {
        $name = trim($_POST['name'] ?? '');
        $email_raw = trim($_POST['email'] ?? '');
        $email = filter_var($email_raw, FILTER_VALIDATE_EMAIL);
        $message = trim($_POST['message'] ?? '');

        $postedValues = [
            'name' => $name,
            'email' => $email_raw,
            'message' => $message
        ];

        $error = null;
        $success = false;

        // Validation
        if (empty($name) || empty($email_raw) || empty($message)) {
            $error = "All fields are required.";
        } elseif (!$email) {
            $error = "Please enter a valid email address.";
        } else {
            try {
                // Save to database
                $this->contactTable->save([
                    'name' => $name,
                    'email' => $email,
                    'message' => $message,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                // Send Email via PHPMailer
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'worldcultureshow2026@gmail.com';
                $mail->Password = 'uqbudrtwmkfeiqad';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('mesigachena1@gmail.com', 'Website Contact');
                $mail->addAddress('worldcultureshow2026@gmail.com', 'Admin');

                $mail->isHTML(true);
                $mail->Subject = "New Contact Message from $name";
                $mail->Body = "
                    <b>Name:</b> {$name}<br>
                    <b>Email:</b> {$email}<br>
                    <b>Message:</b><br>" . nl2br(htmlspecialchars($message));

                $mail->send();
                $success = true;
                $postedValues = ['name' => '', 'email' => '', 'message' => ''];

            } catch (Exception $e) {
                $error = "Message saved, but email failed: {$mail->ErrorInfo}";
            }
        }

        return [
            'template' => 'contact.html.php',
            'title' => 'Contact Us',
            'variables' => [
                'success' => $success,
                'error' => $error,
                'postedValues' => $postedValues
            ]
        ];
    }
}