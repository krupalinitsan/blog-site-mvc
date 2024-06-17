<?php
require_once 'app/models/Common.php';
class User extends Common
{
    // method for user login
    public function loginUser($email, $password)
    {
        $pass = trim(md5($password));

        $sql = "SELECT * FROM `users` WHERE email='$email' AND password='$pass'";
        return $this->connection->query($sql)->fetch_assoc();
    }
}
?>