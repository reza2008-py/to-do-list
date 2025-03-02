<?php
include 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // بررسی اینکه آیا تسک متعلق به کاربر فعلی است یا نه
    $stmt = $conn->prepare("SELECT id FROM tasks WHERE id = :task_id AND user_id = :user_id");
    $stmt->bindParam(':task_id', $task_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($task) {
        // حذف تسک
        $stmt = $conn->prepare("DELETE FROM tasks WHERE id = :task_id");
        $stmt->bindParam(':task_id', $task_id);
        $stmt->execute();
    }

    // بازگشت به صفحه اصلی
    header("Location: home.php");
    exit();
} else {
    // اگر شناسه تسک وجود نداشت، به صفحه اصلی بازگردید
    header("Location: home.php");
    exit();
}
?>