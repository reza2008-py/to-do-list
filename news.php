<?php
include("wablog.php");
if(!isset($_SESSION["manager"])){
    ?>
<script>
    location.replace("wablog.php");
</script>
    <?php
    exit(); // اطمینان از عدم اجرای بقیه کد
}

?>

<div class="row">
    <p class="col">
        <a href="news_add.php">+</a>
        لیست اخبار
    </p>
</div>

<?php
// اتصال به دیتابیس
$link = mysqli_connect("localhost", "13861014", "", "h314997_reza");
if (!$link) {
    die("خطا در اتصال به دیتابیس: " . mysqli_connect_error());
}

$result = mysqli_query($link, "SELECT * FROM `news`");
if (!$result) {
    die("خطا در اجرای کوئری: " . mysqli_error($link));
}

while ($row = mysqli_fetch_array($result)) { // مقداردهی درون while
?>
<div class="row">
    <div class="col-12 col-md-3">
        <img class="img-thumbnail m-2 p-1" src="<?php echo htmlspecialchars($row["imageurl"]); ?>" alt="">
    </div>
    <div class="col-12 col-md-9">
        <a class="btn btn-danger" href="news_delete.php?id=<?php echo($row["id"]); ?>">-</a>
        <a class="btn btn-success" href="news_edit.php?id=<?php echo($row["id"]); ?>">*</a>
        <span class="h5"><?php echo htmlspecialchars($row["title"]); ?></span>
    </div>
    <span class="col-12 col-md h6"><?php echo htmlspecialchars($row["text"]); ?> </span>
</div>
<?php
}

// بستن اتصال بعد از پردازش تمام داده‌ها
mysqli_close($link);

include("footer");
?>
