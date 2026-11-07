<?php
// Database connection include karein
include 'db.php';

// MySQL database se cars fetch karein
$stmt = $db->query("SELECT * FROM cars");
$featured_cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YourCars - Home</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body>
    <header>
        <div class="logo"><img src="images/logo_app1.png" alt="YourCars Logo" style="height: 30px;"></div>
        <nav>
            <ul>
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="cars.php">Showroom</a></li>
                <li><a href="compare.php">Compare</a></li>
                <li><a href="booking.php">Book Test Drive</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="hero-content">
                <h1>Find Your Dream Car Today</h1>
                <p>Explore luxury, performance, and electric cars with our interactive showroom.</p>
                <a href="cars.php" class="btn">Explore Cars</a>
            </div>
        </section>

        <section class="featured">
            <h2>Featured Models</h2>
            <div class="car-grid">
                <?php foreach($featured_cars as $car): ?>
                <div class="car-card">
                    <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['name']); ?>" style="width: 100%; height: 180px; object-fit: cover;">
                    <div class="car-info">
                        <h3><?php echo htmlspecialchars($car['name']); ?></h3>
                        <p class="brand"><?php echo htmlspecialchars($car['brand']); ?></p>
                        <p class="price"><?php echo htmlspecialchars($car['price']); ?></p>
                        <div class="card-actions">
                            <a href="car-details.php?id=<?php echo $car['id']; ?>" class="btn-sm">View Details</a>
                            <button class="btn-fav" onclick="toggleFavorite(<?php echo $car['id']; ?>, '<?php echo htmlspecialchars($car['name']); ?>')">❤️ Favorite</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <!-- Properly Structured Footer Bar -->
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-col">
                <h3>🚗 YourCars</h3>
                <p>Your premier online destination for exploring, comparing, and booking test drives for the world's finest vehicles.</p>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="cars.php">Showroom</a></li>
                    <li><a href="compare.php">Compare Models</a></li>
                    <li><a href="booking.php">Book Test Drive</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact Us</h4>
                <p>Email: support@yourcars.com</p>
                <p>Phone: +1 (800) 555-CARS</p>
                <p>Location: Ahmedabad, Gujarat</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 YourCars Showroom. All rights reserved.</p>
        </div>
    </footer>

    <script src="js/main.js"></script>
    <script src="js/cars.js"></script>
</body>
</html>