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
                                <h3 class="text-center">Add Semester</h3>
                                <!-- <form action="register.php" method="post"> -->
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <input type="text" name="semester" class="form-control" required id="inputEmail3" placeholder="Semester Title">
                                        </div>
                                    </div>


                                    <button type="submit" name="submit" class="btn btn-primary py-3 w-100 mb-4">Add Semester</button>
                            </div>

                            </form>
                            <?php

                            if (isset($_POST['submit'])) {
                                $semester = $_POST['semester'];

                                if (!$conn) {
                                    die("Connection failed: " . mysqli_connect_error());
                                }

                                // Check if the semester already exists
                                $checkSql = "SELECT * FROM semesters WHERE semester_name = '$semester'";
                                $checkResult = mysqli_query($conn, $checkSql);

                                if (mysqli_num_rows($checkResult) > 0) {
                                    // Semester already exists
                            ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <button type="button" class="close btn" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <strong>Data Already Added</strong>
                                    </div>
                                    <script>
                                        $(".alert").alert();
                                    </script>
                                    <?php
                                } else {
                                    // Semester does not exist, perform the insertion
                                    $insertSql = "INSERT INTO semesters (semester_name) VALUES ('$semester')";
                                    $insertResult = mysqli_query($conn, $insertSql);

                                    if ($insertResult) {
                                        // Insertion successful
                                    ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <button type="button" class="close btn" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <strong>Data Added Successfully</strong>
                                        </div>
                                        <script>
                                            $(".alert").alert();
                                        </script>
                                    <?php
                                    } else {
                                        // Insertion failed
                                    ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <button type="button" class="close btn" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <strong>Failed to add data</strong>
                                        </div>
                                        <script>
                                            $(".alert").alert();
                                        </script>
                            <?php
                                    }
                                }
                            }
                            ?>

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Semester Id</th>
                                        <th scope="col">Semester Name</th>
                                        <th scope="col">actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM semesters";
                                    $check = mysqli_query($conn, $sql);

                                    while ($row = mysqli_fetch_array($check)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $row['semester_id']?></td>
                                            <td><?php echo $row['semester_name']?></td>
                                            <td>
                                                 <button class="btn btn-danger btn-sm m-2" onclick="confirmDelete(<?php echo $row['semester_id']; ?>)">Delete</button>
                                            </td>
                                        </tr>
                                    <?php
                                    }

                                    ?>
                                    <script>
                                        function confirmDelete(id) {
                                            var x = confirm("Are you sure you want to delete?");
                                            if (x) {
                                                window.location = "delete_semester.php?id=" + id;
                                            }
                                        }
                                    </script>

                                </tbody>
                            </table>

                        </div>
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