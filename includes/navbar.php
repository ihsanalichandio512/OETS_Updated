<?php

// Check if user is logged in
if(isset($_SESSION['user_id']) && isset($_SESSION['role_id'])) {
    // User is logged in
    // Fetch user details from the database using user_id from session
    include_once "head.php";

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch user details from the database
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT name, user_photo, role_name FROM users JOIN roles ON users.role_id = roles.role_id WHERE user_id = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $user_name = $row['name'];
        $user_photo = $row['user_photo'];
        $user_role = $row['role_name'];
    }
} else {
    // User is not logged in, you can handle this case accordingly
    // For example, redirect to login page
    header("Location: index.php");
    exit();
}
?>
<!-- Navbar Start -->
<nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="admin_dashboard.php" class="navbar-brand d-flex d-lg-none me-4">
                    <img src="../img/logo.png" alt="logo" class="w-100">
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto">
                    
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <?php if (!empty($user_photo)) { ?>
                    <img class="rounded-circle" src=".<?php echo $user_photo; ?>" alt="User Photo" style="width: 40px; height: 40px;">
                <?php } ?>
                            <span class="d-none d-lg-inline-flex"><?php echo $user_name; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">My Profile</a>
                            <a href="#" class="dropdown-item">Settings</a>
                            <a href="../logout.php" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->

            
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./lib/chart/chart.min.js"></script>
    <script src="./lib/easing/easing.min.js"></script>
    <script src="./lib/waypoints/waypoints.min.js"></script>
    <script src="./lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="./lib/tempusdominus/js/moment.min.js"></script>
    <script src="./lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="./lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="./js/main.js"></script>