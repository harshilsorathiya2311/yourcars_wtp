<?php
// Database connection include karein
include 'db.php';

// User input (search, brand, fuel) get karein aur sanitize karein
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$brand_filter = isset($_GET['brand']) ? $_GET['brand'] : '';
$fuel_filter = isset($_GET['fuel']) ? $_GET['fuel'] : '';

// Base SQL query
$sql = "SELECT * FROM cars WHERE 1=1";
$params = [];

// Agar search input hai toh query mein add karein
if (!empty($search)) {
    $sql .= " AND (name LIKE ? OR brand LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

// Agar brand filter select kiya hai toh add karein
if (!empty($brand_filter)) {
    $sql .= " AND brand = ?";
    $params[] = $brand_filter;
}

// Agar fuel filter select kiya hai toh add karein
if (!empty($fuel_filter)) {
    $sql .= " AND fuel = ?";
    $params[] = $fuel_filter;
}

// Query prepare aur execute karein (PDO secure method)
$stmt = $db->prepare($sql);
$stmt->execute($params);
$filtered_cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YourCars - Showroom</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>
<body>
    <header>
        <div class="logo"><img src="images/logo_app1.png" alt="YourCars Logo" style="height: 30px;"></div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="cars.php" class="active">Showroom</a></li>
                <li><a href="compare.php">Compare</a></li>
                <li><a href="booking.php">Book Test Drive</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <h1>Car Showroom & Inventory</h1>
        
        <!-- Search and Filter Form -->
        <div class="filters-bar">
            <form method="GET" action="cars.php">
                <input type="text" name="search" placeholder="Search by name or brand..." value="<?php echo htmlspecialchars($search); ?>">
                
                <select name="brand">
                    <option value="">All Brands</option>
                    <option value="Tesla" <?php if($brand_filter=='Tesla') echo 'selected'; ?>>Tesla</option>
                    <option value="BMW" <?php if($brand_filter=='BMW') echo 'selected'; ?>>BMW</option>
                    <option value="Audi" <?php if($brand_filter=='Audi') echo 'selected'; ?>>Audi</option>
                    <option value="Porsche" <?php if($brand_filter=='Porsche') echo 'selected'; ?>>Porsche</option>
                </select>

                <select name="fuel">
                    <option value="">All Fuel Types</option>
                    <option value="Electric" <?php if($fuel_filter=='Electric') echo 'selected'; ?>>Electric</option>
                    <option value="Petrol" <?php if($fuel_filter== 'Petrol') echo 'selected'; ?>>Petrol</option>
                    <option value="Hybrid" <?php if($fuel_filter== 'Hybrid') echo 'selected'; ?>>Hybrid</option>
                </select>

                <button type="submit" class="btn-sm">Filter</button>
            </form>
        </div>

        <!-- Car Grid Display -->
        <div class="car-grid" id="carListContainer">
            <?php if(count($filtered_cars) > 0): ?>
                <?php foreach($filtered_cars as $car): ?>
                <div class="car-card">
                    <img src="<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['name']); ?>" style="width: 100%; height: 180px; object-fit: cover;">
                    <div class="car-info">
                        <h3><?php echo htmlspecialchars($car['name']); ?></h3>
                        <p class="brand"><?php echo htmlspecialchars($car['brand']); ?> | <?php echo htmlspecialchars($car['fuel']); ?></p>
                        <p class="price"><?php echo htmlspecialchars($car['price']); ?></p>
                        <div class="card-actions">
                            <a href="car-details.php?id=<?php echo $car['id']; ?>" class="btn-sm">View Details</a>
                            <button class="btn-fav" onclick="toggleFavorite(<?php echo $car['id']; ?>, '<?php echo htmlspecialchars($car['name']); ?>')">❤️ Favorite</button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-results">No cars found matching your criteria.</p>
            <?php endif; ?>
        </div>
    </main>
    <script src="js/main.js"></script>
    <script src="js/cars.js"></script>
</body>
</html>