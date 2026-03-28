<?php
$servername = "localhost"; // The server name (usually "localhost")
$username = "username";    // Your database username
$password = "password";    // Your database password
$dbname = "code_crew";          // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$sql = "SELECT id, firstname, lastname FROM unpaid";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Output data of each row
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
  }
} else {
  echo "0 results";
}

// Close connection (optional, connection closes automatically when script ends)
$conn->close();
?>
