<?php
// dan disini yang dieksekusinya
require_once("services/database.php");
//ketika datanya ga ada maka kita timpa nilainya login notifikasi dengan errornya apa
session_start();

$login_notification = "";
//kalau dia ada trigger is login dan session is login bernilai true maka arahkan ke index.php
if(isset($_SESSION['is_login']) && $_SESSION['is_login']) {
    header("location: index.php");
}

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $select_admin_query = "SELECT * FROM admin WHERE username= '$username' AND password ='$password'";
    $select_admin = $db->query($select_admin_query);

    //kalau ada datanya, maka kita munculin apa
    if($select_admin->num_rows > 0) {
        $admin = $select_admin->fetch_assoc();

        $_SESSION['is_login'] = true;
        $_SESSION['username'] = $admin['username'];

        header('location: index.php');
    } else {
        $login_notification = 'Akun admin tidak ditemukan!';
    }
}

// $select_admin = "SELECT * FROM admin";
// $result = $db->query($select_admin);

// $admin = $result->fetch_assoc();
//cara mendapatkan dan memunculkan data password/username
// var_dump($admin['password']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="super-center">
        <h1>LOGIN ADMIN</h1>
        <i><?= $login_notification ?></i>
        <!--PHP_SELF = Setelah ngeklik form bakal nyari data difile tersebut dan mengeksekusi file yang ada didalamnya-->
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
            <label for="">username</label>
            <input name="username" type="text">
            <label for="password">password</label>
            <input name="password" type="password">
            <button type="submit" name="login">LOGIN</button>
        </form>
    </div>
</body>
</html>
