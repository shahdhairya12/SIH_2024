<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = $_POST['email'];
    $password = $_POST['password'];

     if (empty($email) || empty($password)) {
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
    } else {
    
        $SELECT = "SELECT * FROM signup WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($SELECT);

        if ($stmt) {
            $stmt->bind_param("ss", $email, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                
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
                        <h1>Welcome Back!</h1>
                        <p>You have successfully logged in.</p>
                    </div>
                </body>
                </html>";
            } else {
                
                echo "<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Login Failed</title>
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
                
                        .error-container {
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
                    <div class='error-container'>
                        <h1>Login Failed</h1>
                        <p>Invalid email or password. Please try again.</p>
                    </div>
                </body>
                </html>";
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "Error preparing the statement: " . $conn->error;
        }
    }
} else {
    echo "Invalid Request";
}
?>
