<?php
session_start();

include "../db/dbConnection.php";
if ($_SESSION['role_id'] == 1) {
    header("location:../Student/student.php");
} elseif ($_SESSION['role_id'] == 4) {
    header("location:../Admin/admin.php");
} elseif ($_SESSION['role_id'] == 3) {
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
        <link rel="png" href="../img/favicon.png" type="image/png">

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
                <!-- cards Code Starts Here -->

                <div class="container-fluid pt-4 px-4">
                    <div class="row g-4">

                <?php
                $getExam_id = "SELECT exams.exam_id FROM fill_in_the_blanks INNER JOIN exams ON fill_in_the_blanks.exam_id = exams.exam_id";
                $exam_id_query = mysqli_query($conn, $getExam_id);
                $get_exam_id_as = mysqli_fetch_array($exam_id_query);
                $GET_ID_OF_EXAM =  $get_exam_id_as['exam_id'];

                $sql = "SELECT * from questions where exam_id  = '$GET_ID_OF_EXAM'";
                $query = mysqli_query($conn,$sql);
                ?>
<table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">question_Id</th>
                                    <th scope="col">question_text</th>
                                    <th scope="col">Mark</th>
                                    <th scope="col">Is Right</th>
                                    <th scope="col">Exam_id</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                while($row = mysqli_fetch_array($query)){
                   ?>

                                <tr>
                                        <td><?php echo $row['question_id']; ?></td>
                                        <td><?php echo $row['question_text']; ?></td>
                                        <td><?php echo $row['question_mark']; ?></td>
                                        <td><?php echo $row['is_right']; ?></td>
                                        <td><?php echo $row['exam_id']; ?></td>
                                        <td>
                                            <a href="./update_long_answer.php?id=<?php echo $row['question_id']; ?>"><button class="btn btn-success m-2">right</button></a>
                                        </td>

                                        </tr>
                                        <?php
                }
                ?>
                               



                            </tbody>

                
                    </div>
                </div>
                <!-- cards code ends here -->
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
    header("location:../index.php");
}
?>