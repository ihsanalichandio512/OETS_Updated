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
                <div class="container-fluid pt-4 px-4">
                    <div class="row g-4">
                        <?php
                        // $getExamCheck = "SELECT * FROM `exams` WHERE exams.exam_status = 'active'";
                        $getExamCheck = "SELECT exams.*,
                        TIMESTAMPDIFF(DAY, CURDATE(), exams.start_datetime) AS days_until_start
                    FROM exams
                    INNER JOIN (
                        SELECT exam_id
                        FROM true_false_question
                        WHERE is_completed = 'not_completed'
                        UNION
                        SELECT exam_id
                        FROM multiple_choice_questions
                        WHERE is_completed = 'not_completed'
                        UNION
                        SELECT exam_id
                        FROM questions
                        WHERE is_completed = 'not_completed'
                        UNION
                        SELECT exam_id
                        FROM fill_in_the_blanks
                        WHERE is_completed = 'not_completed'
                    ) AS incomplete_exams
                    ON exams.exam_id = incomplete_exams.exam_id
                    WHERE exams.exam_status = 'active'
                        AND DATE(exams.start_datetime) = CURDATE();
                    
                    ";
                        $isCheated  = "SELECT * FROM users WHERE users.is_cheated = 'no' AND users.is_completed = 'not_completed' AND users.role_id = 1";

                        $setuser = mysqli_query($conn, $isCheated);
                        $set = mysqli_query($conn, $getExamCheck);
                        $row = mysqli_fetch_array($set);

                        if (mysqli_num_rows($set) && mysqli_num_rows($setuser) > 0) {
                        ?>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded d-flex align-items-center justify-content-center p-4">
                                    <div class="ms-3">
                                        <p class="mb-2">Give Exam</p>
                                        <a href="./give_exam.php" class="mb-0"><input type="button" class="btn btn-primary " value="Give Exam"></a>
                                    </div>
                                </div>
                            </div>

                        <?php
                        } else {
                        ?>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded d-flex align-items-center justify-content-center p-4">
                                    <div class="ms-3">
                                        <p class="mb-2 disabled"><strong>Exam Will Be Soon</strong></p>
                                        <input type="button" class="btn btn-primary disabled" value="Exam Will Be Soon">
                                    </div>
                                </div>
                            </div>

                        <?php
                        }
                        ?>

                        <?php
                        $getUser_id = $_SESSION['user_id'];
                        $sql = "
                        SELECT users.*
                        FROM users
                        WHERE users.user_id = 4
                        AND (
                            (SELECT COUNT(*) FROM true_false_question WHERE true_false_question.is_completed = 'completed' AND user_id = 4) > 0
                            AND
                            (SELECT COUNT(*) FROM multiple_choice_questions WHERE multiple_choice_questions.is_completed = 'completed' AND user_id = 4) > 0
                            AND
                            (SELECT COUNT(*) FROM fill_in_the_blanks WHERE fill_in_the_blanks.is_completed = 'completed' AND user_id = 4) > 0
                            AND
                            (SELECT COUNT(*) FROM questions WHERE questions.is_completed = 'completed' AND user_id = 4 AND questions.is_right = 'right') > 0 
                        );

                        ";
                        $settt = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($settt) > 0) {
                        ?>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded d-flex align-items-center justify-content-center p-4">
                                    <div class="ms-3">
                                        <p class="mb-2">Get Result</p>
                                       <form action="" method="post">
                                           <!-- <a href="./result.php" type="submit" name="get_result" class="mb-0 btn btn-primary">Get Result</a> -->
                                           <input type='submit' name="get_result" value="get Result" class="btn btn-info">
                                        </form>
                                           
                                        <?php
                                        $geting_fill_in_the_blanks = "
                                            SELECT
                                            SUM(CASE WHEN fill_in_the_blanks.correct_answer = answers.answer_text THEN 1 ELSE 0 END) AS total_fill_in_the_blanks_marks
                                            FROM fill_in_the_blanks
                                            INNER JOIN answers ON answers.exam_id = fill_in_the_blanks.exam_id AND answers.question_type = 'fill_in_the_blanks'
";

                                        $fetch_marks = mysqli_query($conn, $geting_fill_in_the_blanks);

                                        $row = mysqli_fetch_assoc($fetch_marks);
                                        $fill_in_the_blanks_marks = $row['total_fill_in_the_blanks_marks'];


                                        // mcqs marks
                                        $getting_mcqs_marks = "
                                        SELECT
                                        SUM(CASE WHEN answers.answer_text = multiple_choice_questions.correct_option THEN multiple_choice_questions.question_mark ELSE 0 END) AS multiple_choice_questions_score
                                        FROM multiple_choice_questions
                                        INNER JOIN answers ON multiple_choice_questions.exam_id = answers.exam_id
                                        WHERE answers.question_type = 'multiple_choice_questions' AND answers.question_id = multiple_choice_questions.question_id
                                        ";
                                        $fetch_mcq_marks = mysqli_query($conn, $getting_mcqs_marks);

                                        $row2 = mysqli_fetch_assoc($fetch_mcq_marks);
                                        $mcqs_marks = $row2['multiple_choice_questions_score'];

                                        //

                                        // long answers 
                                        $getting_long_answers = "
                                            SELECT
                                        SUM(CASE WHEN  questions.is_right = 'right' THEN questions.question_mark ELSE 0 END) AS long_answers_marks
                                        FROM questions
                                        INNER JOIN answers ON questions.exam_id = answers.exam_id
                                        WHERE answers.question_type = 'long_answer' AND answers.question_id = questions.question_id
                                            ";
                                        $fetch_long_answer = mysqli_query($conn, $getting_long_answers);

                                        $row3 = mysqli_fetch_assoc($fetch_long_answer);
                                        $long_answer_marks = $row3['long_answers_marks'];
                                        // 

                                        // true fasle marks 
                                        $getting_true_false = "
                                        SELECT
                                        SUM(CASE WHEN  true_false_question.correct_answer = answers.answer_text THEN true_false_question.question_mark ELSE 0 END) AS `true_false_question_marks`
                                        FROM true_false_question
                                        INNER JOIN answers ON true_false_question.exam_id = answers.exam_id
                                        WHERE answers.question_type = 'true_false_question' AND answers.question_id = true_false_question.question_id                                            
                                        ";
                                        $fetch_true = mysqli_query($conn, $getting_true_false);

                                        $row4 = mysqli_fetch_assoc($fetch_true);
                                        $true_false_marks = $row4['true_false_question_marks'];
                                // 
                                        $get_more_detail = "
                                        SELECT
                                        answers.student_id,
                                        exams.semester_id,
                                        answers.batch_id,
                                        exams.exam_id,
                                        COUNT(*) AS total_attempted_questions
                                        FROM answers
                                        INNER JOIN exams ON answers.exam_id = exams.exam_id
                                        INNER JOIN semesters ON answers.semester_id = semesters.semester_id
                                        INNER JOIN batches ON answers.batch_id = batches.batch_id
                                        GROUP BY answers.student_id, semesters.semester_id, batches.batch_id, exams.exam_id;

                                        ";

                                        $fetch_more = mysqli_query($conn, $get_more_detail);

                                        $row5 = mysqli_fetch_assoc($fetch_more);
                                        $student_id = $_SESSION['user_id'];
                                        $semester_id = $_SESSION['semester_id'];
                                        $exam_id = $row5['exam_id'];
                                        $batch_id = $row5['batch_id'];
                                        $total_attempted_questions = $row5['total_attempted_questions'];
                                        $total_marks = $fill_in_the_blanks_marks + $mcqs_marks + $long_answer_marks + $true_false_marks;

                                        if (isset($_POST['get_result'])) {
                                            $insert_into_exam_result = "
                                            INSERT INTO `exam_results`(`student_id`, `exam_id`, `semester_id`, `batch_id`, `long_answer_score`, `mcq_score`, `true_false_score`, `fill_in_the_blanks_score`, `score`, `total_questions`) VALUES ('$student_id','$exam_id','$semester_id','$batch_id','$long_answer_marks','$mcqs_marks','$true_false_marks','$fill_in_the_blanks_marks','$total_marks','$total_attempted_questions')
                                            ";
                                           
                                            $run_query = mysqli_query($conn,$insert_into_exam_result);
                                            if($run_query){
                                                echo "<script>window.location.href = './result.php'</script>";
                                            }else{
                                                
                                                echo "<div class='alert alert-danger'>Error</div>";
                                            }

                                        }


                                        ?>

                                    </div>
                                </div>
                            </div>

                        <?php
                        } else {
                        ?>
                            <div class="col-sm-7 col-xl-5">
                                <div class="bg-light rounded d-flex align-items-center justify-content-center p-4">
                                    <div class="ms-3">
                                        <p class="mb-1">Complete Exams To Get Result</p>
                                        <input type="button" class="btn btn-primary disabled" value="Result Will Be Soon">
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <?php

                        ?>

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