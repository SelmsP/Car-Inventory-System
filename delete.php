<?php
include "db.php";
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];


$result = $conn->query("SELECT * FROM cars WHERE id=$id");
$car = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Car</title>
</head>
<body>
    <div style="display: flex; justify-content: center; align-items: center; height: 50vh; flex-direction: column; text-align: center; border: 1px solid #000; padding: 30px; width: 250px; margin: auto;">
        <h2>Delete Car</h2>
        <?php if ($car): ?>
            <p>Are you sure you want to delete:</p>
            <p><strong><?= htmlspecialchars($car['brand'] . ' ' . $car['model'] . ' (' . $car['year'] . ')') ?></strong>?</p>
            <form method="POST">
                <button type="submit" name="confirm" style="padding: 5px 5px;">Yes, Delete</button>
            </form>
            <br>
            <a href="dashboard.php">Cancel</a>
        <?php else: ?>
            <p>Car not found!</p>
            <a href="dashboard.php">Go Back</a>
        <?php endif; ?>
    </div>
</body>
</html>

<?php

if (isset($_POST['confirm'])) {
    $conn->query("DELETE FROM cars WHERE id=$id");
    header("Location: dashboard.php");
    exit;
}
?>
