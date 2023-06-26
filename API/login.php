<?php
session_start();
require_once 'config.php';

class LoginEndpoint
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function loginUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $results = mysqli_query($this->conn, $sql);

            if (mysqli_num_rows($results) === 1) {
                $row = mysqli_fetch_assoc($results);
                if (password_verify($password, $row['password'])) {
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['email'] = $row['email'];
                    echo "Login successfully logged";
                } else {
                    echo "Invalid email or password";
                }
            } else {
                echo "Invalid Request";
            }
        }
    }
}

$loginEndpoint = new LoginEndpoint($conn);
$loginEndpoint->loginUser();
