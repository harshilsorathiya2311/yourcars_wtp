<?php
// Database connection include karein
include 'db.php';

// Database se compare karne ke liye pehli 3 cars fetch karein (ya aap IDs customize kar sakte hain)
$stmt = $db->query("SELECT * FROM cars LIMIT 3");
$compare_cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YourCars - Compare Models</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body>
    <header>
        <div class="logo"><img src="images/logo_app1.png" alt="YourCars Logo" style="height: 30px;"></div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="cars.php">Showroom</a></li>
                <li><a href="compare.php" class="active">Compare</a></li>
                <li><a href="booking.php">Book Test Drive</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <h1>Car Comparison Tool</h1>
        <p>Compare specifications, price, and features side by side.</p>

        <div class="comparison-table-wrapper">
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th>Feature</th>
                        <?php foreach($compare_cars as $car): ?>
                            <th><?php echo htmlspecialchars($car['name']); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Price</strong></td>
                        <?php foreach($compare_cars as $car): ?>
                            <td><?php echo htmlspecialchars($car['price']); ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td><strong>Engine</strong></td>
                        <?php foreach($compare_cars as $car): ?>
                            <td><?php echo htmlspecialchars($car['engine']); ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td><strong>Mileage / Range</strong></td>
                        <?php foreach($compare_cars as $car): ?>
                            <td><?php echo htmlspecialchars($car['mileage']); ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td><strong>Fuel Type</strong></td>
                        <?php foreach($compare_cars as $car): ?>
                            <td><?php echo htmlspecialchars($car['fuel']); ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td><strong>Transmission</strong></td>
                        <?php foreach($compare_cars as $car): ?>
                            <td><?php echo htmlspecialchars($car['transmission']); ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td><strong>Seating</strong></td>
                        <?php foreach($compare_cars as $car): ?>
                            <td><?php echo htmlspecialchars($car['seating']); ?> Seats</td>
                        <?php endforeach; ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
    <script src="js/main.js"></script>
</body>
</html>