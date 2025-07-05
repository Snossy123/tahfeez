<?php
// الصورة الخاصة بالمستخدم (لو كانت موجودة في الجلسة مثلاً)
$userImage = $_SESSION['user']['image'] ?? null;

// رابط الصورة الافتراضية
$defaultImage = 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y';

// استخدام الصورة الخاصة إن وجدت، وإلا الصورة الافتراضية
$imageToShow = $userImage ?: $defaultImage;
?>