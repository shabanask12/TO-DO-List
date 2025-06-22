<?php
include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM tasks WHERE id = $id");
$task = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newTask = $_POST['task'];
    $status = $_POST['status'];
    $note = $_POST['note'];
    $reminder = $_POST['reminder'];

    if (empty($reminder)) {
        $reminder = date('Y-m-d\TH:i');
    }

    $completed = ($status === 'Completed') ? 1 : 0;
$stmt = $conn->prepare("UPDATE tasks SET task = ?, status = ?, note = ?, reminder = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $newTask, $status, $note, $reminder, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="UTF-8">
  <title>Edit Task</title>
  <script>
    tailwind.config = {
      darkMode: 'class'
    }
  </script>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-black dark:text-white min-h-screen flex items-center justify-center">

<div class="bg-white dark:bg-gray-800 p-8 rounded shadow w-full max-w-lg">
  <h2 class="text-2xl font-semibold mb-6">Edit Task</h2>
  <form method="POST">
    <div class="mb-4">
      <label class="block mb-1">Task</label>
      <input type="text" name="task" value="<?= htmlspecialchars($task['task']) ?>" required class="w-full p-2 rounded border border-gray-300 dark:bg-gray-700 dark:text-white">
    </div>

    <div class="mb-4">
      <label class="block mb-1">Status</label>
      <select name="status" class="w-full p-2 rounded border border-gray-300 dark:bg-gray-700 dark:text-white">
        <option value="Pending" <?= $task['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
        <option value="In Progress" <?= $task['status'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
        <option value="Completed" <?= $task['status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
      </select>
    </div>

    <div class="mb-4">
      <label class="block mb-1">Note</label>
      <textarea name="note" rows="3" class="w-full p-2 rounded border border-gray-300 dark:bg-gray-700 dark:text-white"><?= htmlspecialchars($task['note']) ?></textarea>
    </div>

    <div class="mb-4">
      <label class="block mb-1">Reminder</label>
      <input type="datetime-local" name="reminder" value="<?= $task['reminder'] ? date('Y-m-d\TH:i', strtotime($task['reminder'])) : date('Y-m-d\TH:i') ?>" class="w-full p-2 rounded border border-gray-300 dark:bg-gray-700 dark:text-white">
    </div>

    <div class="flex justify-end">
      <a href="index.php" class="bg-gray-400 text-white px-4 py-2 rounded mr-2">Cancel</a>
      <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Update Task</button>
    </div>
  </form>
</div>

<script>
  function toggleDarkMode() {
    document.documentElement.classList.toggle('dark');
    localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
  }
  if (localStorage.getItem('theme') === 'dark') {
    document.documentElement.classList.add('dark');
  }
</script>

</body>
</html>
