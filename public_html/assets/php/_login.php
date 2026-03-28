<?php
session_start();
header('Content-Type: application/json');

// Ensure the path to db.php is correct relative to this file
require_once 'db.php'; 

$response = ["success" => false, "message" => "Login failed."];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($email) || empty($password)) {
        $response["message"] = "Email and password are required.";
        echo json_encode($response);
        exit;
    }

    try {
        // Use the $pdo object provided by db.php
        $stmt = $pdo->prepare("SELECT user_id, full_name, password FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];

            $response["success"] = true;
            $response["message"] = "Login successful!";
            $response["user_name"] = $user['full_name'];
        } else {
            $response["message"] = "Invalid email or password.";
        }
    } catch (PDOException $e) {
        // This catches database errors and prevents a generic 500 crash
        $response["message"] = "Database error: " . $e->getMessage();
    }
}

echo json_encode($response);
?>