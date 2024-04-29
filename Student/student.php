<?php
session_start();
include "../db/dbConnection.php";
if($_SESSION['role_id']==3){
    header("location:../Teacher/teacher.php");
}elseif($_SESSION['role_id']==4){
    header("location:../Admin/admin.php");
}elseif($_SESSION['role_id']==1){
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
                    $getExamCheck = "SELECT * FROM `exams` WHERE exams.exam_status = 'active'";
                    $isCheated  = "SELECT * FROM users WHERE users.is_cheated = 'no' AND users.is_completed = 'not_completed' AND users.role_id = 1";
                    
                    $setuser = mysqli_query($conn,$isCheated);
                    $set = mysqli_query($conn,$getExamCheck);
                    $row = mysqli_fetch_array($set);
                    
                    if(mysqli_num_rows($set) && mysqli_num_rows($setuser)>0){
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
                    }else{
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
                        $sql = "";
                    ?>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-center p-4">
                            <div class="ms-3">
                                <p class="mb-2">Get Result</p>
                                <a href="" class="mb-0"><input type="button" class="btn btn-primary " value="Get Result"></a>
                            </div>
                        </div>
                    </div>
<?php 

?>
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-light rounded d-flex align-items-center justify-content-center p-4">
                            <div class="ms-3">
                                <p class="mb-2">Profile</p>
                                <a href="" class="mb-0"><input type="button" class="btn btn-primary " value="Profile"></a>
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