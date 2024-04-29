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
</head>

<body>
<div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <!-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> -->
        <!-- Spinner End -->


        <!-- Sign Up Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <a href="index.html" class="">
                                <img src="./img/logo.png" class="w-100" alt="logo">
                            </a>
                        </div>
                        <h3 class="text-center">Sign Up</h3>
                        <!-- <form action="register.php" method="post"> -->
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                            <div class="form-floating mb-3">
                                <input type="text" name="name" class="form-control" id="floatingText" placeholder="jhondoe" required>
                                <label for="floatingText">Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="username" class="form-control" id="floatingText" placeholder="jhondoe" required>
                                <label for="floatingText">Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                                <label for="floatingInput">Email address</label>

                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                                <label for="floatingPassword">Password</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="file" name="user_photo" class="form-control" required>
                                <label for="floatingPassword">profile Pic</label>
                            </div>
                            <div class="alert alert-success" id="success" style="margin-top:10px;display:none;">
                                <strong>Success!</strong> Account Registered Successfully
                            </div>

                            <div class="alert alert-danger" id="failure" style="margin-top:10px;display:none;">
                                <strong>Already Exist!</strong> The UserAlready Registered
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary py-3 w-100 mb-4">Sign Up</button>
                            <p class="text-center mb-0">Already have an Account? <a href="index.php">Sign In</a></p>
                    </div>


                    <?php
if(isset($_SESSION['username'])){
    ?>
        <script>
            window.location.href = "./Admin/admin.php";
        </script>
    <?php
}


if (isset($_POST['submit'])) {
    $pass = $_POST['password'];
    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
    function validate_image_type($file_type)
    {
        return in_array($file_type, ['image/jpeg', 'image/png', 'image/jpg']);
    }
    $user_photo = $_FILES['user_photo'];
    if ($user_photo['error'] == 0) {
        if (!validate_image_type($user_photo['type'])) {
            $photo_error = 'Only Jpeg Jpg And Png Files Are allowed';
        }
    }
    $photo_path = '';
    if ($user_photo['error'] == 0) {
        $photo_name = uniqid() . '_' . $user_photo['name'];
        $photo_path = './img/' . $photo_name;
        move_uploaded_file($user_photo['tmp_name'], $photo_path);
    }
    $count = 0;
    $res = mysqli_query($conn, "SELECT *From users where username = '$_POST[username]'");
    $count = mysqli_num_rows($res);
    if ($count > 0) {
?>
        <script>
            document.getElementById('success').style.display = 'none';
            document.getElementById('failure').style.display = "block";
        </script>
    <?php
    } else {
        mysqli_query($conn, "INSERT INTO users(name,email,username,password,user_photo) VALUES ('$_POST[name]','$_POST[email]','$_POST[username]','$hashedPassword','$photo_path')");
    ?>
        <script>
            document.getElementById('success').style.display = "block";
            document.getElementById('failure').style.display = "none";
        </script>
<?php
    }
}
?>

                    </form>
                </div>
            </div>
        </div>
        <!-- Sign Up End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>