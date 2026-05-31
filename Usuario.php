<?php
require_once __DIR__ . '/../config/db.php';
class Usuario
{
private $conn;
public function __construct()
{
$this->conn = Database::getConnection();
}
public function buscarPorEmail($email)
{
$sql = "SELECT * FROM usuario WHERE email = :email LIMIT 1";
$stmt = $this->conn->prepare($sql);
$stmt->execute([':email' => $email]);
return $stmt->fetch();
}
}