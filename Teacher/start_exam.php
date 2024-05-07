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

                <div class="container-fluid pt-4 px-4">
                <div class="col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Exams</h6>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Exam Id</th>
                                            <th scope="col">Start Time</th>
                                            <th scope="col">Exam Type</th>
                                            <th scope="col">Semester</th>
                                            <th scope="col">Subject</th>
                                            <th scope="col">Teacher</th>
                                            <th scope="col">Status</th>
                                            <th scope="col" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "
                                        SELECT 
                                        exams.exam_id, 
                                        start_datetime,
                                        exam_type,
                                        semesters.semester_name,
                                        subjects.subject_name,
                                        users.name,
                                        exam_status
                                        FROM exams
                                        INNER JOIN semesters on exams.semester_id = semesters.semester_id
                                        INNER JOIN subjects ON exams.subject_id = subjects.subject_id
                                        INNER JOIN teachers ON exams.teacher_id = teachers.teacher_id
                                        INNER JOIN users ON teachers.user_id = users.user_id
                                        
                                        ";

                                        $res = mysqli_query($conn,$sql);

                                while($row = mysqli_fetch_assoc($res)){

                                
                                        ?>

                                        <tr>
                                            <th scope="row"><?php echo $row['exam_id']?></th>
                                            <td><?php echo $row['start_datetime'] ?></td>
                                            <td><?php echo $row['exam_type'] ?></td>
                                            <td><?php echo $row['semester_name']?></td>
                                            <td><?php echo $row['subject_name']?></td>
                                            <td><?php echo $row['name']?></td>
                                            <td><?php echo $row['exam_status']?></td>
                                            <td>
                                                <div class="btn-group">
                                                <a href="./setExam.php?id=<?php echo $row['exam_id']; ?>" class="btn btn-success btn-sm">Start</a>
                                                
                                                <a href="./update_exam.php?id=<?php echo isset($row['exam_id']) ? $row['exam_id'] : ''; ?>" class="btn btn-warning btn-sm">Update</a>
                                                <a href="./delete_exam.php?id=<?php echo $row['exam_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
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
}else{
    header("location:../index.php");
}
?>