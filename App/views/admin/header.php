<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $lang === 'ar' ? 'rtl' : 'ltr' ?>">
<head>
  <meta charset="UTF-8">
  <title><?= $t[$pageTitle] ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap<?= $lang === 'ar' ? '.rtl' : '' ?>.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Cairo', sans-serif;
      background-color: #f8f9fa;
    }
    .sidebar {
      background-color: #1c6758;
      color: #fff;
      padding: 30px 20px;
      height: 94.5vh;
    }
    .sidebar a {
      color: #fff;
      text-decoration: none;
      display: block;
      margin-bottom: 15px;
      font-weight: bold;
    }
    .sidebar a:hover {
      text-decoration: underline;
    }
    .sidebar img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50%;
      margin-bottom: 15px;
    }
    .main-content {
      padding: 30px;
    }
    .table th, .table td {
      vertical-align: middle;
    }
  </style>
</head>
<body>