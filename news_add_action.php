<?php
include("wablog.php");

// اتصال به دیتابیس
$link = mysqli_connect("localhost", "h314997_rezacex", "13861014", "h314997_reza");
if (!$link) {
    die("خطا در اتصال به دیتابیس: " . mysqli_connect_error());
}

// بررسی اینکه فرم ارسال شده است
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($link, $_POST["title"]);
    $text = mysqli_real_escape_string($link, $_POST["text"]);
    
    // بررسی آپلود فایل
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $allowed_extensions = ["jpg", "jpeg", "png", "gif"]; // فرمت‌های مجاز
        $upload_dir = "images/"; // فولدر ذخیره‌سازی
        $image_name = basename($_FILES["image"]["name"]);
        $image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        // بررسی فرمت تصویر
        if (in_array($image_extension, $allowed_extensions)) {
            $new_image_name = uniqid("img_", true) . "." . $image_extension; // نام یکتا
            $image_path = $upload_dir . $new_image_name;

            // انتقال تصویر به پوشه
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $image_path)) {
                // ذخیره در دیتابیس
                $query = "INSERT INTO `news`(`title`, `text`, `imageurl`) VALUES ('$title', '$text', '$image_path')";
                if (mysqli_query($link, $query)) {
                    echo "<script>location.replace('news.php');</script>";
                } else {
                    echo "خطا در ذخیره اطلاعات: " . mysqli_error($link);
                }
            } else {
                echo "آپلود تصویر انجام نشد!";
            }
        } else {
            echo "فرمت تصویر نامعتبر است! فقط JPG, JPEG, PNG, GIF مجاز هستند.";
        }
    } else {
        echo "لطفاً یک تصویر انتخاب کنید!";
    }
}

mysqli_close($link);
include("footer.php");
?>
