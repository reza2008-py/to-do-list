<?php
include("head.php"); // تغییر نام فایل صحیح

$link = mysqli_connect("localhost", "root", "", "onenewa-db"); // نام صحیح دیتابیس
if (!$link) {
    die("خطا در اتصال به دیتابیس: " . mysqli_connect_error());
}

if (!isset($_GET['id'])) {
    die("شناسه مقاله ارسال نشده است!");
}

$id = intval($_GET['id']);
$result = mysqli_query($link, "SELECT * FROM news WHERE id = $id");

if (!$result || mysqli_num_rows($result) == 0) {
    die("خبر موردنظر یافت نشد!");
}

$row = mysqli_fetch_assoc($result);
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویرایش خبر</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">ویرایش خبر</h2>
    <form action="news_edit_action.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <div class="form-group">
            <label>عنوان خبر:</label>
            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($row['title']); ?>" required>
        </div>
        <div class="form-group">
            <label>متن خبر:</label>
            <textarea name="text" class="form-control" rows="5" required><?php echo htmlspecialchars($row['text']); ?></textarea>
        </div>
        <div class="form-group">
            <label>تصویر فعلی:</label><br>
            <img src="<?php echo htmlspecialchars($row['imageurl']); ?>" class="img-thumbnail" style="max-width: 200px;">
        </div>
        <div class="form-group">
            <label>آپلود تصویر جدید (در صورت نیاز):</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">ذخیره تغییرات</button>
        <a href="wablog.php" class="btn btn-secondary">بازگشت</a>
    </form>
</div>
</body>
</html>
