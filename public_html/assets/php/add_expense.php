<?php 
session_start();
require_once 'db.php'; 

// 1. PROCESS GROUP SAVING (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['group_name'])) {
    header('Content-Type: application/json');
    $name = trim($_POST['group_name']);
    
    try {
        $stmt = $conn->prepare("INSERT INTO groups (group_name) VALUES (?)");
        if ($stmt->execute([$name])) {
            // PDO uses lastInsertId() instead of $conn->insert_id
            echo json_encode(["success" => true, "group_id" => $conn->lastInsertId()]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
    exit; 
}

// 2. LOAD PAGE DATA
$acc_holder = $_SESSION['full_name'] ?? "Guest";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Splitter Pro</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

   <div class="wrapper">
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>Groups</h3>
        </div>
        <button class="add-group-btn" onclick="createNewGroup()">+ New Group</button>
        <ul class="list-unstyled components">
            <?php
            // PDO FETCH LOOP
            try {
                $query = $conn->query("SELECT * FROM groups ORDER BY created_at DESC");
                while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                    echo "<li><a href='#' class='group-link' data-id='{$row['group_id']}' data-name='{$row['group_name']}'>
                          <i class='fas fa-users'></i> " . htmlspecialchars($row['group_name']) . "</a></li>";
                }
            } catch (PDOException $e) {
                echo "<li class='text-danger p-2'>Error loading groups</li>";
            }
            ?>       
        </ul>
    </nav>

    <div id="content">
        <header class="main-header">
            <button type="button" id="sidebarCollapse" class="btn-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <h2 id="currentGroupName">Select a Group</h2>
        </header>

        <div id="dynamicWorkspace" class="container-fluid"></div>
    </div>
</div>

<script>
    const ACCOUNT_HOLDER_NAME = "<?php echo htmlspecialchars($acc_holder); ?>";
</script>
<script src="script.js?v=<?php echo time(); ?>"></script>
</body>
</html>
