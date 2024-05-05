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


    $getExam_id = "SELECT exams.exam_id FROM multiple_choice_questions INNER JOIN exams ON multiple_choice_questions.exam_id = exams.exam_id";
    $gettt = mysqli_query($conn,$getExam_id);
    $get_exam_id_as = mysqli_fetch_array($gettt);
    $GET_ID_OF_EXAM =  $get_exam_id_as['exam_id'];

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
    $get_exam_details = mysqli_fetch_array($set);
    $get_student_details = mysqli_fetch_array($setuser);
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
                <?php
                $get_exam_duration_query = "SELECT exam_duration_minutes FROM exams WHERE exam_id = '$GET_ID_OF_EXAM'"; // Assuming you have an exam_id available
                $getTime = mysqli_query($conn, $get_exam_duration_query);
                $getTimer = mysqli_fetch_array($getTime);
                $counter = $getTimer['exam_duration_minutes'];
                // $hours = $counter * 3600;

               ?>
                <script>
                    window.onload = function() {
                        var duration_hours = <?php echo $counter; ?>; // Duration of the exam in seconds
                        var duration_seconds = duration_hours * 3600; // Convert hours to seconds
                        var timerDisplay = document.getElementById('timer');

                        var startTime = localStorage.getItem('startTime');
                        var storedDuration = localStorage.getItem('duration');

                        if (startTime && storedDuration) {
                            var elapsedTime = Math.floor((new Date().getTime() - startTime) / 1000);
                            duration_seconds = storedDuration - elapsedTime;
                            if (duration_seconds < 0) {
                                duration_seconds = 0;
                            }
                        } else {
                            // Store the start time and duration in local storage
                            localStorage.setItem('startTime', new Date().getTime());
                            localStorage.setItem('duration', duration_seconds);
                        }

                        function updateTimer() {
                            var hours = Math.floor(duration_seconds / 3600);
                            var minutes = Math.floor((duration_seconds % 3600) / 60);
                            var seconds = duration_seconds % 60;

                            timerDisplay.textContent = hours + 'h ' + minutes + 'm ' + seconds + 's';

                            if (duration_seconds <= 0) {
                                clearInterval(timerInterval); // Stop the timer
                                // Auto-submit the exam by submitting the form or any other action
                                // document.getElementById('examForm').submit(); // Replace 'examForm' with your form ID
                            }

                            duration_seconds--; // Decrement the duration

                            // Update local storage with current start time and remaining duration
                            localStorage.setItem('startTime', new Date().getTime());
                            localStorage.setItem('duration', duration_seconds);
                        }

                        // Update the timer every second
                        var timerInterval = setInterval(updateTimer, 1000);

                        
                    };
                </script>

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
                            <div id="timer" class="h2 text-center"></div>
                            <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                                <h3 class="text-center">MCQS</h3>
                                <?php
                                $multiple_choice_questions = "SELECT * FROM multiple_choice_questions WHERE multiple_choice_questions.exam_id = '$GET_ID_OF_EXAM' ORDER BY RAND()  LIMIT 10";
                                $query = mysqli_query($conn, $multiple_choice_questions);
                                $count = 1;
                            
?>
                                <form method="post" id="examForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <?php
                                    while ($row = mysqli_fetch_assoc($query)) {
                                        $question_id = $row['question_id'];
                                    ?>
                                        <label for="" class="col-sm-12 col-form-label"><?php echo $count++ . ". " . $row['question_text'] ?></label>
                                        <div class="row mb-3">
                                            <div class="col-sm-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" value="A" type="radio" name="answer_<?php echo $question_id; ?>" id="flexRadioDefault1">
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        <?php echo $row['option_a'] ?>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" value="B" type="radio" name="answer_<?php echo $question_id; ?>" id="flexRadioDefault2">
                                                    <label class="form-check-label" for="flexRadioDefault2">
                                                        <?php echo $row['option_b'] ?>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" value="C" type="radio" name="answer_<?php echo $question_id; ?>" id="flexRadioDefault3">
                                                    <label class="form-check-label" for="flexRadioDefault3">
                                                        <?php echo $row['option_c'] ?>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" value="D" type="radio" name="answer_<?php echo $question_id; ?>" id="flexRadioDefault4">
                                                    <label class="form-check-label" for="flexRadioDefault4">
                                                        <?php echo $row['option_d'] ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <button type="submit" id="submitBtn" name="submit" class="btn btn-primary py-3 w-100 mb-4">Submit</button>
                                </form>

                                <?php
                                if (isset($_POST['submit'])) {
                                    foreach ($_POST as $key => $value) {
                                        if (strpos($key, 'answer_') !== false) {
                                            $question_id = substr($key, strlen('answer_'));
                                            $answer = $_POST[$key];
                                            $getUser_id = $_SESSION['user_id'];
                                            $getUserSemester = $_SESSION['semester_id'];
                                            $get_batch_id = "SELECT students.batch_id FROM students WHERE students.user_id = '$getUser_id'";
                                                $runBatch_query = mysqli_query($conn,$get_batch_id);
                                                $Got_batch_id = mysqli_fetch_array($runBatch_query);
                                                $batch_id = $Got_batch_id['batch_id'];
                                            $insert_query = "
                                                    INSERT INTO `answers`(question_id,user_id, semester_id,exam_id,batch_id, answer_text,question_type) VALUES ('$question_id','$getUser_id','$getUserSemester','$GET_ID_OF_EXAM','$batch_id','$answer','multiple_choice_questions')
                                                    ";

                                                    // echo $insert_query."<br>";
                                                    // die();

                                            $store_question = mysqli_query($conn, $insert_query);
                                            if ($store_question) {
                                                echo "success";
                                                $update = "UPDATE multiple_choice_questions SET is_completed = 'completed' WHERE multiple_choice_questions.exam_id = '$GET_ID_OF_EXAM'";
                                                $upadted = mysqli_query($conn, $update);
                                                ?>
                                                <script>
                                                    clearInterval(timerInterval);
                                                </script>
                                                <?php
                                                 echo "<script>window.location.href = './give_exam.php'</script>";
                                            } else {
                                                echo "Unsuccess";
                                            }
                                        // }
                                    }
                                }
                            }
                                ?>

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