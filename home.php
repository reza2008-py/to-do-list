<?php
include 'head.php';
include 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// اضافه کردن وظیفه جدید
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["task"])) {
    $task = trim($_POST["task"]);
    if (!empty($task)) {
        $stmt = $conn->prepare("INSERT INTO tasks (user_id, task) VALUES (:user_id, :task)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':task', $task);
        $stmt->execute();
    }
}

// دریافت وظایف کاربر
$stmt = $conn->prepare("SELECT id, task FROM tasks WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>وظایف من</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <div class="container">
        <h2>👋 سلام <?php echo $_SESSION['username']; ?>!</h2>
        <p>✅ لیست وظایف امروزت:</p>
        <ul class="list-group">
            <?php if (!empty($tasks)) { ?>
                <?php foreach ($tasks as $task) { ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo htmlspecialchars($task["task"]); ?>
                        <a href="delete_task.php?id=<?php echo $task['id']; ?>" class="btn btn-sm btn-danger">حذف</a>
                    </li>
                <?php } ?>
            <?php } else { ?>
                <li class="list-group-item">⏳ هنوز هیچ وظیفه‌ای ثبت نشده است.</li>
            <?php } ?>
        </ul>
        
        <form method="POST">
            <input type="text" name="task" placeholder="اضافه کردن وظیفه جدید..." required>
            <button type="submit" class="btn btn-outline-success mt-2">➕ اضافه کردن</button>
        </form>

        <a href="logout.php" class="btn btn-danger mt-3">🚪 خروج</a>
    </div>
</body>
</html>

<?php include("footer.php"); ?>
