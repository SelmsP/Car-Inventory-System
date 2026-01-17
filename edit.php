<?php
include "db.php";


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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
if ($result->num_rows != 1) {
    echo "Car not found!";
    exit;
}
$data = $result->fetch_assoc();

if (isset($_POST['update'])) {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $year  = $_POST['year'];

   
    switch ($brand) {
        case "Toyota": $price = 1000000; break;
        case "Honda": $price = 1100000; break;
        case "Nissan": $price = 950000; break;
        case "Ford": $price = 1200000; break;
        case "Mitsubishi": $price = 1050000; break;
        default: $price = 900000;
    }

    switch ($model) {
        case "Sedan": $price += 0; break;
        case "SUV": $price += 300000; break;
        case "Hatchback": $price -= 100000; break;
        case "Pickup": $price += 400000; break;
        case "Van": $price += 200000; break;
    }

    $age = date("Y") - $year;
    $price -= ($age * 50000);
    if ($price < 250000) $price = 250000;

    $sql = "UPDATE cars SET brand='$brand', model='$model', year='$year', price='$price' WHERE id=$id";
    if ($conn->query($sql)) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<div style="width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #000; text-align: center; border-radius: 10px;">
    <h2>Edit Car</h2>
    <form method="POST">
        Brand: 
        <select name="brand" required style="width: 90%; padding:5px; margin:5px 0;">
            <option value="">-- Select Brand --</option>
            <option value="Toyota" <?= $data['brand']=="Toyota" ? "selected" : "" ?>>Toyota</option>
            <option value="Honda" <?= $data['brand']=="Honda" ? "selected" : "" ?>>Honda</option>
            <option value="Nissan" <?= $data['brand']=="Nissan" ? "selected" : "" ?>>Nissan</option>
            <option value="Ford" <?= $data['brand']=="Ford" ? "selected" : "" ?>>Ford</option>
            <option value="Mitsubishi" <?= $data['brand']=="Mitsubishi" ? "selected" : "" ?>>Mitsubishi</option>
        </select><br>

        Model: 
        <select name="model" required style="width: 90%; padding:5px; margin:5px 0;">
            <option value="">-- Select Model --</option>
            <option value="Sedan" <?= $data['model']=="Sedan" ? "selected" : "" ?>>Sedan</option>
            <option value="SUV" <?= $data['model']=="SUV" ? "selected" : "" ?>>SUV</option>
            <option value="Hatchback" <?= $data['model']=="Hatchback" ? "selected" : "" ?>>Hatchback</option>
            <option value="Pickup" <?= $data['model']=="Pickup" ? "selected" : "" ?>>Pickup</option>
            <option value="Van" <?= $data['model']=="Van" ? "selected" : "" ?>>Van</option>
        </select><br>

        Year: 
        <input type="number" name="year" value="<?= $data['year'] ?>" required 
            style="width: 100%; padding:5px; margin:5px 0; display:block;"><br>

        <button name="update" style="padding:5px 10px;">Update Car</button>
    </form>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</div>
