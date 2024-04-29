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
    </script>
    <?php
        header("location:./start_exam.php");
    // exit(); // Terminate the script
}

$getID = $_GET['id'];

$selectData = "DELETE FROM exams WHERE exams.exam_id = '$getID'";
$sql = mysqli_query($conn, $selectData);
if($sql){
    ?>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <button type="button" class="close btn" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Exam Deleted Successfully.</strong>
    </div>
    <script>
        $(".alert").alert();
    </script>
    <?php
    header("location:./start_exam.php");
}else{
    ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="close btn" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>Exam Can't Deleted.</strong>
        </div>
        <script>
            $(".alert").alert();
        </script>
        <?php
}
?>
