<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // تفعيل الأخطاء لرؤية المشاكل إن وجدت
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // استلام المدخلات بأمان
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($_POST['message']);

    // البريد الذي سيتم الإرسال إليه
    $to = "ibrahim.elfouki24@gmail.com";
    $subject = "رسالة جديدة من $name";
    
    // إعداد ترويسات البريد
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // **التحقق من المدخلات**
    if (empty($name) || empty($email) || empty($message)) {
        header("Location: index.html?status=error_empty");
        exit();
    }

    // **التحقق من صحة البريد الإلكتروني**
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: index.html?status=error_email");
        exit();
    }

    // **إرسال البريد**
    if (mail($to, $subject, $message, $headers)) {
        header("Location: index.html?status=success");
        exit();
    } else {
        header("Location: index.html?status=error_send");
        exit();
    }
}
?>
