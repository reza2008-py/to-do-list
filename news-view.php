<?php
include("head.php");
?>
<?php
// بررسی اینکه آیا سشن شروع شده است یا نه
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// اتصال به دیتابیس برای اخبار (onenewa-db)
$conn_news = new PDO('mysql:host=localhost;dbname=h314997_reza', 'h314997_rezacex', '13861014');
$conn_news->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// اتصال به دیتابیس برای کامنت‌ها (user_auth)
$conn_users = new PDO('mysql:host=localhost;dbname=h314997_reza', 'h314997_rezacex', '13861014');
$conn_users->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// فرض می‌کنیم id خبر را از URL دریافت می‌کنیم
$news_id = $_GET['id'];

// بررسی اینکه کاربر وارد سیستم شده باشد
if (!isset($_SESSION['user_id'])) {
    die('لطفاً وارد حساب کاربری خود شوید تا بتوانید کامنت ارسال کنید.');
}

// ادامه کد...


// بررسی ارسال کامنت
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $user_id = $_SESSION['user_id']; // گرفتن user_id از سشن
    $comment = $_POST['comment'];

    // ذخیره کامنت در دیتابیس
    $stmt_insert = $conn_users->prepare("INSERT INTO comments (news_id, user_id, comment) VALUES (:news_id, :user_id, :comment)");
    $stmt_insert->bindParam(':news_id', $news_id);
    $stmt_insert->bindParam(':user_id', $user_id);
    $stmt_insert->bindParam(':comment', $comment);
    $stmt_insert->execute();
}

// گرفتن خبر از دیتابیس onenewa-db
$stmt = $conn_news->prepare("SELECT * FROM news WHERE id = :id");
$stmt->bindParam(':id', $news_id);
$stmt->execute();
$news = $stmt->fetch(PDO::FETCH_ASSOC);

// گرفتن کامنت‌ها از دیتابیس user_auth (جدول comments)
$stmt_comments = $conn_users->prepare("SELECT comments.*, users.username FROM comments JOIN users ON comments.user_id = users.id WHERE news_id = :news_id");
$stmt_comments->bindParam(':news_id', $news_id);
$stmt_comments->execute();
$comments = $stmt_comments->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مشاهده خبر</title>
    <style>
        body {
            font-family: 'Tahoma', sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        .news-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .news-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .news-text {
            font-size: 16px;
            line-height: 1.6;
        }
        .news-image {
            margin: 20px 0;
            text-align: center;
        }
        .comments-section {
            margin-top: 30px;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .comment {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.05);
        }
        .comment p {
            font-size: 14px;
        }
        .comment-user {
            font-weight: bold;
            color: #007bff;
        }
        .comment-text {
            font-size: 14px;
            color: #555;
        }
        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            font-size: 16px;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="news-content">
            <h1 class="news-title"><?php echo htmlspecialchars($news['title']); ?></h1>
            <div class="news-image">
                <!-- نمایش تصویر اگر مسیر تصویر موجود باشد -->
                <?php if (!empty($news['imageurl'])): ?>
                    <img src="<?php echo htmlspecialchars($news['imageurl']); ?>" alt="خبر تصویر" style="max-width: 100%; height: auto;">
                <?php endif; ?>
            </div>
            <p class="news-text"><?php echo nl2br(htmlspecialchars($news['text'])); ?></p>
        </div>

        <div class="comments-section">
            <h3>کامنت‌ها:</h3>
            <?php if (!empty($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment">
                        <p class="comment-user"><?php echo htmlspecialchars($comment['username']); ?>:</p>
                        <p class="comment-text"><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>هنوز هیچ کامنتی وجود ندارد.</p>
            <?php endif; ?>
        </div>

        <!-- فرم برای وارد کردن کامنت -->
        <form method="POST" action="">
            <textarea name="comment" required placeholder="کامنت خود را بنویسید..."></textarea><br>
            <button type="submit">ارسال کامنت</button>
        </form>
    </div>
</body>
</html>

<?php
// بستن اتصالات
include("footer.php");

$conn_news = null;
$conn_users = null;
?>
