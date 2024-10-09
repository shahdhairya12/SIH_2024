<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $newPassword = $_POST['new_password'];

    if (empty($email) || empty($newPassword)) {
        echo "Please fill in all fields.";
        exit;
    }

    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "sign up";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die('Could not connect to the database. Please try again later.');
    }

    $SELECT = "SELECT * FROM signup WHERE email = ?";
    $stmt = $conn->prepare($SELECT);

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $sql = "UPDATE signup SET password = ? WHERE email = ?";
            $stmtUpdate = $conn->prepare($sql);
            $stmtUpdate->bind_param("ss", $newPassword, $email);
            if ($stmtUpdate->execute()) {
                echo "<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Welcome Back</title>
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
                
                        .welcome-container {
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
                    <div class='welcome-container'>
                        <h1>Welcome!</h1>
                        <p>Your Password has been updated succesfully</p>
                    </div>
                </body>
                </html>";
            } else {
                echo "Error updating password: " . $conn->error;
            }
            $stmtUpdate->close();
        } else {
            echo "No user found with that email.";
        }
        $stmt->close();
    } else {
        echo "Error preparing the statement: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid Request";
}
?>