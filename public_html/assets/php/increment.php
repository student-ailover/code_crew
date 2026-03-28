<?php
header('Content-Type: application/json');
require_once 'db.php';

$response = ["success" => false, "message" => "An error occurred."];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
    $expense_id = isset($_POST['expense_id']) ? (int)$_POST['expense_id'] : 0;
    $group_id = isset($_POST['group_id']) ? (int)$_POST['group_id'] : 0;

    if ($user_id > 0 && $expense_id > 0 && $group_id > 0) {
        // Start transaction
        $conn->begin_transaction();

        try {
            // 1. Check if the balance is already settled and update it to 1
            // We use the WHERE clause to ensure we only update if it is currently 0
            $stmt1 = $conn->prepare("UPDATE member_balances 
                                    SET is_settled = 1 
                                    WHERE user_id = ? AND expense_id = ? AND is_settled = 0");
            $stmt1->bind_param("ii", $user_id, $expense_id);
            $stmt1->execute();

            // If affected_rows is 0, it means the balance was either already settled or doesn't exist
            if ($stmt1->affected_rows === 0) {
                throw new Exception("Payment already settled or record not found.");
            }

            // 2. Increment current_user_count in the groups table
            $stmt2 = $conn->prepare("UPDATE groups 
                                    SET current_user_count = current_user_count + 1 
                                    WHERE group_id = ?");
            $stmt2->bind_param("i", $group_id);
            $stmt2->execute();

            // 3. Check if current_user_count >= max_users and update is_paid to 1
            $stmt3 = $conn->prepare("UPDATE groups 
                                    SET is_paid = 1 
                                    WHERE group_id = ? AND current_user_count >= max_users");
            $stmt3->bind_param("i", $group_id);
            $stmt3->execute();

            // Commit all changes
            $conn->commit();
            
            $response["success"] = true;
            $response["message"] = "Payment recorded! Group status updated.";

        } catch (Exception $e) {
            // Rollback if any step fails or if already settled
            $conn->rollback();
            $response["message"] = $e->getMessage();
        }

        if (isset($stmt1)) $stmt1->close();
        if (isset($stmt2)) $stmt2->close();
        if (isset($stmt3)) $stmt3->close();
    } else {
        $response["message"] = "Missing or invalid IDs.";
    }
}

$conn->close();
echo json_encode($response);
?>