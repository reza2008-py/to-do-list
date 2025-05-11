<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$link = mysqli_connect("localhost", "h314997_rezacex", "13861014", "h314997_reza");
if (!$link) {
    die("خطا در اتصال به دیتابیس: " . mysqli_connect_error());
}

$result = mysqli_query($link, "SELECT * FROM news ORDER BY id DESC");
if (!$result) {
    die("خطا در اجرای کوئری: " . mysqli_error($link));
}
?>
<!DOCTYPE html>
<html lang="fa">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت وظایف</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Tahoma', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            text-align: center;
        }
        header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 15px 0;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%; 
            margin: 0 auto; 
        }

        .navbar {
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar-nav .nav-link {
            font-size: 16px;
            font-weight: 500;
            color: #007bff !important;
            transition: 0.3s;
        }
        .navbar-nav .nav-link:hover {
            color: #0056b3 !important;
        }
        .user-menu {
            position: fixed;
            top: 20px;
            right: 30px;
            z-index: 1000;
        }
        .username {
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            color: #007bff;
            padding: 8px 15px;
            border-radius: 6px;
            background: #e9f5ff;
            transition: 0.3s;
        }
        .username:hover {
            background: #d6ebff;
        }
        .dropdown {
            display: none;
            position: absolute;
            right: 0;
            background: white;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            border-radius: 6px;
            overflow: hidden;
        }
        .dropdown a {
            display: block;
            padding: 10px;
            color: #007bff;
            text-decoration: none;
            transition: 0.3s;
        }
        .dropdown a:hover {
            background: #f1f1f1;
        }
        img {
            height: 250px;
            width: 100%;
            object-fit: cover;
        }

        /* ریسپانسیو برای موبایل */
        @media (max-width: 767px) {
            header {
                font-size: 20px;
                padding: 10px 0;
            }
            .navbar-nav .nav-link {
                font-size: 14px;
            }
            .card {
                margin-bottom: 20px;
            }
            .card-body {
                padding: 15px;
            }
            .container {
                padding: 0 15px;
            }
        }

        @media (max-width: 576px) {
            .user-menu {
                position: static;
                text-align: center;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>

<header>مدیریت وظایف</header>

<nav class="navbar navbar-expand-lg navbar-light" dir="rtl">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <div class="user-menu">
            <?php if(isset($_SESSION['username'])): ?>
                <div class="username" onclick="toggleMenu()">
                    <?= htmlspecialchars($_SESSION['username']) ?>
                    <div class="dropdown" id="dropdownMenu">
                        <a href="logout.php">خروج</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="index.php" class="btn btn-primary btn-custom">ورود</a>
            <?php endif; ?>
        </div>

        <ul class="navbar-nav">
            <li class="nav-item active"><a class="nav-link" href="home.php">خانه</a></li>
            <?php if(isset($_SESSION['username']) && $_SESSION['username'] === 'reza'): ?>
                <li class="nav-item active"><a class="nav-link" href="news_add.php">افزودن محتوا</a></li>
            <?php endif; ?>
            <li class="nav-item"><a class="nav-link" href="wablog.php">وبلاگ</a></li>
            <li class="nav-item"><a class="nav-link" href="connectme.php">تماس با ما</a></li>
            <li class="nav-item"><a class="nav-link" href="aboutme.php">درباره ما</a></li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="text-center">وبلاگ</h1>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <?php while ($row = mysqli_fetch_array($result)) { 
                $full_text = htmlspecialchars($row['text']);
                $first_sentence = preg_split('/(?<=[.!؟])\s+/', $full_text, 2)[0]; 
            ?>
            <div class="card mb-4">
                <img src="<?php echo htmlspecialchars($row['imageurl']); ?>" class="card-img-top" alt="تصویر مقاله">
                <div class="card-body" dir="rtl" >
                    <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                    <p class="card-text short-text"><?php echo $first_sentence . '...'; ?></p>
                    <p class="card-text full-text d-none"><?php echo nl2br($full_text); ?></p>
                    <a href="news-view.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">مطالعه بیشتر</a>
                    <?php if(isset($_SESSION['username']) && $_SESSION['username'] === 'reza'): ?>
                        <a href="news_edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">✏ ویرایش</a>
                        <a href="news_delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('آیا مطمئن هستید؟');">🗑 حذف</a>
                    <?php endif; ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php
mysqli_close($link);
?>

<script>
    function toggleMenu() {
        var menu = document.getElementById("dropdownMenu");
        menu.style.display = menu.style.display === "block" ? "none" : "block";
    }

    document.addEventListener("click", function(event) {
        var menu = document.getElementById("dropdownMenu");
        var userBtn = document.querySelector(".username");
        if (menu && userBtn && !menu.contains(event.target) && !userBtn.contains(event.target)) {
            menu.style.display = "none";
        }
    });

    $(document).ready(function() {
        $(".read-more").click(function() {
            var cardBody = $(this).closest(".card-body");
            cardBody.find(".short-text").toggleClass("d-none");
            cardBody.find(".full-text").toggleClass("d-none");
            $(this).text($(this).text() === "مطالعه بیشتر" ? "بستن" : "مطالعه بیشتر");
        });
    });
</script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
