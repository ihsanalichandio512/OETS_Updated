<?php
session_start();
    include "../db/dbConnection.php";
    if($_SESSION['role_id']==1){
        header("location:../Student/student.php");
    }elseif($_SESSION['role_id']==4){
        header("location:../Admin/admin.php");
    }elseif($_SESSION['role_id']==3){
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

                <div class="container-fluid">
                    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                            <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                                <div class="d-flex align-items-center justify-content-center mb-3">
                                    <a href="index.html" class="">
                                        <img src="../img/logo.png" class="w-100" alt="logo">
                                    </a>
                                </div>
                                <h3 class="text-center">Add Exam</h3>
                                <!-- <form action="register.php" method="post"> -->
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">        
                                    <div class="form-floating mb-3">
                                        <select name="exam_type" id="exam_type" class="form-select mb-3" aria-label="Default select example">
                                            <option selected disabled>Exam Type</option>
                                            <option value="class_test">Class Test</option>
                                            <option value="entry_test">Entry Test</option>
                                            <option value="internal_exam">Internal Exam</option>
                                            <option value="external_exam">External Exam</option>
                                        </select>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" id="exam_duration_minutes" name="exam_duration_minutes" required class="form-control" id="floatingInput" placeholder="name@example.com" required>
                                        <label for="floatingInput">Exam Duration</label>

                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="datetime-local" id="exam_start_time" name="exam_start_time" required class="form-control" id="floatingInput" placeholder="name@example.com" required>
                                        <label for="floatingInput">Exam Start Date Time</label>

                                    </div>
                                    <select name="exam_status" class="form-select mb-3" aria-label="Default select example">
                                        <option selected disabled>Exam Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>

                                    <select name="semester" class="form-select mb-3" aria-label="Default select example">
                                    <option selected disabled value="">Select Semester</option>
                                        
                                        <?php
                                            

                                            // Query to fetch semester names from the semester table
                                            $semester_query = "SELECT semester_id, semester_name FROM semesters";
                                            $semester_result = mysqli_query($conn, $semester_query);

                                            // Loop through results and display options
                                            while ($row = mysqli_fetch_assoc($semester_result)) {
                                                echo "<option value='" . $row['semester_id'] . "'>" . $row['semester_name'] . "</option>";
                                            }
                                            ?>
                                    </select>

                                    <select name="subject" class="form-select mb-3" aria-label="Default select example">
                                    <option selected disabled value="">Select Subject</option>
                                    
                                    <?php
                                       
                                        $subject_query = "SELECT subject_id, subject_name FROM subjects";
                                        $subject_result = mysqli_query($conn, $subject_query);

                                        // Loop through results and display options
                                        while ($row = mysqli_fetch_assoc($subject_result)) {
                                            echo "<option value='" . $row['subject_id'] . "'>" . $row['subject_name'] . "</option>";
                                        }
                                        ?>
                                    </select>


                                    <select name="teacher" class="form-select mb-3" aria-label="Default select example">
                                    <option selected disabled value="">Select Teacher</option>
                                    <?php
                                    // Query to fetch teacher names from the teacher table
                                    $teacher_query = "SELECT teachers.teacher_id, users.name 
                                    FROM users 
                                    INNER JOIN teachers ON users.user_id = teachers.user_id";
                                    $teacher_result = mysqli_query($conn, $teacher_query);

                                    // Loop through results and display options
                                    while ($row = mysqli_fetch_assoc($teacher_result)) {
                                        echo "<option value='" . $row['teacher_id'] . "'>" . $row['name'] . "</option>";
                                    }
                                    ?>
                                    </select>

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

                                $ssql = "SELECT subject_id,exam_type FROM exams WHERE exams.subject_id = $subject_id AND exams.exam_type = '$exam_type'";
                               
                                $check = mysqli_query($conn,$ssql);
                                
                                if (mysqli_num_rows($check) > 0) {
                            ?>
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <button type="button" class="close btn" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <strong>Subject and Exam already exists.</strong>
                                    </div>
                                    <script>
                                        $(".alert").alert();
                                    </script>
                                    <?php
                                } else {
                                    // Insert data into the database
                                    $insertSql = "INSERT INTO exams ( exam_type, exam_duration_minutes,start_datetime, exam_status,semester_id,subject_id,teacher_id) 
                                    VALUES ( '$exam_type', '$exam_duration_minutes', '$exam_start_time','$exam_status','$semester_id','$subject_id','$teacher_id')";
                                  
                                   $insertResult = mysqli_query($conn, $insertSql);

                                    if ($insertResult) {
                                    ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <button type="button" class="close btn" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <strong>Data has been added successfully.</strong>
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
                                            <strong>Failed to add data.</strong>
                                        </div>
                                        <script>
                                            $(".alert").alert();
                                        </script>
                            <?php
                                    }
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
    <?php
}else{
    header("location:../index.php");
}
?>