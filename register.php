<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);

    if ($stmt->execute()) {?>
        <meta http-equiv="refresh" content="0; url='index.php'" /><?php
    } else {
        echo '<script type=text/javascript>alert("خطا در انجام عملیات")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
    <div class="wrapper">
        <form method="POST" action="">
            <h1>sign up</h1>
            <div class="input-bux">
                <input type="text" placeholder="Username" id="username" name="username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-bux">
                <input type="password" placeholder="Password" id="password" name="password" required>
                <i class='bx bxs-lock'></i>

            </div>
            <div class="remember-forgot">
                <label><input type="checkbox"> Remember me </label>
            </div>
            <button type="submit" class="btn">Sign up</button>
            <div class="sign-up">
                <p>are you have account?<a href="index.php">Login</a></p>
            </div>
        </form>
    </div>
</body>
</html>