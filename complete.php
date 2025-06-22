<?php
// Include database connection
include 'db.php';

// Check if the form was submitted with a task ID
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    // Sanitize the task ID
    $id = intval($_POST['id']);

    // Prepare the SQL statement to update the task's completed status
    $stmt = $conn->prepare("UPDATE tasks SET completed = 1 WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

// Redirect back to the main page
header("Location: index.php");
exit;
?>
