<?php

require_once 'config.php';

class RegisterEndpoint
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function registerUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // retrieve the data
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email = $_POST['email'];
            $birthdate = $_POST['birthdate'];
            $password = $_POST['password'];


            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (firstname,lastname,email,birthdate,password) 
            VALUES ('$firstname','$lastname', '$email','$birthdate', '$hashedPassword')";

            if (mysqli_query($this->conn, $sql)) {
                echo "Registration successful!";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
            }
        } else {
            echo "Invalid request";
        }
    }
}


//

$registerEndpoint = new RegisterEndpoint($conn);
$registerEndpoint->registerUser();
