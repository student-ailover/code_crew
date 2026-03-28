<?php
require_once 'db.php';
header('Content-Type: application/json');

$group_id = $_POST['group_id'];
$title = $_POST['title'];
$total_amount = $_POST['total_amount'];
$payer_name = $_POST['payer_name'];
$debtor_names = json_decode($_POST['debtors']);

try {
    $conn->beginTransaction();

    // 1. Find Payer ID
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE full_name = ?");
    $stmt->execute([$payer_name]);
    $payer = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$payer) throw new Exception("Payer '$payer_name' not found.");
    $payer_id = $payer['user_id'];

    // 2. Insert into 'expenses'
    $stmt = $conn->prepare("INSERT INTO expenses (group_id, paid_by_user_id, title, total_amount) VALUES (?, ?, ?, ?)");
    $stmt->execute([$group_id, $payer_id, $title, $total_amount]);
    $expense_id = $conn->lastInsertId();

    // 3. Calculate share
    $share = $total_amount / (count($debtor_names) + 1);

    // 4. Save Balances
    foreach ($debtor_names as $d_name) {
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE full_name = ?");
        $stmt->execute([$d_name]);
        $debtor = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$debtor) throw new Exception("Friend '$d_name' not found.");

        $ins = $conn->prepare("INSERT INTO member_balances (expense_id, user_id, amount_owed) VALUES (?, ?, ?)");
        $ins->execute([$expense_id, $debtor['user_id'], $share]);
    }

    $conn->commit();
    echo json_encode(["success" => true]);

} catch (Exception $e) {
    if ($conn->inTransaction()) $conn->rollBack();
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>