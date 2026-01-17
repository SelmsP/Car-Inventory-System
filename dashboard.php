<?php
include "db.php";


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user']; 
?>

<div style="width: 600px; margin: 50px auto; text-align: center; border: 1px solid #000; padding: 20px; border-radius: 10px;">

    <h2>Welcome <?= htmlspecialchars($user) ?></h2>

    
    <form method="POST" style="margin-bottom: 20px;">
        Brand:
        <select name="brand" required style="width: 60%; padding: 5px; margin: 5px 0;">
            <option value="">-- Select Brand --</option>
            <option value="Toyota">Toyota</option>
            <option value="Honda">Honda</option>
            <option value="Nissan">Nissan</option>
            <option value="Ford">Ford</option>
            <option value="Mitsubishi">Mitsubishi</option>
        </select><br>

        Model:
        <select name="model" required style="width: 60%; padding: 5px; margin: 5px 0;">
            <option value="">-- Select Model --</option>
            <option value="Sedan">Sedan</option>
            <option value="SUV">SUV</option>
            <option value="Hatchback">Hatchback</option>
            <option value="Pickup">Pickup</option>
            <option value="Van">Van</option>
        </select><br>

        Year:
        <select name="year" required style="width: 60%; padding: 5px; margin: 5px 0;">
            <option value="">-- Select Year --</option>
            <?php
            for ($y = date("Y"); $y >= 2000; $y--) {
                echo "<option value='$y'>$y</option>";
            }
            ?>
        </select><br><br>

        <button name="add" style="padding: 5px 15px;">Add Car</button>
    </form>

    <?php
    if (isset($_POST['add'])) {
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

        
        if ($price < 250000) {
            $price = 250000;
        }

        $sql = "INSERT INTO cars (brand, model, year, price, user)
                VALUES ('$brand','$model','$year','$price','$user')";

        if ($conn->query($sql)) {
            echo "<p style='color:green;'>Car added successfully!</p>";
        } else {
            echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
        }
    }
    ?>

    <h3>Your Car Inventory</h3>
    <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; margin: 0 auto; border-collapse: collapse;">
        <tr>
            <th>Brand</th>
            <th>Model</th>
            <th>Year</th>
            <th>Price</th>
            <th>Action</th>
        </tr>

        <?php
        
        $result = $conn->query("SELECT * FROM cars WHERE user='$user' ORDER BY id DESC");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . htmlspecialchars($row['brand']) . "</td>
                <td>" . htmlspecialchars($row['model']) . "</td>
                <td>" . $row['year'] . "</td>
                <td>₱" . number_format($row['price']) . "</td>
                <td>
                    <a href='edit.php?id={$row['id']}'>Edit</a> |
                    <a href='delete.php?id={$row['id']}'>Delete</a>
                </td>
            </tr>";
        }
        ?>
    </table>

    <br>
    <a href="logout.php" style="display: inline-block; margin-top: 20px; padding: 5px 10px; border: 1px solid #000; border-radius: 5px; text-decoration: none;">Logout</a>
</div>
