<?php
$link = mysqli_connect("localhost", "h314997_rezacex", "13861014", "h314997_reza");
if (!$link) {
    die("خطا در اتصال به دیتابیس: " . mysqli_connect_error());
}

if (!isset($_GET['id'])) {
    die("شناسه مقاله ارسال نشده است!");
}

$id = intval($_GET['id']);
$query = "DELETE FROM news WHERE id = $id";
$result = mysqli_query($link, $query);

mysqli_close($link);

if ($result) {
    echo "<script>alert('خبر با موفقیت حذف شد!'); location.replace('wablog.php');</script>";
} else {
    echo "<script>alert('حذف خبر انجام نشد!'); location.replace('wablog.php');</script>";
}
?>
