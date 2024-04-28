<?php
// Check if user is logged in
if(isset($_SESSION['user_id']) && isset($_SESSION['role_id'])) {
    // User is logged in
    // Fetch user details from the database using user_id from session

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch user details from the database
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT name, user_photo, role_name FROM users JOIN roles ON users.role_id = roles.role_id WHERE user_id = '$user_id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $user_name = $row['name'];
        $user_photo = $row['user_photo'];
        $user_role = $row['role_name'];
    }
} else {
    // User is not logged in, you can handle this case accordingly
    // For example, redirect to login page
    header("Location: index.php");
    exit();
}
?>
<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="admin_dashboard.php" class="navbar-brand mx-4 mb-3">
            <img src="../img/logo.png" class="w-100" alt="logo">
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
               
            <?php if (!empty($user_photo)) { ?>
                    <img class="rounded-circle" src=".<?php echo $user_photo; ?>" alt="User Photo" style="width: 40px; height: 40px;">
                    <?php }  ?>
                    <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0"><?php echo $user_name; ?></h6>
                <span><?php echo $user_role; ?></span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <?php
            if($_SESSION['role_id'] == 4){
               ?> 
            <a href="../Admin/admin.php" class="nav-item nav-link">Admin Dashboard</a>
            <a href="../Admin/add_teacher.php" class="nav-item nav-link">Add Teacher</a>
            <a href="../Admin/add-semester.php" class="nav-item nav-link">Add Semester</a>
            <a href="../Admin/add_subjects.php" class="nav-item nav-link">Add Subject</a>
            <?php
            }else if($_SESSION['role_id'] == 3){
            ?>
            <a href="../Teacher/add_exam.php" class="nav-item nav-link">Add Exam</a>
            <a href="../Teacher/add_question.php" class="nav-item nav-link">Add Question</a>
            <a href="../Teacher/add_answer.php" class="nav-item nav-link">Add Answers</a>            
            <a href="../Teacher/start_exam.php" class="nav-item nav-link">Start Exam</a>
            <!-- <a href="../Teacher/mark_attendance.php" class="nav-item nav-link">Mark Attendance</a> -->
            <?php
            }
            else if($_SESSION['role_id'] == 1){
                ?>
                <a href="" class="nav-item nav-link">Get Result</a>
                <a href="" class="nav-item nav-link">Profile</a>            
                <?php
                }
            ?>
            
        </div>
    </nav>
</div>
<!-- Sidebar End -->