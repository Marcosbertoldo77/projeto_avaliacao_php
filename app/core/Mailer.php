<?php

class Mailer
{
    // Simple wrapper using PHP mail(). Ensure server is configured to send mail.
    public static function send(string $to, string $subject, string $message, string $from = 'no-reply@localhost'): bool
    {
        $headers = "From: " . $from . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        return mail($to, $subject, $message, $headers);
    }
}
