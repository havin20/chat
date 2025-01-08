<?php

$main_site = "https://tpars.yekparsipm.ir/chat/";
$fallback_url = "https://some-proxy-or-other-method.com"; // آدرس جایگزین (پروکسی، صفحه آموزش، و غیره)

// بررسی اتصال به سایت اصلی با cURL
$ch = curl_init($main_site);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // زمان انتظار برای اتصال (5 ثانیه)
curl_setopt($ch, CURLOPT_TIMEOUT, 10); // حداکثر زمان اجرای cURL (10 ثانیه)
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // برای رفع مشکلات احتمالی SSL (با احتیاط استفاده شود)

$response = curl_exec($ch);

if (curl_errno($ch)) {
    // خطایی در اتصال رخ داده است (احتمالاً فیلتر است)
   // echo 'Curl error: ' . curl_error($ch); // برای دیباگ کردن خطاها (در حالت production حذف شود)
    header("Location: " . $fallback_url);
    exit();
}
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode == 200) {
    // سایت اصلی در دسترس است
    header("Location: " . $main_site);
    exit();
} else {
     // کد وضعیت 200 نیست (احتمالاً فیلتر است یا مشکل دیگری وجود دارد)
    header("Location: " . $fallback_url);
    exit();

}
?>
