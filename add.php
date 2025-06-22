<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $task = $_POST['task'];
  $status = $_POST['status'];
  $note = $_POST['note'];
  $reminder = $_POST['reminder'];

  if (empty($reminder)) {
    $reminder = date('Y-m-d\TH:i');
  }

  $completed = ($status === 'Completed') ? 1 : 0;
$stmt = $conn->prepare("INSERT INTO tasks (task, status, note, reminder) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $task, $status, $note, $reminder);
  $stmt->execute();

  header("Location: index.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" /> <!-- ✅ critical for mobile responsiveness -->
  <title>Add Task</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-sky-100 to-blue-200 dark:from-gray-900 dark:to-gray-800 text-black dark:text-white min-h-screen flex items-center justify-center px-4">

  <div class="bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-2xl shadow-lg w-full max-w-lg border border-gray-200 dark:border-gray-700">
    <h2 class="text-2xl sm:text-3xl font-bold mb-6 text-center text-blue-600 dark:text-blue-400">➕ Add New Task</h2>

    <form method="POST" class="space-y-5">
      <div>
        <label class="block mb-1 font-medium">Task</label>
        <input type="text" name="task" required class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <div>
        <label class="block mb-1 font-medium">Status</label>
        <select name="status" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-400">
          <option value="Pending" selected>Pending ⏳</option>
          <option value="In Progress">In Progress 🚧</option>
          <option value="Completed">Completed ✅</option>
        </select>
      </div>

      <div>
        <label class="block mb-1 font-medium">Note</label>
        <textarea name="note" rows="3" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
      </div>

      <div>
        <label class="block mb-1 font-medium">Reminder</label>
        <input type="datetime-local" name="reminder" value="<?= date('Y-m-d\TH:i') ?>" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-400">
      </div>

      <div class="flex flex-col sm:flex-row justify-between mt-6 gap-3">
        <a href="index.php" class="w-full sm:w-auto px-5 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg text-center">Cancel</a>
        <button type="submit" class="w-full sm:w-auto px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Add Task</button>
      </div>
    </form>
  </div>

</body>

</html>