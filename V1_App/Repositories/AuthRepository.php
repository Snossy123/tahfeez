<?php
require_once '../Config/db.php';

function checkData(string $username, string $password, string $role)
{
	global $pdo;
	
	$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND role = ?");
	$stmt->execute([$username, $role]);
	$user = $stmt->fetch();
	return $user && password_verify($password, $user['password']) ? $user : null;
}