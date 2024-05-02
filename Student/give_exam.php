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
    $getExamCheck = "SELECT *,
    TIMESTAMPDIFF(DAY, CURDATE(), start_datetime) AS days_until_start
FROM `exams`
WHERE exams.exam_status = 'active'
AND DATE(start_datetime) = CURDATE()
";
                    $isCheated  = "SELECT * FROM users WHERE users.is_cheated = 'no' AND users.is_completed = 'not_completed' AND users.role_id = 1";
                    $setuser = mysqli_query($conn,$isCheated);
                    $set = mysqli_query($conn,$getExamCheck);
                    if(mysqli_num_rows($set) && mysqli_num_rows($setuser)>0){
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
           
            <div class="content">
                <div class="container-fluid">
                    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                        <div class="col-12 col-sm-10 col-md-9 col-lg-8 col-xl-8">
                            <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                                <div class="d-flex align-items-center justify-content-center mb-3">  
                                </div>
                                <h3 class="text-center">Fetch Exam</h3>
                                <div class="form-floating mb-3">
                                    <?php
                                    // $sql = "SELECT fill_in_the_blanks.* , exams.* FROM fill_in_the_blanks INNER JOIN exams ON fill_in_the_blanks.exam_id = exams.exam_id WHERE exams.exam_status = 'active' AND exams.exam_id = fill_in_the_blanks.exam_id";
                                    $sql = "SELECT fill_in_the_blanks.* , exams.* FROM fill_in_the_blanks INNER JOIN exams ON fill_in_the_blanks.exam_id = exams.exam_id WHERE exams.exam_status = 'active' AND exams.exam_id = fill_in_the_blanks.exam_id AND fill_in_the_blanks.is_completed = 'not_completed'";
                                    $query = mysqli_query($conn, $sql);
                                    if(mysqli_num_rows($query)>0){
                                        ?>
                                        <a href="./fill_in_the_blanks.php"><button type="button" class="btn btn-primary m-2">Fill in the Blanks</button></a>
                                        <?php
                                    }else{
                                        ?>
                                        <button type="button"  class="disabled btn btn-primary m-2">Exam will Be Soon</button>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    $sql = "SELECT multiple_choice_questions.* , exams.* FROM multiple_choice_questions INNER JOIN exams ON multiple_choice_questions.exam_id = exams.exam_id WHERE exams.exam_status = 'active' AND exams.exam_id = multiple_choice_questions.exam_id";
                                    $query = mysqli_query($conn, $sql);
                                    if(mysqli_num_rows($query)>0){
                                        ?>
                                        <a href="./mcqs.php"><button type="button" class="btn btn-primary m-2">MCQS</button></a>
                                        <?php
                                    }else{
                                        ?>
                                        <button type="button"  class="disabled btn btn-primary m-2">Exam will Be Soon</button>
                                        <?php
                                    }
                                    ?>

<?php
                                    $sql = "SELECT questions.* , exams.* FROM questions INNER JOIN exams ON questions.exam_id = exams.exam_id WHERE exams.exam_status = 'active' AND exams.exam_id = questions.exam_id";
                                    $query = mysqli_query($conn, $sql);
                                    if(mysqli_num_rows($query)>0){
                                        ?>
                                        <a href="./questions.php"><button type="button" class="btn btn-primary m-2">Long Answers</button></a>
                                        <?php
                                    }else{
                                        ?>
                                        <button type="button"  class="disabled btn btn-primary m-2">Exam will Be Soon</button>
                                        <?php
                                    }
                                    ?>
<?php
                                    $sql = "SELECT true_false_question.* , exams.* FROM true_false_question INNER JOIN exams ON true_false_question.exam_id = exams.exam_id WHERE exams.exam_status = 'active' AND exams.exam_id = true_false_question.exam_id";
                                    $query = mysqli_query($conn, $sql);
                                    if(mysqli_num_rows($query)>0){
                                        ?>
                                        <a href="./true_false_question.php"><button type="button" class="btn btn-primary m-2">True False Question</button></a>
                                        <?php
                                    }else{
                                        ?>
                                        <button type="button"  class="disabled btn btn-primary m-2">Exam will Be Soon</button>
                                        <?php
                                    }
                                    ?>
                                
                                    
                            </div>


                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                               
                                </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>

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
    header("location:./student.php");
} 
}else {
    header("location:./student.php");
}
?>