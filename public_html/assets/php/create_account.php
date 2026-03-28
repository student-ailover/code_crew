<?php
header('Content-Type: application/json');
require_once 'db.php'; // This now provides the $pdo object

$response = ["success" => false, "message" => "Registration failed."];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Retrieve and trim inputs
    $full_name    = isset($_POST['full_name']) ? trim($_POST['full_name']) : '';
    $email        = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone_number = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : null;
    $dob          = isset($_POST['dob']) ? $_POST['dob'] : null;
    $password     = isset($_POST['password']) ? $_POST['password'] : '';

    // Basic validation
    if (empty($full_name) || empty($email) || empty($password)) {
        $response["message"] = "Name, email, and password are required.";
        echo json_encode($response);
        exit;
    }

    // 2. Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // 3. Use PDO Prepared Statement
        // kyc_status and created_at use database defaults
        $sql = "INSERT INTO users (full_name, email, phone_number, password, dob) 
                VALUES (:name, :email, :phone, :pass, :dob)";
        
        $stmt = $pdo->prepare($sql);
        
        // Execute with an associative array (much cleaner than bind_param)
        $stmt->execute([
            'name'  => $full_name,
            'email' => $email,
            'phone' => $phone_number,
            'pass'  => $hashed_password,
            'dob'   => $dob
        ]);

        $response["success"] = true;
        $response["message"] = "Account created successfully!";

    } catch (PDOException $e) {
        // 4. Handle Duplicate Entry (Error 1062)
        if ($e->getCode() == 23000) { // PDO uses SQLSTATE codes; 23000 is for integrity violations
            $response["message"] = "An account already exists for this email or phone number.";
        } else {
            $response["message"] = "Database error: " . $e->getMessage();
        }
    }
}

echo json_encode($response);
?>