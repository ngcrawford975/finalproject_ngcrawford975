<?php
$mysqli = new mysqli("localhost", "root", "root", "student_directory");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>

<?php
$lname = $_POST['lname'] ?? '';

$stmt = $mysqli->prepare("CALL search_students(?)");

if (!$stmt) {
    die("Prepare failed: " . $mysqli->error);
}

$stmt->bind_param("s", $lname);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/main.css">
    <script src="scripts/main.js" defer></script>
</head>
<body>

    <h1>Search Results</h1>
    <p><a href="index.php">Return to Home</a></p>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
        </tr>

    <?php
    if ($result->num_rows === 0) {
        echo "<tr><td colspan='4'>No students found.</td></tr>";
    } else {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "</tr>";
        }
    }
    ?>
    </table>
</body>
</html>