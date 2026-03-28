<?php
header('Content-Type: application/json');
require_once 'db.php';

$response = [
    "success" => false,
    "message" => "An unknown error occurred."
];

// Check if data was sent via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Retrieve and sanitize input data
    // Using null coalescing operator (??) to handle missing values
    $group_name = isset($_POST['group_name']) ? (int)$_POST['group_name'] : 0;
    $max_users = isset($_POST['max_users']) ? (int)$_POST['max_users'] : 0;
    $current_user_count = isset($_POST['current_user_count']) ? (int)$_POST['current_user_count'] : 0;

    // 2. Prepare the SQL statement
    // We use ? as placeholders to prevent SQL Injection
    $stmt = $conn->prepare("INSERT INTO groups (group_name, max_users, current_user_count) VALUES (?, ?, ?)");
    // 3. Bind parameters ( "ii" means two integers)
    $stmt->bind_param("siii", $group_name, $is_paid, $max_users, $current_user_count);

    // 4. Execute and check for success
    if ($stmt->execute()) {
        $response["success"] = true;
        $response["message"] = "Group created successfully!";
    } else {
        $response["success"] = false;
        $response["message"] = "Database error: " . $stmt->error;
    }

    // 5. Close statement and connection
    $stmt->close();
    $conn->close();

    
}
    echo json_encode($response);
?>