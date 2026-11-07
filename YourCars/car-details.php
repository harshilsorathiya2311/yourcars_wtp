<?php
// Database connection include karein
include 'db.php';

// URL se car ID get karein (default 1)
$car_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Database se specific car ki details fetch karein
$stmt = $db->prepare("SELECT * FROM cars WHERE id = ?");
$stmt->execute([$car_id]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

// Agar car database mein na mile toh pehli car default utha lein
if (!$car) {
    $stmt_fallback = $db->query("SELECT * FROM cars LIMIT 1");
    $car = $stmt_fallback->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YourCars - <?php echo htmlspecialchars($car['name']); ?></title>
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
                <li><a href="compare.php">Compare</a></li>
                <li><a href="booking.php">Book Test Drive</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <div class="details-container">
            <!-- Dynamic Car Image Display -->
            <div class="details-image">
                <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['name']); ?>" style="width: 100%; height: 350px; object-fit: cover; border-radius: 8px;">
            </div>
            
            <div class="details-info">
                <h1><?php echo htmlspecialchars($car['name']); ?></h1>
                <p class="brand">Brand: <?php echo htmlspecialchars($car['brand']); ?></p>
                <p class="price-tag"><?php echo htmlspecialchars($car['price']); ?></p>
                <p class="desc"><?php echo htmlspecialchars($car['description']); ?></p>

                <ul class="specs-list">
                    <li><strong>Engine:</strong> <?php echo htmlspecialchars($car['engine']); ?></li>
                    <li><strong>Mileage / Range:</strong> <?php echo htmlspecialchars($car['mileage']); ?></li>
                    <li><strong>Fuel Type:</strong> <?php echo htmlspecialchars($car['fuel']); ?></li>
                    <li><strong>Transmission:</strong> <?php echo htmlspecialchars($car['transmission']); ?></li>
                    <li><strong>Seating Capacity:</strong> <?php echo htmlspecialchars($car['seating']); ?> Persons</li>
                </ul>

                <div class="action-buttons">
                    <a href="booking.php?car=<?php echo urlencode($car['name']); ?>" class="btn">Book Test Drive</a>
                    <button class="btn-fav" onclick="toggleFavorite(<?php echo $car['id']; ?>, '<?php echo htmlspecialchars($car['name']); ?>')">❤️ Add to Favorites</button>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 YourCars Showroom. All rights reserved.</p>
    </footer>

    <script src="js/main.js"></script>
    <script src="js/cars.js"></script>
</body>
</html>