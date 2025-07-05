<?php
session_start();
require_once '../Services/AuthService.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error = login();
}
require_once '../Views/AuthView.php';
