<?php
session_start();
include "../db/dbConnection.php";
if ($_SESSION['role_id'] == 4) {
    header("location:../Admin/admin.php");
} elseif ($_SESSION['role_id'] == 3) {
    header("location:../Teacher/teacher.php");
} elseif ($_SESSION['role_id'] == 1) {
    if (!$_SESSION['username']) {
        header("location:../index.php");
    }
    $getExamCheck = "SELECT *,
    TIMESTAMPDIFF(DAY, CURDATE(), start_datetime) AS days_until_start
FROM `exams`
WHERE exams.exam_status = 'active'
AND start_datetime = CURDATE()
OR DATEDIFF(start_datetime, CURDATE()) = 1";
    $isCheated  = "SELECT * FROM users WHERE users.is_cheated = 'no' AND users.is_completed = 'not_completed' AND users.role_id = 1";
    $setuser = mysqli_query($conn, $isCheated);
    $set = mysqli_query($conn, $getExamCheck);
    if (mysqli_num_rows($set) && mysqli_num_rows($setuser) > 0) {
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
            <!-- code for disable copy cut paste right click and selection -->
            <!-- <script>
                // Disable copy-paste
                document.addEventListener('copy', function(event) {
                    event.preventDefault();
                });

                document.addEventListener('cut', function(event) {
                    event.preventDefault();
                });

                document.addEventListener('paste', function(event) {
                    event.preventDefault();
                });

                // Disable right-click
                document.addEventListener('contextmenu', function(event) {
                    event.preventDefault();
                });

                // Disable text selection
                document.addEventListener('selectstart', function(event) {
                    event.preventDefault();
                });

                // Disable keyboard shortcuts
                document.addEventListener('keydown', function(event) {
                    if ((event.ctrlKey || event.metaKey) && (event.keyCode == 67 || event.keyCode == 86 || event.keyCode == 88)) {
                        event.preventDefault();
                    }
                });
            </script> -->
            <!-- ends here -->
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


                <div class="container-fluid">
                    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                            <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">

                                <h3 class="text-center">MCQS</h3>
                                <?php
                                if (isset($_POST['submit'])) {
                                    // Loop through each POST variable
                                    foreach ($_POST as $key => $value) {
                                        // Check if the POST variable represents an answer
                                        if (strpos($key, 'answer_') !== false) {
                                            // Extract question ID from the POST variable
                                            $question_id = substr($key, strlen('answer_'));

                                            // Get the selected option from the POST data
                                            $selected_option = $_POST[$key];
                                            $getUser_id = $_SESSION['user_id'];
                                                $getUserSemester = $_SESSION['semester_id'];
                                            // Insert the answer into the answers table
                                            // $insert_answer_query = "INSERT INTO answers ( question_id, user_id, semester_id,exam_id, answer_text) VALUES ('$question_id','$getUser_id','$getUserSemester','$selected_option')";
                                            $insert_answer_query = "INSERT INTO answers ( question_id, user_id, semester_id,exam_id, answer_text) VALUES ('$question_id','$getUser_id','$getUserSemester','$selected_option')";
                                            echo $insert_answer_query;
                                            die();
                                            // $insert_answer_query = "INSERT INTO answers (question_id, selected_option) VALUES ('$question_id', '$selected_option')";

                                            mysqli_query($conn, $insert_answer_query);

                                            // Optionally, you can also check the answer against the correct option
                                            // and update the exam_result table accordingly

                                            // For example:
                                            // Check if the selected option is correct
                                            // $check_correct_query = "SELECT correct_option FROM multiple_choice_questions WHERE question_id = '$question_id'";
                                            // $correct_option_result = mysqli_query($conn, $check_correct_query);
                                            // $correct_option_row = mysqli_fetch_assoc($correct_option_result);
                                            // $correct_option = $correct_option_row['correct_option'];
                                            // $is_correct = ($selected_option == $correct_option) ? 1 : 0;

                                            // // Update the exam_result table
                                            // $update_exam_result_query = "UPDATE exam_result SET mcq_score = mcq_score + $is_correct WHERE question_id = '$question_id'";
                                            // mysqli_query($conn, $update_exam_result_query);
                                        }
                                    }
                                }
                                ?>
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <?php
                                    $getExam_id = "SELECT exams.exam_id FROM fill_in_the_blanks INNER JOIN exams ON fill_in_the_blanks.exam_id = exams.exam_id";
                                    $exam_id_query = mysqli_query($conn,$getExam_id);
                                    $get_exam_id_as = mysqli_fetch_array($exam_id_query);
                                    $GET_ID_OF_EXAM =  $get_exam_id_as['exam_id'];
                                    // Retrieve and display MCQs questions and options
                                    $multiple_choice_questions = "SELECT * from multiple_choice_questions WHERE exam_id = '$GET_ID_OF_EXAM' ORDER BY RAND() limit 10";
                                    $query = mysqli_query($conn, $multiple_choice_questions);
                                    $count = 1;

                                    while ($row = mysqli_fetch_assoc($query)) {
                                    ?>
                                        <label for="" class="col-sm-12 col-form-label"><?php echo $count++ . ". " . $row['question_text'] ?></label>
                                        <div class="row mb-3">
                                            <div class="col-sm-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" value="A" type="radio" name="answer_<?php echo $row['question_id']; ?>" id="flexRadioDefault1">
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        <?php echo $row['option_a'] ?>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" value="B" type="radio" name="answer_<?php echo $row['question_id']; ?>" id="flexRadioDefault2">
                                                    <label class="form-check-label" for="flexRadioDefault2">
                                                        <?php echo $row['option_b'] ?>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" value="C" type="radio" name="answer_<?php echo $row['question_id']; ?>" id="flexRadioDefault3">
                                                    <label class="form-check-label" for="flexRadioDefault3">
                                                        <?php echo $row['option_c'] ?>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" value="D" type="radio" name="answer_<?php echo $row['question_id']; ?>" id="flexRadioDefault4">
                                                    <label class="form-check-label" for="flexRadioDefault4">
                                                        <?php echo $row['option_d'] ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                    <button type="submit" name="submit" class="btn btn-primary py-3 w-100 mb-4">Submit</button>
                                </form>

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
} else {
    header("location:./student.php");
}
?>