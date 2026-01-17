<?php
include "db.php";


$error = "";

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $password = hash("sha256", $_POST['password']); 

   
    $check = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($check->num_rows > 0) {
        $error = "Username already exists!";
    } else {
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($sql)) {
   
            header("Location: login.php");
            exit;
        } else {
            $error = "Something went wrong. Please try again!";
        }
    }
}
?>

<div style="width: 300px; margin: 100px auto; border: 1px solid #000; padding: 20px; text-align: center; border-radius: 10px;">
    <h2>Sign Up</h2>
    
    <?php if($error != ""): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required 
               style="width: 90%; padding: 5px; margin: 5px 0;" value=""><br>
        <input type="password" name="password" placeholder="Password" required 
               style="width: 90%; padding: 5px; margin: 5px 0;" value=""><br><br>
        <button name="signup" style="padding: 5px 10px;">Sign Up</button>
    </form>
    <br>
    <a href="login.php">Login</a>
</div>
