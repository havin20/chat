<?php

$main_site = "https://tpars.yekparsipm.ir/chat/";
$fallback_url = "https://yekparsi.com/unblock"; // آدرس صفحه آموزش

$ch = curl_init($main_site);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // دنبال کردن ریدایرکت‌ها
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // بررسی گواهینامه SSL (حالت امن)

$response = curl_exec($ch);

if (curl_errno($ch)) {
    $error_message = curl_error($ch);
    error_log("cURL error: " . $error_message);
    header("Location: " . $fallback_url);
    exit();
}

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode == 200) {
    header("Location: " . $main_site);
    exit();
} else {
    error_log("HTTP code: " . $httpCode); // ثبت کد وضعیت HTTP
    header("Location: " . $fallback_url);
    exit();
}
?>
