<?php
include "db.php";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = hash("sha256", $_POST['password']);

    $res = $conn->query("SELECT * FROM users WHERE username='$username' AND password='$password'");

    if ($res->num_rows == 1) {
        $_SESSION['user'] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        echo "<p style='color:red; text-align:center;'>Invalid login!</p>";
    }
}
?>

<div style="width: 300px; margin: 100px auto; border: 1px solid #000; padding: 20px; text-align: center; border-radius: 10px;">
    <h2>Login</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required style="width: 90%; padding: 5px; margin: 5px 0;"><br>
        <input type="password" name="password" placeholder="Password" required style="width: 90%; padding: 5px; margin: 5px 0;"><br><br>
        <button name="login" style="padding: 5px 10px;">Login</button>
    </form>
    <br>
    <a href="signup.php">Create Account</a>
</div>

