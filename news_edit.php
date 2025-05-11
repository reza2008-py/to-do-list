<?php
include("head.php");

if (!isset($_GET["id"])) {
    die("شناسه مقاله ارسال نشده است!");
}

$id = intval($_GET["id"]);
$link = mysqli_connect("localhost", "h314997_rezacex", "13861014", "h314997_reza");

if (!$link) {
    die("خطا در اتصال به دیتابیس: " . mysqli_connect_error());
}

$result = mysqli_query($link, "SELECT * FROM news WHERE id = $id");
if (!$result || mysqli_num_rows($result) == 0) {
    die("خبر پیدا نشد!");
}

$row = mysqli_fetch_array($result);
mysqli_close($link);

$title = $row["title"];
$text = $row["text"];
$imageurl = $row["imageurl"];
?>

<div class="row">
    <p class="col">خبر را ویرایش کنید</p>
</div>

<form action="news_edit_action.php" method="post" enctype="multipart/form-data" class="row m-2">
    <?php if ($imageurl): ?>
        <img src="<?php echo htmlspecialchars($imageurl); ?>" style="max-width: 200px;" class="m-2">
    <?php endif; ?>

    <input type="file" class="col-12 col-md card m-1" name="image">

    <input type="text" class="col-12 col-md card m-1" name="title" placeholder="عنوان" value="<?php echo htmlspecialchars($title); ?>">

    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <input type="text" class="col-12 col-md card m-1" name="text" placeholder="متن خبر" value="<?php echo htmlspecialchars($text); ?>">

    <input type="submit" class="col-12 col-md card m-1" value="ذخیره">
</form>

<?php include("footer.php"); ?>
