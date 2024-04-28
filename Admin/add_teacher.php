<?php
session_start();
include "../db/dbConnection.php";
if($_SESSION['role_id']==1){
    header("location:../Student/student.php");
}elseif($_SESSION['role_id']==3){
    header("location:../Teacher/teacher.php");
}elseif($_SESSION['role_id']==4){
    if(!$_SESSION['username']){
        header("location:../index.php");
    }
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
        <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="../lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

        <!-- Customized Bootstrap Stylesheet -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <!-- Template Stylesheet -->
        <link href="../css/style.css" rel="stylesheet">
    </head>

    <body>
        <div class="container-xxl position-relative bg-white d-flex p-0">
            <!-- Spinner Start -->
            <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <!-- Spinner End -->
            <?php
            include "../includes/sidebar.php";
            ?>
            <div class="content">

                <?php
                include "../includes/navbar.php";
                ?>

                <div class="container-fluid">
                    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                            <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                                <div class="d-flex align-items-center justify-content-center mb-3">
                                    <a href="index.html" class="">
                                        <img src="../img/logo.png" class="w-100" alt="logo">
                                    </a>
                                </div>

                                <?php
                                $sql = "SELECT users.user_id, users.name FROM users";
                                $query = mysqli_query($conn, $sql);


                                ?>

                                <h3 class="text-center">Add Teacher</h3>
                                <!-- <form action="register.php" method="post"> -->
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">

                                    <select name="teacher" class="form-select mb-3" aria-label="Default select example">
                                        <option selected disabled>Select Teacher</option>
                                        <?php

                                        while ($row = mysqli_fetch_array($query)) {

                                        ?>
                                            <option value="<?php echo $row['user_id'] ?>"><?php echo $row['name']; ?></option>
                                        <?php
                                        }

                                        ?>
                                    </select>

                                    <div class="alert alert-success" id="success" style="margin-top:10px;display:none;">
                                        <strong>Success!</strong> Account Registered Successfully
                                    </div>

                                    <div class="alert alert-danger" id="failure" style="margin-top:10px;display:none;">
                                        <strong>Already Exist!</strong> The UserAlready Registered
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-primary py-3 w-100 mb-4">Add Teacher</button>
                            </div>

                            </form>
                            <?php
                            if (isset($_POST['submit'])) {
                                $getTeacherName = $_POST['teacher'];

                                if (!$conn) {
                                    die("Connection failed: " . mysqli_connect_error());
                                }
                                $checkSql = "SELECT user_id from teachers where user_id = '$getTeacherName'";
                                $result = mysqli_query($conn, $checkSql);
                                if (mysqli_num_rows($result) > 0) {
                                    // User ID already exists
                            ?>
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <button type="button" class="close btn" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <strong>Data Already Exist</strong>
                                    </div>
                                    <script>
                                        $(".alert").alert();
                                    </script>
                                    <?php
                                } else {
                                    $insertSql = "INSERT INTO `teachers`(`user_id`) VALUES ('$getTeacherName')";
                                    $done = mysqli_query($conn, $insertSql);
                                    $insertRole = "UPDATE `users` SET `role_id`='3' WHERE user_id = '$getTeacherName'";
                                    $updRole = mysqli_query($conn, $insertRole);
                                    if ($done && $updRole) {
                                    ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <button type="button" class="close btn" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <strong>Data Has Been Added</strong>
                                        </div>
                                        <script>
                                            $(".alert").alert();
                                        </script>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <button type="button" class="close btn" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <strong>Can't Add Data</strong>
                                        </div>
                                        <script>
                                            $(".alert").alert();
                                        </script>
                            <?php
                                    }
                                }
                            }
                            ?>


                        </div>


                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Teacher Id</th>
                                    <th scope="col">Photo</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $sql = "SELECT teachers.*, users.* 
FROM teachers 
INNER JOIN users ON teachers.user_id = users.user_id 
WHERE users.role_id = 3";

                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                        <tr>
                                            <th scope="row"><?php echo $row['teacher_id']; ?></th>
                                            <?php
                                            // Assuming you have retrieved $row from the database
                                            $imagePath = $row['user_photo'];
                                            ?>
                                            <td><img class="img-fluid rounded-circle" style="width: 40px; height: 40px;" src="../img<?php echo $imagePath; ?>" /></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td>
                                                <button class="btn btn-danger m-2" onclick="confirmDelete(<?php echo $row['teacher_id']; ?>)">Delete</button>

                                            </td>

                                        </tr>
                                <?php
                                    }
                                } else {
                                }

                                mysqli_close($conn);
                                ?>




                            </tbody>
                        </table>
                        <script>
                            function confirmDelete(userId) {
                                // Display confirmation dialog
                                var confirmDelete = confirm("Are you sure you want to delete this user?");

                                // If user confirms deletion, redirect to delete script
                                if (confirmDelete) {
                                    window.location.href = "teacher-delete.php?id=" + userId;
                                }
                            }

                            function confirmUpdate(userId) {
                                // Display confirmation dialog
                                var confirmUpdate = confirm("Are you sure you want to update this user?");

                                // If user confirms update, redirect to update script
                                if (confirmUpdate) {
                                    window.location.href = "update_teacher.php?id=" + userId;
                                }
                            }
                        </script>

                    </div>
                </div>


            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../lib/chart/chart.min.js"></script>
        <script src="../lib/easing/easing.min.js"></script>
        <script src="../lib/waypoints/waypoints.min.js"></script>
        <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="../lib/tempusdominus/js/moment.min.js"></script>
        <script src="../lib/tempusdominus/js/moment-timezone.min.js"></script>
        <script src="../lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

        <!-- Template Javascript -->
        <script src="../js/main.js"></script>
    </body>

    </html>

    <?php
}else{
    header("location:../index.php");
}

?>