<?php
session_start();

// فقط کاربر با username = reza اجازه دسترسی داره
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'reza') {
    die("شما اجازه دسترسی ندارید.");
}
$host = 'localhost';
$dbname = 'h314997_reza';
$username = 'h314997_rezacex';
$password = '13861014';
// اتصال به دیتابیس‌ها
$conn_news = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$conn_news->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$conn_users = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$conn_users->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// حذف کامنت
if (isset($_POST['delete_comment'])) {
    $stmt = $conn_users->prepare("DELETE FROM comments WHERE id = :id");
    $stmt->execute([':id' => $_POST['delete_comment']]);
}

// ویرایش کامنت
if (isset($_POST['edit_comment']) && isset($_POST['comment_text'])) {
    $stmt = $conn_users->prepare("UPDATE comments SET comment = :comment WHERE id = :id");
    $stmt->execute([
        ':comment' => $_POST['comment_text'],
        ':id' => $_POST['edit_comment']
    ]);
}

// دریافت کامنت‌ها
$stmt_comments = $conn_users->prepare("
    SELECT comments.id, comments.comment, users.username, news.title 
    FROM comments 
    JOIN users ON comments.user_id = users.id 
    JOIN news ON comments.news_id = news.id
");
$stmt_comments->execute();
$comments = $stmt_comments->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>مدیریت کامنت‌ها</title>
    <style>
        body {
            font-family: Tahoma;
            background: #f2f2f2;
            padding: 20px;
            direction: rtl;
        }
        .comment-box {
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .comment-box h4 {
            margin: 0 0 10px;
        }
        .comment-box form {
            margin-top: 10px;
        }
        textarea {
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 8px;
            resize: vertical;
        }
        .btn {
            padding: 8px 15px;
            margin-top: 8px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-delete {
            background: #dc3545;
            color: #fff;
        }
        .btn-edit {
            background: #28a745;
            color: #fff;
        }
    </style>
</head>
<body>
    <h2>پنل مدیریت کامنت‌ها</h2>

    <?php foreach ($comments as $c): ?>
        <div class="comment-box">
            <h4>کاربر: <?php echo htmlspecialchars($c['username']); ?></h4>
            <p><strong>برای خبر:</strong> <?php echo htmlspecialchars($c['title']); ?></p>

            <form method="POST">
                <textarea name="comment_text"><?php echo htmlspecialchars($c['comment']); ?></textarea><br>
                <button class="btn btn-edit" type="submit" name="edit_comment" value="<?php echo $c['id']; ?>">ویرایش</button>
                <button class="btn btn-delete" type="submit" name="delete_comment" value="<?php echo $c['id']; ?>" onclick="return confirm('مطمئنی میخوای حذفش کنی؟');">حذف</button>
            </form>
        </div>
    <?php endforeach; ?>
</body>
</html>
