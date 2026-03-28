<?php
header('Content-Type: application/json');
require_once 'db.php';

$response = ["success" => false, "message" => "Failed to add expense."];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Retrieve and sanitize inputs
    $group_id        = isset($_POST['group_id']) ? (int)$_POST['group_id'] : 0;
    $paid_by_user_id = isset($_POST['paid_by_user_id']) ? (int)$_POST['paid_by_user_id'] : 0;
    $title           = isset($_POST['title']) ? trim($_POST['title']) : '';
    $total_amount    = isset($_POST['total_amount']) ? (float)$_POST['total_amount'] : 0.00;

    // Basic validation
    if ($group_id <= 0 || $paid_by_user_id <= 0 || empty($title) || $total_amount <= 0) {
        $response["message"] = "All fields are required and must be valid.";
        echo json_encode($response);
        exit;
    }

    try {
        // 2. Prepare the INSERT statement
        // Note: we skip expense_id and created_at as the DB handles them
        $stmt = $conn->prepare("INSERT INTO expenses (group_id, paid_by_user_id, title, total_amount) VALUES (?, ?, ?, ?)");
        
        // "iisd" -> integer, integer, string, double (for decimal)
        $stmt->bind_param("iisd", $group_id, $paid_by_user_id, $title, $total_amount);

        if ($stmt->execute()) {
            $response["success"] = true;
            $response["message"] = "Expense added successfully!";
            $response["expense_id"] = $stmt->insert_id; // Returns the auto-generated ID
        } else {
            $response["message"] = "Database execution error: " . $stmt->error;
        }

        $stmt->close();

    } catch (mysqli_sql_exception $e) {
        $response["message"] = "Database error: " . $e->getMessage();
    }
}

$conn->close();
echo json_encode($response);
?>