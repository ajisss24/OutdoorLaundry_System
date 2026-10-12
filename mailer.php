<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Mengirimkan email reset password menggunakan PHPMailer via Gmail SMTP.
 *
 * @param string $to_email Alamat email penerima
 * @param string $to_name Nama penerima
 * @param string $reset_link Link URL reset password dengan token
 * @return array ['success' => bool, 'message' => string]
 */
function sendResetPasswordEmail($to_email, $to_name, $reset_link) {
    $configFile = __DIR__ . '/mail_config.php';
    if (!file_exists($configFile)) {
        return [
            'success' => false,
            'message' => 'File konfigurasi mail_config.php tidak ditemukan.'
        ];
    }

    $config = require $configFile;

    // Periksa apakah Sandi Aplikasi (App Password) sudah diisi
    if (empty($config['smtp_pass'])) {
        return [
            'success' => false,
            'configured' => false,
            'message' => 'Sandi Aplikasi (Google App Password 16 karakter) belum dikonfigurasi di mail_config.php.'
        ];
    }

    $mail = new PHPMailer(true);

    try {
        // Konfigurasi Server SMTP
        $mail->isSMTP();
        $mail->Host       = $config['smtp_host'];
        $mail->SMTPAuth   = $config['smtp_auth'];
        $mail->Username   = $config['smtp_user'];
        $mail->Password   = $config['smtp_pass'];
        $mail->SMTPSecure = ($config['smtp_secure'] === 'ssl') ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $config['smtp_port'];
        $mail->CharSet    = 'UTF-8';

        // Pengirim & Penerima
        $mail->setFrom($config['from_email'], $config['from_name']);
        $mail->addAddress($to_email, $to_name);
        $mail->addReplyTo($config['from_email'], $config['from_name']);

        // Konten Email
        $mail->isHTML(true);
        $mail->Subject = 'Permintaan Pemulihan Kata Sandi - Outdoor Laundry';

        // Template Email HTML Modern & Elegan
        $mail->Body = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <style>
                body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f5f9; margin: 0; padding: 0; color: #334155; }
                .wrapper { max-width: 580px; margin: 30px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; }
                .header { background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%); padding: 36px 30px; text-align: center; color: #ffffff; }
                .header h1 { margin: 0; font-size: 24px; font-weight: 700; letter-spacing: -0.5px; }
                .header p { margin: 6px 0 0; font-size: 13px; opacity: 0.9; }
                .content { padding: 32px 30px; line-height: 1.6; }
                .greeting { font-size: 16px; font-weight: 600; color: #0f172a; margin-bottom: 12px; }
                .btn-container { text-align: center; margin: 30px 0; }
                .btn-reset { display: inline-block; background-color: #0ea5e9; color: #ffffff !important; font-size: 14px; font-weight: 600; text-decoration: none; padding: 14px 32px; border-radius: 50px; box-shadow: 0 4px 12px rgba(14, 165, 233, 0.35); }
                .note-box { background-color: #f8fafc; border-left: 4px solid #0ea5e9; padding: 12px 16px; border-radius: 6px; font-size: 12px; color: #64748b; margin: 24px 0; }
                .link-alt { font-size: 11px; word-break: break-all; color: #0284c7; }
                .footer { background-color: #f8fafc; padding: 20px 30px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #f1f5f9; }
            </style>
        </head>
        <body>
            <div class='wrapper'>
                <div class='header'>
                    <h1>Outdoor Laundry</h1>
                    <p>Layanan Pembersihan Perlengkapan Outdoor Profesional</p>
                </div>
                <div class='content'>
                    <div class='greeting'>Halo, " . htmlspecialchars($to_name) . "</div>
                    <p>Kami menerima permintaan untuk mereset kata sandi akun Outdoor Laundry Anda. Silakan klik tombol di bawah ini untuk membuat password baru:</p>
                    
                    <div class='btn-container'>
                        <a href='{$reset_link}' class='btn-reset' target='_blank'>Reset Kata Sandi Saya</a>
                    </div>
                    
                    <div class='note-box'>
                        ⏱️ <strong>Batas Waktu:</strong> Tautan ini hanya berlaku selama <strong>1 jam</strong> dari sekarang.<br>
                        🔒 Jika Anda tidak merasa melakukan permintaan ini, silakan abaikan email ini. Akun Anda tetap aman.
                    </div>

                    <p style='font-size: 12px; color: #64748b; margin-top: 24px;'>Jika tombol di atas tidak dapat diklik, salin dan tempelkan tautan berikut ke browser Anda:</p>
                    <p class='link-alt'><a href='{$reset_link}'>{$reset_link}</a></p>
                </div>
                <div class='footer'>
                    &copy; " . date('Y') . " Outdoor Laundry. Hak Cipta Dilindungi.<br>
                    Email otomatis, mohon tidak membalas langsung ke email ini.
                </div>
            </div>
        </body>
        </html>
        ";

        // Plain text version
        $mail->AltBody = "Halo {$to_name},\n\n"
            . "Kami menerima permintaan untuk mereset kata sandi akun Outdoor Laundry Anda.\n"
            . "Silakan buka tautan berikut untuk membuat password baru (berlaku 1 jam):\n\n"
            . "{$reset_link}\n\n"
            . "Jika Anda tidak meminta reset password, abaikan email ini.\n\n"
            . "Salam,\nOutdoor Laundry Team";

        $mail->send();

        return [
            'success' => true,
            'configured' => true,
            'message' => 'Email pemulihan kata sandi berhasil dikirim ke ' . $to_email
        ];
    } catch (Exception $e) {
        return [
            'success' => false,
            'configured' => true,
            'message' => 'Gagal mengirim email: ' . $mail->ErrorInfo
        ];
    }
}
