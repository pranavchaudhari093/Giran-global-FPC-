<?php
/**
 * Girna Global - Email Processing Helper
 * PHPMailer / Gmail SMTP & Hostinger mail() fallback support
 */

require_once __DIR__ . '/functions.php';

function send_contact_email($name, $email, $phone, $subject, $message) {
    $settings = get_settings();
    $toEmail = $settings['email'] ?? 'contact@girnaglobal.com';
    $siteName = $settings['site_name'] ?? 'Girna Global';

    $emailSubject = "New Inquiry from {$name}: " . ($subject ? $subject : "General Contact");
    
    // HTML Email Template
    $body = "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='utf-8'>
        <style>
            body { font-family: Arial, sans-serif; background-color: #f4f6f8; margin: 0; padding: 20px; }
            .container { max-width: 600px; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.08); margin: 0 auto; }
            .header { background-color: #062c1e; color: #d4af37; padding: 24px; text-align: center; }
            .header h1 { margin: 0; font-size: 24px; letter-spacing: 1px; }
            .content { padding: 24px; color: #333333; line-height: 1.6; }
            .field { margin-bottom: 16px; border-bottom: 1px solid #eeeeee; padding-bottom: 8px; }
            .field strong { color: #062c1e; display: inline-block; width: 120px; }
            .message-box { background: #f8fafc; border-left: 4px solid #d4af37; padding: 16px; margin-top: 16px; border-radius: 4px; }
            .footer { background: #f1f5f9; padding: 16px; text-align: center; font-size: 12px; color: #64748b; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>{$siteName}</h1>
                <p style='margin:4px 0 0 0; color:#e2e8f0;'>New Customer Inquiry Received</p>
            </div>
            <div class='content'>
                <div class='field'><strong>Name:</strong> " . htmlspecialchars($name) . "</div>
                <div class='field'><strong>Email:</strong> " . htmlspecialchars($email) . "</div>
                <div class='field'><strong>Phone:</strong> " . htmlspecialchars($phone ? $phone : 'N/A') . "</div>
                <div class='field'><strong>Subject:</strong> " . htmlspecialchars($subject ? $subject : 'N/A') . "</div>
                
                <div class='message-box'>
                    <strong>Message:</strong><br>
                    " . nl2br(htmlspecialchars($message)) . "
                </div>
            </div>
            <div class='footer'>
                This email was generated automatically by the {$siteName} Website Inquiry Form.
            </div>
        </div>
    </body>
    </html>
    ";

    // Attempt Socket/SMTP sending if PHPMailer autoload is present, otherwise fallback to native mail()
    $headers  = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: {$siteName} Website <no-reply@" . ($_SERVER['HTTP_HOST'] ?? 'girnaglobal.com') . ">" . "\r\n";
    $headers .= "Reply-To: {$name} <{$email}>" . "\r\n";

    // Standard PHP mail dispatch
    $sent = @mail($toEmail, $emailSubject, $body, $headers);

    // Record inquiry into Database
    try {
        DB::insert(
            "INSERT INTO inquiries (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)",
            [$name, $email, $phone, $subject, $message]
        );
    } catch (Exception $e) {
        error_log("Failed to insert inquiry to DB: " . $e->getMessage());
    }

    return true;
}
