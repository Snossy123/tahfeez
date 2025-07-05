<?php 
// اللغة الحالية (ar أو en)
$lang = $_GET['lang'] ?? 'ar';

// مصفوفة الترجمة
require_once __DIR__ . "/../lang/{$lang}.php";

$otherLang = ($lang === 'ar') ? 'en' : 'ar';
?>