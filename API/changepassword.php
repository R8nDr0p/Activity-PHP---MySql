<?php
session_start();
require_once 'config.php';

class ChangePasswordEndpoint
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function changePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];


                $oldPassword = $_POST['old_password'];
                $newPassword = $_POST['new_password'];

                $sql = "SELECT password FROM users WHERE id = '$userId'";
                $result = mysqli_query($this->conn, $sql);

                if (my_sqli_num_rows($result) === 1) {
                    $row = mysqli_fetch_assoc($result);
                    $currentPassword = $row['password'];

                    if (password_verify($oldPassword, $currentPassword)) {
                        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                        $updateSql = "Update users SET password = '$hashedPassword' WHERE id = '$userId'";
                    }
                }
            }
        }
    }
}
