<?php
// Database connection include karein
include 'db.php';

$selected_car = isset($_GET['car']) ? $_GET['car'] : '';
$success = false;

// Database se cars fetch karein dropdown ke liye
try {
    $stmt_cars = $db->query("SELECT name FROM cars");
    $available_cars = $stmt_cars->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $available_cars = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $car_model = trim($_POST['carmodel']);
    $date = trim($_POST['date']);
    $time = trim($_POST['time']);
    
    if(!empty($name) && !empty($email) && !empty($car_model) && !empty($date) && !empty($time)) {
        try {
            // Database mein booking insert karein using prepared statement
            $stmt = $db->prepare("INSERT INTO bookings (fullname, email, phone, car_model, date, time) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $phone, $car_model, $date, $time]);
            $success = true;
        } catch (PDOException $e) {
            $error_message = "Database Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YourCars - Book Test Drive</title>
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
                <li><a href="booking.php" class="active">Book Test Drive</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <div class="booking-wrapper" style="max-width: 700px; margin: 0 auto; background: #ffffff; padding: 2.5rem; border-radius: 12px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.08);">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h1 style="color: #0f172a; font-size: 2rem; margin-bottom: 0.5rem;">Schedule a Test Drive</h1>
                <p style="color: #64748b;">Experience your dream car firsthand. Fill out the details below to book your session.</p>
            </div>
            
            <?php if($success): ?>
                <div class="alert-success" style="text-align: center; padding: 2.5rem;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🎉</div>
                    <h3 style="color: #166534; font-size: 1.5rem; margin-bottom: 1rem;">Booking Confirmed & Saved!</h3>
                    <p style="color: #15803d; font-size: 1.05rem; line-height: 1.6; margin-bottom: 1.5rem;">
                        Thank you, <strong><?php echo htmlspecialchars($name); ?></strong>. Your test drive for the <strong><?php echo htmlspecialchars($car_model); ?></strong> has been successfully booked for <strong><?php echo htmlspecialchars($date); ?></strong> at <strong><?php echo htmlspecialchars($time); ?></strong>. Our team will contact you shortly.
                    </p>
                    <a href="index.php" class="btn" style="padding: 0.75rem 2rem; border-radius: 6px;">Return Home</a>
                </div>
            <?php else: ?>
                <?php if(isset($error_message)): ?>
                    <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem;"><?php echo $error_message; ?></div>
                <?php endif; ?>

                <form id="bookingForm" method="POST" action="booking.php" class="booking-form" onsubmit="return validateBookingForm()">
                    <div class="form-group" style="margin-bottom: 1.25rem;">
                        <label for="fullname" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #334155;">Full Name</label>
                        <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 1rem;">
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label for="email" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #334155;">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="name@example.com" required style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 1rem;">
                        </div>
                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label for="phone" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #334155;">Phone Number</label>
                            <input type="tel" id="phone" name="phone" placeholder="+1 (555) 000-0000" required style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 1rem;">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 1.25rem;">
                        <label for="carmodel" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #334155;">Select Car Model</label>
                        <select id="carmodel" name="carmodel" required style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 1rem; background: #fff;">
                            <option value="">-- Choose Desired Car --</option>
                            <?php foreach($available_cars as $car): ?>
                                <option value="<?php echo htmlspecialchars($car['name']); ?>" <?php if($selected_car == $car['name']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($car['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group" style="margin-bottom: 1.5rem;">
                            <label for="date" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #334155;">Preferred Date</label>
                            <input type="date" id="date" name="date" required style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 1rem;">
                        </div>
                        <div class="form-group" style="margin-bottom: 1.5rem;">
                            <label for="time" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #334155;">Preferred Time Slot</label>
                            <input type="time" id="time" name="time" required style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 1rem;">
                        </div>
                    </div>

                    <button type="submit" class="btn" style="width: 100%; padding: 0.85rem; font-size: 1.05rem; font-weight: 600; border-radius: 6px; cursor: pointer;">Confirm Test Drive Booking</button>
                </form>
            <?php endif; ?>
        </div>
    </main>

    <!-- Professional Footer Bar -->
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-col">
                <h3>YourCars</h3>
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
    <script src="js/booking.js"></script>
</body>
</html>