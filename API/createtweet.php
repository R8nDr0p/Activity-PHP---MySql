<?php
session_start();
require_once 'config.php';

class CreateTweetEndpoint {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function createTweet() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if the user is logged in
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];
                $content = $_POST['content'];

                // Insert the tweet into the database
                $sql = "INSERT INTO tweets (content, date_tweeted, user_id) VALUES ('$content', NOW(), '$userId')";

                if (mysqli_query($this->conn, $sql)) {
                    echo "Tweet created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
                }
            } else {
                echo "User not logged in";
            }
        } else {
            echo "Invalid request";
        }
    }
}

$createTweetEndpoint = new CreateTweetEndpoint($conn);
$createTweetEndpoint->createTweet();
