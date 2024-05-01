<?php
session_start();
include "./db/dbConnection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>OETS</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <!-- Favicon -->
    <link rel="png" href="./img/favicon.png" type="image/png">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="./lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="./lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="./css/style.css" rel="stylesheet">
    <style>
       #togglePassword {
  /* Adjust font size, color, and position as needed */
  font-size: 12px;
  color: #ccc;
  cursor: pointer;
  right: 30px; /* Adjust for better alignment */
  top: 50%;
  transform: translateY(-70%); /* Vertical alignment adjustment */
}
.set{
    position: relative;
    left: 350px;
}
    </style>
    
</head>

<body>
<!-- Sign In Start -->
<div class="container-fluid">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <a href="index.html" class="">
                        <img src="./img/logo.png" class="w-100" alt="logo">
                    </a>
                </div>
                <h3 class="text-center">Sign In</h3>
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" name="username" class="form-control" id="floatingInput" placeholder="name@example.com" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                        <label for="floatingInput">Username</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
                        <label for="floatingPassword">Password</label>
                        <i id="togglePassword" class="bi bi-eye-slash set fs-6 position-absolute top-50 end-0 translate-middle-y"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <!-- <a href="">Forgot Password</a> -->
                    </div>
                    <button type="submit" name="login" class="btn btn-primary py-3 w-100 mb-4">Login</button>
                    <p class="text-center mb-0">Don't have an Account? <a href="register.php">Sign Up</a></p>
                    <div style="display: none;" id="fail" class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class=" btn close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Username or password is invalid</strong>
                    </div>

                    <script>
                        $(".alert").alert();
                        
                    </script>
                    <script>
                        const togglePassword = document.getElementById('togglePassword');
const passwordInput = document.getElementById('floatingPassword');

togglePassword.addEventListener('click', function () {
  const type = passwordInput.type === 'password' ? 'text' : 'password';
  passwordInput.setAttribute('type', type);

  // Optional: Change icon based on password visibility
  this.classList.toggle('bi-eye'); // Change to 'bi-eye' for visible eye icon (if using Bootstrap Icons)
});
                    </script>
            </div>
            
            </form>

            <?php
            if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve user data from the database
    $sql = "SELECT user_id, username, role_id, password, status FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Check if the user is already logged in
            $existing_session_id = fetchSessionId($conn, $row['user_id']);
            if ($existing_session_id) {
                // User is already logged in from another session
                // echo "User is already logged in from another session.";
                ?>
                <div
                    class="alert alert-danger alert-dismissible fade show"
                    role="alert"
                >
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"
                    ></button>
                
                    <strong>This user</strong> Is Already On Another Session
                </div>
                <?php
                exit();
            }

            // Set session variables
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role_id'] = $row['role_id'];
            $_SESSION['status'] = $row['status'];

            // Store session ID in the database
            storeSessionId($conn, session_id(), $row['user_id']);

            // Redirect user based on role
            redirectToDashboard($row['role_id']);
            exit();
        } else {
            // Password is incorrect
            ?>
            <div
                class="alert alert-danger alert-dismissible fade show"
                role="alert"
            >
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                ></button>
            
                <strong>Password</strong> Is invalid
            </div>
            <?php
            exit();
        }
    } else {
        // User not found
        ?>
            <div
                class="alert alert-danger alert-dismissible fade show"
                role="alert"
            >
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                ></button>
            
                <strong>Username</strong> Is invalid
            </div>
            <?php
        exit();
    }
}

function fetchSessionId($conn, $user_id) {
    $sql = "SELECT session_id FROM active_sessions WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        return $row['session_id'];
    }
    return false;
}

// function storeSessionId($conn, $session_id, $user_id) {
//     $sql = "INSERT INTO active_sessions (session_id, user_id) VALUES (?, ?)";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("si", $session_id, $user_id);
//     $stmt->execute();
// }
function storeSessionId($conn, $session_id, $user_id) {
    $sql = "INSERT INTO active_sessions (session_id, user_id) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE session_id = VALUES(session_id)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $session_id, $user_id);
    $stmt->execute();
  }
function redirectToDashboard($role_id) {
    switch ($role_id) {
        case 1:
            // header("Location: ./Student/student.php");
            echo "<script>window.location.href = './Student/student.php';</script>";
            break;
        case 3:
            // header("Location: ./Teacher/teacher.php");
            echo "<script>window.location.href = './Teacher/teacher.php';</script>";

            break;
        case 4:
            // header("Location: ./Admin/admin.php");
            echo "<script>window.location.href = './Admin/admin.php';</script>";

            break;
        default:
            echo "Role not defined.";
            break;
    }
}
?>
            </div>
    </div>
</div>
<!-- Sign In End -->

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
</body>