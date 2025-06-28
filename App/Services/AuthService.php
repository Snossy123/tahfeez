<?php
require_once '../Repositories/AuthRepository.php';

function login()
{
	$username = $_POST['username'] ?? '';
	$password = $_POST['password'] ?? '';
	$role = $_POST['role'] ?? '';

	$user = checkData($username, $password, $role);

	if ($user) {
	    $_SESSION['user'] = $user;
	    header("Location: dashboard.php");
	    exit;
	} else {
	    return "Wrong Email Or Password ....";
	}
}