<?php
session_start();
include "../db/dbConnection.php";
if ($_SESSION['role_id'] == 3) {
    header("location:../Teacher/teacher.php");
} elseif ($_SESSION['role_id'] == 4) {
    header("location:../Admin/admin.php");
} elseif ($_SESSION['role_id'] == 1) {
    if (!$_SESSION['username']) {
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
        <div class="content">
            <div class="container-fluid">
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                            <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                                <div class="form-floating mb-3">
                                    <?php
                                    $get_semester_id = $_SESSION['semester_id'];
                                    $get_exam = "SELECT * FROM exams WHERE exams.semester_id = '$get_semester_id'";
                                    $result = mysqli_query($conn, $get_exam);
                                    if (mysqli_num_rows($result) > 0) {
                                       ?>
                                         <select class="form-select form-select-sm mb-3" aria-label=".form-select-sm example">
                                        <option selected disabled>Select Exam Type</option>
                                        <?php
                                        while($row = mysqli_fetch_array($result)){
                                            ?>
                                        <option value="<?php echo $row['exam_id']?>"><?php echo $row['exam_type']; ?></option>
                                            <?php
                                        }
                                        ?>
                            </select>
                                       <?php
                                    }
                                    ?>
                                </div>
                            </div>
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
} else {
    header("location:./student.php");
}
?>