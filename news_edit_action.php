<?php
include("head.php"); // فایل هدر را وارد کن

$link = mysqli_connect("localhost", "h314997_rezacex", "13861014", "h314997_reza");
if (!$link) {
    die("خطا در اتصال به دیتابیس: " . mysqli_connect_error());
}

// بررسی اینکه شناسه مقاله ارسال شده باشد
if (!isset($_POST['id'])) {
    die("شناسه مقاله ارسال نشده است!");
}

$id = intval($_POST['id']);
$title = mysqli_real_escape_string($link, $_POST['title']);
$text = mysqli_real_escape_string($link, $_POST['text']);
$image = $_FILES['image'];

// بررسی اینکه آیا تصویری آپلود شده است یا نه
$imageurl = $_POST['current_image']; // تصویر فعلی اگر آپلود نشده باشد

if ($image['name']) {
    // اگر تصویر جدید آپلود شده باشد، باید تصویر قدیمی حذف شود
    $imageurl = 'uploads/' . basename($image['name']);
    move_uploaded_file($image['tmp_name'], $imageurl);  // آپلود تصویر جدید
}

// اجرای کوئری برای ویرایش داده‌ها
$query = "UPDATE news SET title = '$title', text = '$text', imageurl = '$imageurl' WHERE id = $id";
$result = mysqli_query($link, $query);

// بررسی نتیجه عملیات
if ($result) {
    echo "<script>alert('خبر با موفقیت ویرایش شد!'); location.replace('wablog.php');</script>";
} else {
    echo "<script>alert('خطا در ویرایش خبر!'); location.replace('wablog.php');</script>";
}

mysqli_close($link);
?>
