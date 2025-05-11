<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت وظایف</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Tahoma', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 15px 0;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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

        .btn-custom {
            font-size: 14px;
            padding: 8px 15px;
            border-radius: 6px;
            transition: 0.3s;
        }

        .btn-custom:hover {
            opacity: 0.8;
        }

        .btn-primary, .btn-warning, .btn-danger {
            font-size: 14px;
            padding: 10px 20px;
            border-radius: 8px;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        /* Responsive Styles */
        @media (max-width: 767px) {
            .navbar-nav {
                text-align: center;
            }

            .navbar-nav .nav-item {
                margin: 10px 0;
            }

            .user-menu {
                position: static;
                margin-top: 10px;
                text-align: center;
            }

            .navbar-toggler {
                border: none;
            }
        }
    </style>
</head>
<body>

<header>مدیریت وظایف</header>

<nav class="navbar navbar-expand-lg navbar-light" dir="rtl">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                <li class="nav-item active"><a class="nav-link" href="manage_comm.php">مدیریت کامنت ها</a></li>

            <?php endif; ?>
            <li class="nav-item"><a class="nav-link" href="wablog.php">وبلاگ</a></li>
            <li class="nav-item"><a class="nav-link" href="connectme.php">تماس با ما</a></li>
            <li class="nav-item"><a class="nav-link" href="aboutme.php">درباره ما</a></li>
        </ul>
    </div>
</nav>

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
</script>

<!-- Include jQuery and Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
