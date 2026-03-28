<?php
header('Content-Type: application/json');
require_once 'db.php';

$response = ["success" => false, "message" => "An error occurred."];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $group_id = isset($_POST['group_id']) ? (int)$_POST['group_id'] : 0;
    $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;

    if ($group_id > 0 && $user_id > 0) {
        // Start transaction
        $conn->begin_transaction();

        try {
            // 1. Try to record the membership
            // This will fail if the user_id + group_id combination already exists
            $stmt1 = $conn->prepare("INSERT INTO group_members (group_id, user_id) VALUES (?, ?)");
            $stmt1->bind_param("ii", $group_id, $user_id);
            $stmt1->execute();

            // 2. Increment count and update is_paid if threshold is met
            // We use a single query for efficiency
            $stmt2 = $conn->prepare("UPDATE groups 
                                    SET current_user_count = current_user_count + 1,
                                        is_paid = IF(current_user_count + 1 >= max_users, 1, 0)
                                    WHERE id = ?");
            $stmt2->bind_param("i", $group_id);
            $stmt2->execute();

            // If both succeeded, save changes
            $conn->commit();
            $response["success"] = true;
            $response["message"] = "Success! You have joined the group.";

        } catch (mysqli_sql_exception $e) {
            // Rollback if duplicate entry (error code 1062) or other error
            $conn->rollback();
            
            if ($e->getCode() == 1062) {
                $response["message"] = "This person has already paid";
            } else {
                $response["message"] = "Database error: " . $e->getMessage();
            }
        }

        if (isset($stmt1)) $stmt1->close();
        if (isset($stmt2)) $stmt2->close();
    } else {
        $response["message"] = "Invalid group or user data.";
    }
}

$conn->close();
echo json_encode($response);
?>