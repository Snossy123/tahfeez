<?php
session_start(); // بدء الجلسة

// حذف جميع بيانات الجلسة
$_SESSION = [];

// تدمير الجلسة
session_destroy();

// إعادة التوجيه إلى صفحة تسجيل الدخول (أو أي صفحة أخرى)
header("Location: login.php");
exit;
