<?php
include 'db.php';

$ongoingTasks = mysqli_query($conn, "SELECT * FROM tasks WHERE status != 'Completed' ORDER BY created_at DESC");
$completedTasks = mysqli_query($conn, "SELECT * FROM tasks WHERE status = 'Completed' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Tasks</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 dark:bg-gray-900 text-black dark:text-white">
    <div class="flex h-screen">
        <aside class="w-64 bg-blue-900 text-white p-6 space-y-4">
            <h1 class="text-2xl font-bold mb-8">TASK</h1>
            <nav class="space-y-3">
                <a href="index.php" class="block px-4 py-2 hover:bg-blue-700 rounded">Home</a>
                <a href="my_tasks.php" class="block px-4 py-2 bg-blue-700 rounded">My Task</a>
            </nav>
        </aside>

        <main class="flex-1 p-8 overflow-y-auto">
            <h2 class="text-2xl font-semibold mb-6">My Task List</h2>

            <!-- Ongoing Tasks -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow mb-8">
                <h3 class="text-xl font-semibold mb-4">Ongoing Tasks</h3>
                <table class="w-full text-left table-auto">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700">
                            <th class="p-2">#</th>
                            <th class="p-2">Task</th>
                            <th class="p-2 text-center">Status</th>
                            <th class="p-2">Note</th>
                            <th class="p-2">Reminder</th>
                            <th class="p-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        while ($row = mysqli_fetch_assoc($ongoingTasks)) { ?>
                            <tr class="border-b dark:border-gray-600">
                                <td class="p-2"><?= $i++ ?></td>
                                <td class="p-2"><?= htmlspecialchars($row['task']) ?></td>
                                <td class="p-2 text-center">
                                    <?php
                                    $status = $row['status'];
                                    $color = $status === 'Pending' ? 'bg-yellow-500' : ($status === 'In Progress' ? 'bg-blue-500' : 'bg-green-500');
                                    $icon = $status === 'Pending' ? '⏳' : ($status === 'In Progress' ? '🚧' : '✅');
                                    ?>
                                    <span class="text-white text-sm px-3 py-1 rounded-full <?= $color ?>"><?= $icon ?> <?= $status ?></span>
                                </td>
                                <td class="p-2"><?= htmlspecialchars($row['note']) ?></td>
                                <td class="p-2"><?= $row['reminder'] ? date("Y-m-d H:i", strtotime($row['reminder'])) : '-' ?></td>
                                <td class="p-2 space-x-2">
                                    <a href="edit.php?id=<?= $row['id'] ?>" class="text-blue-600 dark:text-blue-400" title="Edit Task">✏️</a>
                                    <a href="delete.php?id=<?= $row['id'] ?>" class="text-red-600 dark:text-red-400" onclick="return confirm('Delete this task?')" title="Delete Task">🗑️</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- Completed Tasks -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded shadow">
                <h3 class="text-xl font-semibold mb-4">Completed Tasks</h3>
                <table class="w-full text-left table-auto">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700">
                            <th class="p-2">#</th>
                            <th class="p-2">Task</th>
                            <th class="p-2 text-center">Status</th>
                            <th class="p-2">Note</th>
                            <th class="p-2">Reminder</th>
                            <th class="p-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $j = 1;
                        while ($row = mysqli_fetch_assoc($completedTasks)) { ?>
                            <tr class="border-b dark:border-gray-600">
                                <td class="p-2"><?= $j++ ?></td>
                                <td class="p-2"><?= htmlspecialchars($row['task']) ?></td>
                                <td class="p-2 text-center">
                                    <span class="text-white text-sm px-3 py-1 rounded-full bg-green-500">✅ Completed</span>
                                </td>
                                <td class="p-2"><?= htmlspecialchars($row['note']) ?></td>
                                <td class="p-2"><?= $row['reminder'] ? date("Y-m-d H:i", strtotime($row['reminder'])) : '-' ?></td>
                                <td class="p-2 space-x-2">
                                    <a href="edit.php?id=<?= $row['id'] ?>" class="text-blue-600 dark:text-blue-400" title="Edit Task">✏️</a>
                                    <a href="delete.php?id=<?= $row['id'] ?>" class="text-red-600 dark:text-red-400" onclick="return confirm('Delete this task?')" title="Delete Task">🗑️</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>

</html>
