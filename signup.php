<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize user inputs
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Database connection parameters
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "sign up";

    // Create a new database connection
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    // Check for database connection errors
    if ($conn->connect_error) {
        die('Could not connect to the database. Please try again later.');
    } else {
        // Insert new record
        $INSERT = "INSERT INTO `signup` (`username`,`email`,`password`)VALUES(?,?,?)";
        $stmt = $conn->prepare($INSERT);

        if ($stmt) {
            $stmt->bind_param("sss", $username,$email, $password);
            $stmt->execute();
            echo "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Thank You</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f2f2f2;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        margin: 0;
                    }
            
                    .thank-you-container {
                        text-align: center;
                        background-color: #ffffff;
                        padding: 20px;
                        border-radius: 10px;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                    }
            
                    h1 {
                        color: #333;
                    }
            
                    p {
                        color: #666;
                    }
            
                    a {
                        text-decoration: none;
                        color: #007BFF;
                    }
                </style>
            </head>
            <body>
                <div class='thank-you-container'>
                    <h1>Thank You for Signing Up/Logging In!</h1>
                    <p>Your account has been successfully created/logged in.</p>
                </div>
            </body>
            </html>";

            $stmt->close();
            $conn->close();
        } else {
            echo "Submission Error: " . $conn->error;
        }
    }
} else {
    echo "Invalid Request";
}
?>