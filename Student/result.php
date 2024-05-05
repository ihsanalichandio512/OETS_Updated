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
        <style>
            .marksheet {
                width: 80%;
                margin: 0 auto;
                border: 1px solid #ddd;
            }

            .student-picture {
                width: 100px;
                height: 100px;
            }
        </style>
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
            <?php
            include "../includes/sidebar.php";
            ?>
            <div class="content">

                <?php
                include "../includes/navbar.php";
                $getExam_id = "SELECT exams.exam_id FROM fill_in_the_blanks INNER JOIN exams ON fill_in_the_blanks.exam_id = exams.exam_id";
                $exam_id_query = mysqli_query($conn, $getExam_id);
                $get_exam_id_as = mysqli_fetch_array($exam_id_query);

                $getstudent_detail = "SELECT * FROM students WHERE students.user_id = '$user_id'";
                $students_query = mysqli_query($conn, $getstudent_detail);


                $data = mysqli_fetch_assoc($students_query);



                $user_id = $_SESSION['user_id'];
                $GET_ID_OF_EXAM =  $get_exam_id_as['exam_id'];
                $semester_id = $_SESSION['semester_id'];
                $batch_id = $data['batch_id'];

                $getsemesterName = "SELECT * FROM semesters where semesters.semester_id = '$semester_id'";
                $fetch_semester = mysqli_query($conn, $getsemesterName);
                $semesterData = mysqli_fetch_array($fetch_semester);
                $semesterName = $semesterData['semester_name'];

                $get_examName = "SELECT exams.exam_type FROM exams where exams.semester_id = '$semester_id'";

                $fetchExam_type = mysqli_query($conn, $get_examName);
                $dataofExam = mysqli_fetch_assoc($fetchExam_type);
                $exam_type = $dataofExam['exam_type'];
                // Fetch user details from the database
                $user_id = $_SESSION['user_id'];
                $sql = "SELECT name, user_photo FROM users JOIN roles ON users.role_id = roles.role_id WHERE user_id = '$user_id'";
                $result = $conn->query($sql);

                $row = $result->fetch_assoc();
                $user_name = $row['name'];
                $user_photo = $row['user_photo'];



                $getExam_result = "
                SELECT exam_results.long_answer_score,exam_results.mcq_score,exam_results.true_false_score,
                exam_results.fill_in_the_blanks_score,exam_results.score,exam_results.total_questions
                FROM exam_results
                WHERE student_id = '$user_id'
                ";

                $fetchExam_detail = mysqli_query($conn, $getExam_result);

                $exam_detail = mysqli_fetch_assoc($fetchExam_detail);

                $long_answer_score = $exam_detail['long_answer_score'];
                $mcq_score = $exam_detail['mcq_score'];
                $true_false_score = $exam_detail['true_false_score'];
                $fill_in_the_blanks_score = $exam_detail['fill_in_the_blanks_score'];
                $score = $exam_detail['score'];
                $total_questions = $exam_detail['total_questions'];
                ?>
                <div class="container mt-5">
                    <div class="card marksheet">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Marksheet</h5>
                            <img class="img-thumbnail rounded-circle student-picture" alt="Student Picture" src=".<?php echo $user_photo; ?>" alt="User Photo">
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th scope="row">Student Name</th>
                                        <td><?php echo $user_name; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Student ID</th>
                                        <td><?php echo $user_id; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Semester</th>
                                        <td><?php echo $semesterName; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Exam</th>
                                        <td><?php echo $exam_type; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th scope="col">Fill In The Blanks Marks</th>
                                        <th scope="col">MCQS Marks</th>
                                        <th scope="col">Long Answers Marks</th>
                                        <th scope="col">True False Marks</th>
                                        <th scope="col">Total Marks</th>
                                        <th scope="col">Attempt Questions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $fill_in_the_blanks_score; ?></td>
                                        <td><?php echo $mcq_score; ?></td>
                                        <td><?php echo $long_answer_score; ?></td>
                                        <td><?php echo $true_false_score; ?></td>
                                        <td><?php echo $score; ?></td>
                                        <td><?php echo $total_questions; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <form action="download_marksheet.php" method="post">
                                <input type="hidden" name="user_name" value="<?php echo $user_name; ?>">
                                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                <button type="submit">Download PDF</button>
                            </form>

                            <?php
                            // Access form data
                            $user_name = $_POST['user_name'];
                            $user_id = $_POST['user_id'];
                            // ... retrieve other data from form

                            // Include PDF library (e.g., mPDF)
                            // require_once('mpdf/vendor/autoload.php');
                            require_once('../vendor/autoload.php');

                            // $mpdf = new \Mpdf\Mpdf();
                            use Mpdf\Mpdf;

                            // Construct PDF content with marksheet data
                            $html = '
  <h1>Marksheet</h1>
  <p>Student Name: ' . $user_name . '</p>
  ';

                            $mpdf->WriteHTML($html);

                            // Set headers and output PDF
                            $mpdf->Output('marksheet.pdf', \Mpdf\Output\Destination::DOWNLOAD);

                            exit; // Important to stop further script execution

                            ?>
                        </div>
                    </div>
                </div>

                

                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-OgwbZS7/BXzYznvBMqUKE1l+sUSyM9j/tznwIcbsoDkLN5OA04sRuxzOMjvt+z" crossorigin="anonymous"></script>

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