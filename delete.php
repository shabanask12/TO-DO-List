<?php
include 'db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

   
    $check = mysqli_prepare($conn, "SELECT id FROM tasks WHERE id = ?");
    mysqli_stmt_bind_param($check, "i", $id);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);

    if (mysqli_stmt_num_rows($check) > 0) {
        
        $stmt = mysqli_prepare($conn, "DELETE FROM tasks WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        header("Location: index.php?deleted=success");
        exit();
    } else {
        header("Location: index.php?deleted=notfound");
        exit();
    }
} else {
    header("Location: index.php?deleted=invalid");
    exit();
}
