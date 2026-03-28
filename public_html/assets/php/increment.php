<?php
header('Content-Type: application/json');
require_once 'db.php'; // Provides the $pdo object

$response = ["success" => false, "message" => "An error occurred."];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Retrieve IDs from the request
    $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
    $expense_id = isset($_POST['expense_id']) ? (int)$_POST['expense_id'] : 0;
    $group_id = isset($_POST['group_id']) ? (int)$_POST['group_id'] : 0;

    if ($user_id > 0 && $expense_id > 0 && $group_id > 0) {
        // Start a PDO transaction
        $pdo->beginTransaction();

        try {
            // 2. Update member_balances only if is_settled is currently 0
            $sql1 = "UPDATE member_balances 
                     SET is_settled = 1 
                     WHERE user_id = :user_id AND expense_id = :expense_id AND is_settled = 0";
            $stmt1 = $pdo->prepare($sql1);
            $stmt1->execute([
                'user_id' => $user_id,
                'expense_id' => $expense_id
            ]);

            if ($stmt1->rowCount() === 0) {
                throw new Exception("Payment already settled or record not found.");
            }

            // 3. Increment current_user_count in the groups table
            $sql2 = "UPDATE groups 
                     SET current_user_count = current_user_count + 1 
                     WHERE group_id = :group_id";
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->execute(['group_id' => $group_id]);

            // 4. Update is_paid to 1 if the group is now full
            $sql3 = "UPDATE groups 
                     SET is_paid = 1 
                     WHERE group_id = :group_id AND current_user_count >= max_users";
            $stmt3 = $pdo->prepare($sql3);
            $stmt3->execute(['group_id' => $group_id]);

            // If all steps succeed, commit the changes
            $pdo->commit();
            
            $response["success"] = true;
            $response["message"] = "Payment recorded! Group status updated.";

        } catch (Exception $e) {
            // Rollback the transaction if any query fails or the payment was already settled
            $pdo->rollBack();
            $response["message"] = $e->getMessage();
        }
    } else {
        $response["message"] = "Missing or invalid IDs.";
    }
}

echo json_encode($response);
?>