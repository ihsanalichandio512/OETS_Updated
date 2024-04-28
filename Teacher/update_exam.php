<?php
include "../db/dbConnection.php";

// Check if 'id' parameter is set in the URL
if (!isset($_GET['id'])) {
    ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <button type="button" class="close btn" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Exam Id not provided.</strong>
    </div>
    <script>
        $(".alert").alert();
        setTimeout(function() {
            window.location.href = "./start_exam.php";
        }, 2000);
    </script>
    <?php
    exit(); // Terminate the script
}

$getID = $_GET['id'];

$selectData = "SELECT * FROM exams WHERE exam_id = '$getID'";
$sql = mysqli_query($conn, $selectData);
$row = mysqli_fetch_array($sql);
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

        <div class="content">

            <div class="container-fluid">
                <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                        <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <a href="index.html" class="">
                                    <img src="../img/logo.png" class="w-100" alt="logo">
                                </a>
                            </div>
                            <h3 class="text-center">Update Exam</h3>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?php echo $getID; ?>" enctype="multipart/form-data">    
                            <div class="form-floating mb-3">
                                    <select name="exam_type" id="exam_type" class="form-select mb-3" aria-label="Exam Type">
                                        <option disabled>Exam Type</option>
                                        <option value="long_answer" <?php if ($row['exam_type'] == 'long_answer') echo 'selected'; ?>>Long Answers And Question</option>
                                        <option value="true_false" <?php if ($row['exam_type'] == 'true_false') echo 'selected'; ?>>True False</option>
                                        <option value="mcq" <?php if ($row['exam_type'] == 'mcq') echo 'selected'; ?>>Mcqs</option>
                                        <option value="fill_in_the_blanks" <?php if ($row['exam_type'] == 'fill_in_the_blanks') echo 'selected'; ?>>Fill In The Blank</option>
                                    </select>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="exam_duration_minutes" class="form-control" id="exam_duration_minutes" placeholder="Exam Duration" value="<?php echo $row['exam_duration_minutes']; ?>" required>
                                    <label for="floatingInput">Exam Duration</label>

                                </div>
                                <div class="form-floating mb-3">
                                    <?php
                                    // Check if exam_start_time is not null or empty before formatting it
                                    if (!empty($row['start_datetime']) && $row['start_datetime'] != '0000-00-00 00:00:00') {
                                        // Format the exam_start_time to match the format required by datetime-local input field
                                        $formatted_date = date('Y-m-d\TH:i', strtotime($row['start_datetime']));
                                    } else {
                                        // If exam_start_time is null or empty, set default value to current date and time
                                        $formatted_date = date('Y-m-d\TH:i');
                                    }
                                    ?>
                                    <input type="datetime-local" name="exam_start_time" class="form-control" id="exam_start_time" placeholder="Exam Start Date Time" value="<?php echo $formatted_date; ?>" required>
                                    <label for="exam_start_time">Exam Start Date Time</label>

                                </div>
                                <select name="exam_status" class="form-select mb-3" aria-label="Exam Status">
                                    <option disabled>Exam Status</option>
                                    <option value="active" <?php if ($row['exam_status'] == 'active') echo 'selected'; ?>>Active</option>
                                    <option value="inactive" <?php if ($row['exam_status'] == 'inactive') echo 'selected'; ?>>Inactive</option>
                                </select>

                                <select name="semester" class="form-select mb-3" aria-label="Select Semester">
                                    <option disabled>Select Semester</option>
                                    <?php
                                    // Query to fetch semester names from the semester table
                                    $semester_query = "SELECT semester_id, semester_name FROM semesters";
                                    $semester_result = mysqli_query($conn, $semester_query);

                                    // Loop through results and display options
                                    while ($row_semester = mysqli_fetch_assoc($semester_result)) {
                                        $selected = ($row_semester['semester_id'] == $row['semester_id']) ? 'selected' : '';
                                        echo "<option value='" . $row_semester['semester_id'] . "' " . $selected . ">" . $row_semester['semester_name'] . "</option>";
                                    }
                                    ?>
                                </select>

                                <select name="subject" class="form-select mb-3" aria-label="Select Subject">
                                    <option disabled>Select Subject</option>
                                    <?php
                                    // Query to fetch subject names from the subjects table
                                    $subject_query = "SELECT subject_id, subject_name FROM subjects";
                                    $subject_result = mysqli_query($conn, $subject_query);

                                    // Loop through results and display options
                                    while ($row_subject = mysqli_fetch_assoc($subject_result)) {
                                        $selected = ($row_subject['subject_id'] == $row['subject_id']) ? 'selected' : '';
                                        echo "<option value='" . $row_subject['subject_id'] . "' " . $selected . ">" . $row_subject['subject_name'] . "</option>";
                                    }
                                    ?>
                                </select>

                                <select name="teacher" class="form-select mb-3" aria-label="Select Teacher">
                                    <option disabled>Select Teacher</option>
                                    <?php
                                    // Query to fetch teacher names from the teacher table
                                    $teacher_query = "SELECT teachers.teacher_id, users.name 
                      FROM users 
                      INNER JOIN teachers ON users.user_id = teachers.user_id";
                                    $teacher_result = mysqli_query($conn, $teacher_query);

                                    // Loop through results and display options
                                    while ($row_teacher = mysqli_fetch_assoc($teacher_result)) {
                                        $selected = ($row_teacher['teacher_id'] == $row['teacher_id']) ? 'selected' : '';
                                        echo "<option value='" . $row_teacher['teacher_id'] . "' " . $selected . ">" . $row_teacher['name'] . "</option>";
                                    }
                                    ?>
                                </select>
                                <input type="hidden" name="id" value="<?php echo $getID; ?>">
                                <button type="submit" name="submit" class="btn btn-primary py-3 w-100 mb-4">Add</button>

                        </div>
                        <?php
                        if (isset($_POST['submit'])) {
                            $exam_type = $_POST['exam_type'];
                            $exam_duration_minutes = $_POST['exam_duration_minutes'];
                            $exam_start_time = $_POST['exam_start_time'];
                            $exam_status = $_POST['exam_status'];
                            $semester_id = $_POST['semester'];
                            $subject_id = $_POST['subject'];
                            $teacher_id = $_POST['teacher'];

                            $setnewVal = "UPDATE exams 
                     SET exam_type = '$exam_type', 
                         exam_duration_minutes = '$exam_duration_minutes', 
                         start_datetime = '$exam_start_time', 
                         exam_status = '$exam_status', 
                         semester_id = '$semester_id', 
                         subject_id = '$subject_id', 
                         teacher_id = '$teacher_id' 
                     WHERE exam_id = '$getID'";
                        $up = mysqli_query($conn, $setnewVal);
                        if ($up) {
                        ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button type="button" class="close btn" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>Exam Updated Successfully.</strong>
                            </div>
                            <script>
                                $(".alert").alert();
                                setTimeout(function() {
            window.location.href = "./start_exam.php";
        }, 2000);
                            
                            </script>

                        <?php

                        } else {
                        ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <button type="button" class="close btn" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>Exam can't Update.</strong>
                            </div>
                            <script>
                                $(".alert").alert();
                                setTimeout(function() {
            window.location.href = "./start_exam.php";
        }, 2000);
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