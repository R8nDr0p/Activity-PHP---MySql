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

                if (mysqli_num_rows($result) === 1) {
                    $row = mysqli_fetch_assoc($result);
                    $currentPassword = $row['password'];

                    if (password_verify($oldPassword, $currentPassword)) {
                        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                        $updateSql = "Update users SET password = '$hashedPassword' WHERE id = '$userId'";

                        if (mysqli_query($this->conn, $updateSql)) {
                            echo "Password updated Successfully";
                        } else {
                            echo "Error: " . $updateSql . "<br>" . mysqli_error($this->conn);
                        }
                    } else {
                        echo "User not found";
                    }
                } else {
                    echo "User not logged in";
                }
            } else {
                echo "Invalid request";
            }
        }
    }
}

$changePasswordEndpoint = new ChangePasswordEndpoint($conn);
$changePasswordEndpoint->changePassword();
