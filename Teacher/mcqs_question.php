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

                <div class="container-fluid pt-4 px-4">

                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">

                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Add Question" name="question" id="floatingTextarea" style="height: 150px;"></textarea>
                            <label for="floatingTextarea">Question</label>
                        </div>
                        <div class="form-floating mb-3">
                        <input type="text" name="option_1" class="form-control" id="floatingInput" placeholder="Option 1" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                        <label for="floatingInput">Option 1</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="option_2" class="form-control" id="floatingInput" placeholder="Option 2" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                        <label for="floatingInput">Option 2</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="option_3" class="form-control" id="floatingInput" placeholder="Option 3" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                        <label for="floatingInput">OPtion 3</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="option_4" class="form-control" id="floatingInput" placeholder="Option 4" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                        <label for="floatingInput">Option 4</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="marks" class="form-control" id="floatingInput" placeholder="Marks" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                        <label for="floatingInput">Marks</label>
                    </div>
                        <select name="answer" class="form-select mb-3" aria-label="Default select example">
                            <option selected disabled>Select Answer</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>

                        </select>
                        <select name="exam" class="form-select mb-3" aria-label="Default select example">
                            <option selected disabled>Exam</option>
                            <?php
                            $get = "SELECT exam_id,subjects.subject_name FROM exams 
                                        INNER join subjects ON exams.subject_id = subjects.subject_id WHERE exam_type = 'mcq'";
                            $res = mysqli_query($conn, $get);

                            while ($row = mysqli_fetch_array($res)) {
                            ?>
                                <option value="<?php echo $row['exam_id'] ?>"><?php echo $row['subject_name'] ?></option>
                            <?php
                            }
                            ?>


                        </select>

                        <button type="submit" name="add_question" class="btn btn-primary my-2">Save</button>
                    </form>
                    <?php
                    if (isset($_POST['add_question'])) {
                        $getquestion = $_POST['question'];
                        $getOptionA = $_POST['option_1'];
                        $getOptionB = $_POST['option_2'];
                        $getOptionC = $_POST['option_3'];
                        $getOptionD = $_POST['option_4'];
                        $getrightAnswer = $_POST['answer'];
                        $getMarks =$_POST['marks'];
                        $getexam = $_POST['exam'];

                        $check = "SELECT * FROM multiple_choice_questions WHERE question_text = '$getquestion'";
                        $getChecked = mysqli_query($conn, $check);
                        if (mysqli_num_rows($getChecked) > 0) {
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
                        }else{
                            $addtrue = "INSERT INTO multiple_choice_questions( question_text, option_a, option_b, option_c, option_d, correct_option, exam_id,question_mark) VALUES ('$getquestion','$getOptionA','$getOptionB','$getOptionC','$getOptionD','$getrightAnswer','$getexam','$getMarks')";
                            
                            $add =  mysqli_query($conn, $addtrue);
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
                        }
                    }
                    ?>
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